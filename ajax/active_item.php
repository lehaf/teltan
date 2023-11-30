<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Localization\Loc;

CModule::IncludeModule('iblock');
$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();
$boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
$productId = $_REQUEST['data']['itemId'];
$iblockId = $_REQUEST['data']['iblockId'];
$oneDayToSecond = 86400;
$iblocksIdToCode = [
    1 => 'FLEA',
    2 => 'PROPERTY',
    3 => 'AUTO',
    7 => 'AUTO',
    8 => 'AUTO',
];

$iblockClass = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass();
$element = $iblockClass::getByPrimary($productId, array(
    'select' => array('ID', 'NAME', 'ACTIVE_TO', 'FREE_AD'),
))->fetchObject();

$isFreeAd = !empty($element->getFreeAd()) && $element->getFreeAd()->getValue() > 0;
$isAdNotExpired = !empty($element->getActiveTo()) && strtotime($element->getActiveTo()) > time();
$canUserCreateAds = canUserCreateAds($iblockId, $iblocksIdToCode[$iblockId]) === true ? true : $isAdNotExpired;

/** ДЕАКТИВАЦИЯ ЭЛЕМЕНТА */
if ($_REQUEST['value'] == 'green') {
    $updateFields['ACTIVE'] = "N";
    echo Loc::getMessage('DEACTIVATE_ITEM');
    deleteFavoritesUser($productId);
    /** АКТИВАЦИЯ ЭЛЕМЕНТА */
} else {
    if ($isFreeAd) {
        $newExpiredTimeFreeAdd = time() + DAYS_EXPIRED_FREE_ADS * $oneDayToSecond;
        $updateFields['ACTIVE'] = "Y";
        $updateFields['ACTIVE_TO'] = \Bitrix\Main\Type\DateTime::createFromTimestamp($newExpiredTimeFreeAdd);
        echo Loc::getMessage('ACTIVATE_ITEM');
    } else {
        if (isAdBelongToActiveRate($productId, $iblocksIdToCode[$iblockId])) {
            $updateFields['ACTIVE'] = "Y";
            echo Loc::getMessage('ACTIVATE_ITEM');
        } else {
            if ($canUserCreateAds) {
                if ($_REQUEST['value'] == 'red') {
                    // Получаем всю инфу о самом первом активном купленном пакете
                    $optimalUserRate = getOptimalActiveUserRate($iblocksIdToCode[$iblockId]);
                    if (!empty($optimalUserRate)) {
                        // Обновление пользовательских пакетов (Кпленных тарифов)
                        $countAvailableAds = $optimalUserRate['UF_COUNT_REMAIN'] - $optimalUserRate['UF_COUNT_LESS'];
                        $unixTimeUntilUserRate = strtotime($optimalUserRate['UF_DATE_EXPIRED']);
                        $countActiveRateDays = floor(($unixTimeUntilUserRate - time()) / (60 * 60 * 24));
                        if (!empty($optimalUserRate['UF_DATE_PURCHASE']) && $countAvailableAds > 0 && time() < $unixTimeUntilUserRate) {
                            $optimalUserRate['UF_ID_ANONC'][] = intval($productId);
                            $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
                            $boughtRateEntity::update($optimalUserRate['ID'], array(
                                'UF_COUNT_LESS' => ++$optimalUserRate['UF_COUNT_LESS'],
                                'UF_ID_ANONC' => $optimalUserRate['UF_ID_ANONC'],
                                'UF_DAYS_REMAIN' => $countActiveRateDays
                            ));

                            $updateFields['ACTIVE'] = "Y";
                            $time = strtotime($optimalUserRate['UF_DATE_EXPIRED']);
                            $updateFields['ACTIVE_TO'] = \Bitrix\Main\Type\DateTime::createFromTimestamp($time);

                            echo Loc::getMessage('ACTIVATE_ITEM');
                        } else {
                            echo Loc::getMessage('END_RATE');
                        }
                    } else {
                        echo Loc::getMessage('END_RATE');
                    }
                }
            } else {
                echo Loc::getMessage('END_RATE');
            }
        }
    }
}

if (!empty($updateFields)) {
    $el = new CIBlockElement;
    $el->Update($productId, $updateFields);
}

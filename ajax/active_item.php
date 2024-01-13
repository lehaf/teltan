<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Localization\Loc;

\CModule::IncludeModule('iblock');
$operationResult = '';
$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();
$boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
$productId = $_REQUEST['itemId'];
$iblockId = $_REQUEST['iblockId'];
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
    'select' => [
        'ID',
        'NAME',
        'ACTIVE',
        'ACTIVE_TO',
        'FREE_AD'
    ],
))->fetchObject();
$isFreeAd = !empty($element->getFreeAd()) && $element->getFreeAd()->getValue() > 0;
$isAdNotExpired = !empty($element->getActiveTo()) && strtotime($element->getActiveTo()) > time();
$canUserCreateAds = canUserCreateAds($iblockId, $iblocksIdToCode[$iblockId]) === true ? true : $isAdNotExpired;

/** ДЕАКТИВАЦИЯ ЭЛЕМЕНТА */
if ($_REQUEST['value'] == 'green') {
    $updateFields['ACTIVE'] = "N";
    $operationResult = Loc::getMessage('DEACTIVATE_ITEM');
    deleteFavoritesUser($productId); // удаляем из избранного
    deleteAdFromUserRate($productId, $iblockId); // удаляем из купленного тарифа
    /** АКТИВАЦИЯ ЭЛЕМЕНТА */
} else {
    // Если объявление бесплатное
    if ($isFreeAd) {
        $newExpiredTimeFreeAdd = time() + DAYS_EXPIRED_FREE_ADS * $oneDayToSecond;
        $updateFields['ACTIVE'] = true;
        $updateFields['ACTIVE_TO'] = \Bitrix\Main\Type\DateTime::createFromTimestamp($newExpiredTimeFreeAdd);
        $operationResult = Loc::getMessage('ACTIVATE_ITEM');
    } else {
        // Если не существует бесплатных объявлений
        if (!isExistActiveFreeAd($iblocksIdToCode[$iblockId])) {
            $newExpiredTimeFreeAdd = time() + DAYS_EXPIRED_FREE_ADS * $oneDayToSecond;
            if ($freeAdPropVal = getPropertyFreeAdValueId($iblockId)) $updateFields['FREE_AD'] = $freeAdPropVal;
            $updateFields['ACTIVE'] = true;
            $updateFields['ACTIVE_TO'] = \Bitrix\Main\Type\DateTime::createFromTimestamp($newExpiredTimeFreeAdd);
            // удаляем у всех существуещих объявлений этого пользователя чекбокс "бесплатное объявление"
            removeFreeAdPropOnAds($iblocksIdToCode[$iblockId]);
            if ($canUserCreateAds)  deleteAdFromUserRate($productId, $iblockId); // удаляем из купленного тарифа (если это объявление там было)
            $operationResult = Loc::getMessage('ACTIVATE_ITEM');
        } else {
            // если у пользователя активен платный тариф
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

                            $updateFields['ACTIVE'] = true;
                            $time = strtotime($optimalUserRate['UF_DATE_EXPIRED']);
                            $updateFields['ACTIVE_TO'] = \Bitrix\Main\Type\DateTime::createFromTimestamp($time);

                            $operationResult = Loc::getMessage('ACTIVATE_ITEM');
                        } else {
                            $operationResult = Loc::getMessage('END_RATE');
                        }
                    } else {
                        $operationResult = Loc::getMessage('END_RATE');
                    }
                }
            } else {
                $operationResult = Loc::getMessage('END_RATE');
            }
        }
    }
}

// Обновляем элемент
if (!empty($updateFields)) {
    if (!empty($element)) {
        foreach ($updateFields as $propCode => $propVal) {
            $element->set($propCode, $propVal);
        }
        $element->save();

//        // чистим кэш
//        $taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();
//        $taggedCache->clearByTag('iblock_id_'.$iblockId);
    }
}

echo $operationResult;
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

if (Loader::includeModule("iblock") && Loader::includeModule("highloadblock") && !empty($_REQUEST['item'])) {
    global $USER;
    // Удаляем объявление из инфоблока а также уменьшаем счетчик созданных объявлений пользователя
    $itemId = intval($_REQUEST['item']);
    $item = \Bitrix\Iblock\ElementTable::getList(array(
        'select' => array('ID', 'IBLOCK_ID'),
        'filter' => array('ID' => $itemId),
    ))->fetch();


    $iblockIdToPropCountAds = [
        1 => "UF_COUNT_FLEA",
        2 => "UF_COUNT_PROPERTY",
        3 => "UF_COUNT_AUTO",
        7 => "UF_COUNT_AUTO",
        8 => "UF_COUNT_AUTO",
    ];

    $iblockIdToPropIdAds = [
        1 => "UF_COUNT_ITEM_FLEA",
        2 => "UF_COUNT_ITEM_PROP",
        3 => "UF_COUNT_ITEM_AUTO",
        7 => "UF_COUNT_ITEM_AUTO",
        8 => "UF_COUNT_ITEM_AUTO",
    ];

    if (!empty($item)) {
        $userPropCountAdsName = $iblockIdToPropCountAds[$item['IBLOCK_ID']];
        $arUser = CUser::GetByID($USER->GetID())->Fetch();
        if (!empty($userPropCountAdsName) && !empty($arUser[$userPropCountAdsName])) {
            $user = new \CUser;
            $countAds = $arUser[$userPropCountAdsName];
            $fields = array(
                $userPropCountAdsName => $countAds !== 0 ? --$countAds : 0,
            );
            // Обновляем список id созданных пользователем объявлений
            if (!empty($iblockIdToPropIdAds[$item['IBLOCK_ID']])) {
                $propIdAdsName = $iblockIdToPropIdAds[$item['IBLOCK_ID']];

                if (!empty($arUser[$propIdAdsName])) {
                    $key = array_search($itemId, $arUser[$propIdAdsName]);
                    if ($key !== false) {
                        unset($arUser[$propIdAdsName][$key]);
                        $fields[$propIdAdsName] = $arUser[$propIdAdsName];
                    }
                }
            }

            $user->Update($USER->GetID(), $fields);
        }
        CIBlockElement::Delete($itemId);
        deleteAdFromUserRate($itemId, $item['IBLOCK_ID']);
    }

    // Удаляем объявление из таблицы избранного пользователей
    $entity = GetEntityDataClass(PERSONAL_FAVORITE_HL_ID);
    $favoriteItem = $entity::getList(array(
        'select' => array('*'),
        'filter' => array('UF_ID_USER'=> $USER->GetID(), 'UF_ID_AD'=> $itemId),
    ))->fetchObject();

    if ($favoriteItem) $favoriteItem->delete();
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");

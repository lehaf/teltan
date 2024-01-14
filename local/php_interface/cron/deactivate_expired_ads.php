<?php

/** Деактивируем объявления у которых истек срок активности */

$_SERVER['DOCUMENT_ROOT'] = '/home/bitrix/www';
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';

$iblocks = [
    SIMPLE_ADS_IBLOCK_ID,
    PROPERTY_ADS_IBLOCK_ID,
    AUTO_IBLOCK_ID,
    MOTO_IBLOCK_ID,
    SCOOTER_IBLOCK_ID
];

if (\Bitrix\Main\Loader::includeModule('iblock')) {
    $curTime =  date("Y-m-d H:i:s", time());
    foreach ($iblocks as $iblockId) {
        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass();
        $collection = $iblockClass::getList(array(
            'select' => ['ID', 'ACTIVE', 'ACTIVE_TO'],
            'filter' => ['ACTIVE' => 'Y', ["LOGIC" => "OR", ['<ACTIVE_TO' => $curTime],['=ACTIVE_TO' => false]]]
        ))->fetchCollection();

        foreach ($collection as $ad) {
            $ad->setActive(false);
            if (empty($ad->getActiveTo())) $ad->setActiveTo($curTime);
            deleteFavoritesUser($ad->getId());
        }
        $res = $collection->save();
    }
}

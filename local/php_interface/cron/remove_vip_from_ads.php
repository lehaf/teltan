<?php

/** Очищаем вип свойства у объявлений у которых истек VIP */
/** Этот крон-скрипт необходим что бы кэширование сайта работало максимально оптимально */

$_SERVER['DOCUMENT_ROOT'] = '/var/www/u166558/data/www/bysel.co.il';
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
            'select' => ['ID', 'VIP_DATE', 'VIP_FLAG'],
            'filter' => [
                '<VIP_DATE.VALUE' => $curTime,
                '!VIP_DATE.VALUE' => false,
            ]
        ))->fetchCollection();

        foreach ($collection as $ad) {
            // Удаляем у элемента вип свойства
            $ad->setVipDate(false);
            $ad->setVipFlag(false);
        }
        $res = $collection->save();

        // чистим кэш
        if ($collection->count() > 0) {
            $taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();
            $taggedCache->clearByTag('iblock_id_'.$iblockId);
        }
    }
}

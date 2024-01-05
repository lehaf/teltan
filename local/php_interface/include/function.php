<?php

use \Bitrix\Main\Type\DateTime;

function pr($o, $show = false, $die = false, $fullBackTrace = false)
{
    global $USER;
//    if ($USER->IsAdmin() && $USER -> GetId() == 1100 || $show) {
    if ($USER->IsAdmin() || $show) {
        $bt = debug_backtrace();

        $firstBt = $bt[0];
        $dRoot = $_SERVER["DOCUMENT_ROOT"];
        $dRoot = str_replace("/", "\\", $dRoot);
        $firstBt["file"] = str_replace($dRoot, "", $firstBt["file"]);
        $dRoot = str_replace("\\", "/", $dRoot);
        $firstBt["file"] = str_replace($dRoot, "", $firstBt["file"]);
        ?>
        <div style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;'>
            <div style='padding:3px 5px; background:#99CCFF;'>

                <? if ($fullBackTrace == false): ?>
                    File: <b><?= $firstBt["file"] ?></b> [line: <?= $firstBt["line"] ?>]
                <? else: ?>
                    <? foreach ($bt as $value): ?>
                        <?
                        $dRoot = str_replace("/", "\\", $dRoot);
                        $value["file"] = str_replace($dRoot, "", $value["file"]);
                        $dRoot = str_replace("\\", "/", $dRoot);
                        $value["file"] = str_replace($dRoot, "", $value["file"]);
                        ?>
                        File: <b><?= $value["file"] ?></b> [line: <?= $value["line"] ?>] <?= $value['class'] . '->'.$value['function'].'()'?><br>
                    <? endforeach ?>
                <?endif; ?>
            </div>
            <pre style='padding:10px;'><? is_array($o) ? print_r($o) :  print_r(htmlspecialcharsbx($o)) ?></pre>
        </div>
        <?if ($die == true) die(); ?>
        <?
    } else {
        return false;
    }
}

function getHLData(int $hlBlockId, array $select = [], array $filter = []) : array
{
    $hlBlockTable = \Bitrix\Highloadblock\HighloadBlockTable::getById($hlBlockId)->fetch();
    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlBlockTable);
    $hlClass = $entity->getDataClass();
    $res = $hlClass::getList(array(
        'select' => !empty($select) ? $select : ['*'],
        'filter' => $filter,
        'cache' => [
            'ttl' => 36000000,
            'cache_joins' => true
        ]
    ))->fetchAll();

    return !empty($res) && is_array($res) ? $res : [];
}

function getPropertyRestrictionsValues() : array
{
    if (\Bitrix\Main\Loader::includeModule('iblock')) {
        $enumValues = \Bitrix\Iblock\PropertyEnumerationTable::getList(array(
            'order' => array('SORT' => 'DESC','ID' => 'ASC'),
            'select' => array('*'),
            'filter' => array('PROPERTY_ID' => PROP_RESTRICTIONS_ID),
                'cache' => array(
                    'ttl' => 360000, // Время жизни кеша
                    'cache_joins' => true // Кешировать ли выборки с JOIN
                ),
        ))->fetchAll();
    }

    return !empty($enumValues) && is_array($enumValues) ? $enumValues : [];
}

function getTypePropertyHl(array $valueCodes) : array
{
    $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(PROPERTY_TYPES_HL_ID)->fetch();
    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    return $entity_data_class::getList(array(
        "select" => array("*"),
        "order" => array("ID" => "ASC"),
        "filter" => array("UF_XML_ID" => $valueCodes),
        'cache' => [
            'ttl' => 3600000,
            'cache_joins' => true
        ]
    ))->fetchAll();
}


//function getAllAutoProperties($cacheTtl = 360000) : array
//{
//    $cacheId = 'iblock_'.AUTO_IBLOCK_ID;
//    $cache = \Bitrix\Main\Application::getInstance()->getManagedCache();
//    if ($cache->read($cacheTtl, $cacheId)) {
//        $properties = $cache->get($cacheId);
//    } else {
//        $props = CIBlockProperty::GetList(
//            array("sort" => "asc", "name" => "asc"),
//            array("ACTIVE" => "Y", "IBLOCK_ID" => AUTO_IBLOCK_ID)
//        );
//        $properties = [];
//        while ($prop = $props->GetNext()) {
//
//            $prop_field[$prop["ID"]] = $prop;
//            $properties[] = $prop;
//        }
//        $cache->set($cacheId, array("FIELDS" => )); // записываем в кеш
//    }
//    return $properties ?? [];
//}
function getMotoSections() : array
{
    $cache = \Bitrix\Main\Application::getInstance()->getManagedCache();
    $cacheTtl = 3600000;
    $cacheId = 'iblock_moto_'.MOTO_IBLOCK_ID;

    if ($cache->read($cacheTtl, $cacheId)) {
        $motoSections = $cache->get($cacheId);
    } else {
        $res = CIBlockSection::GetList(
            array('sort' => 'asc'),
            array('IBLOCK_ID' => MOTO_IBLOCK_ID, 'ACTIVE' => 'Y'),
            false,
            array('UF_*')
        );
        while ($row = $res->GetNext()) {
            if ($row['IBLOCK_SECTION_ID'] == null) {
                $arSections[$row['NAME']] = $row;
            }
            $rsParentSection = CIBlockSection::GetByID($row['ID']);
            if ($arParentSection = $rsParentSection->GetNext()) {
                $arFilter = array(
                    'IBLOCK_ID' => $arParentSection['IBLOCK_ID'],
                    '>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],
                    '<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],
                    '>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']
                ); // выберет потомков без учета активности
                $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'), $arFilter);
                while ($arSect = $rsSect->GetNext()) {
                    $arSections[$row['NAME']]['SUB_SECTIONS'][$arSect['NAME']] = $arSect;
                    $arSubSections[$arSect['NAME'].$arSect['ID']] = $arSect;
                    $arSubSections[$arSect['NAME'].$arSect['ID']]['PARENT_SECTION'] = $row;

                }
            }
        }
        $motoSections['SECTIONS'] = $arSections;
        $motoSections['SUBSECTIONS'] = $arSubSections;
        $cache->set($cacheId, $motoSections);
    }

    return $motoSections;
}

function getSectionData(int $sectionId, int $iblockId) : ?array
{

    if (!empty($sectionId) && !empty($iblockId)) {
        $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($iblockId);
        $section = $entity::getList(array(
            'filter' => array('ID' => $sectionId, 'IBLOCK_ID' => $iblockId),
            'select' =>  array("*","UF_*",'SECTION_PAGE_URL' => 'IBLOCK.SECTION_PAGE_URL'),
            'cache' => [
                'ttl' => 3600000,
                'cache_joins' => true
            ]
        ))->fetch();

        if (!empty($section['SECTION_PAGE_URL'])) {
            $section['SECTION_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($section['SECTION_PAGE_URL'], $section, true, 'S');
        }
    }
    return $section ?? NULL;
}

function getOptimalActiveUserRate(string $adsCategory) : ?array
{
    if (CModule::IncludeModule('highloadblock')) {
        $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
        $typeRatesClass = GetEntityDataClass(TYPE_RATES_HL_ID);
        $typesRate = $typeRatesClass::getList(array(
            'select' => array('*'),
            'filter' => array('UF_SECTION'=> $adsCategory),
            'cache' => [
                'ttl' => 3600000,
                'cache_joins' => true
            ]
        ))->fetchAll();
        $editRates = [];
        if (!empty($typesRate)) {
            foreach ($typesRate as $rate) {
                $editRates[$rate['ID']] = $rate;
            }
        }

        $curTime = new DateTime();
        $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
        $userRates = $boughtRateEntity::getList(array(
            'order' => array('ID' => 'ASC'),
            'select' => array('*'),
            'filter' => array(
                'UF_USER_ID'=> $userId,
                'UF_TYPE'=> $adsCategory,
                '>UF_DATE_EXPIRED'=> $curTime
            )
        ))->fetchAll();

        if (!empty($userRates)) {
            $optimalRate = [];
            $createdRateAds = NULL;
            foreach ($userRates as $rate) {
                $createdRateAds += $rate['UF_COUNT_REMAIN'];
                if (!empty($optimalRate) || $rate['UF_COUNT_REMAIN'] <= $rate['UF_COUNT_LESS']) continue;
                $optimalRate = $rate;
            }

            $optimalRate['ADS_USED'] = $createdRateAds;
            $optimalRate['RATE_INFO'] = $editRates[$optimalRate['UF_PARENT_XML']];
        }
    }

    return !empty($optimalRate) ? $optimalRate : NULL;
}

function getRateInfoById(int $rateId) : ?array
{
    if (CModule::IncludeModule('highloadblock')) {
        $typeRatesClass = GetEntityDataClass(TYPE_RATES_HL_ID);
        $rateInfo = $typeRatesClass::getList(array(
            'select' => array('*'),
            'filter' => array('ID'=> $rateId),
            'cache' => [
                'ttl' => 3600000,
                'cache_joins' => true
            ]
        ))->fetch();
    }

    return $rateInfo ?? NULL;
}

function deleteAdFromUserRate(int $adId, int $iblockId) : bool
{
    $categoryType = [
        1 => "FLEA",
        2 => "PROPERTY",
        3 => "AUTO",
        7 => "AUTO",
        8 => "AUTO",
    ];

    if (!empty($categoryType[$iblockId])) {
        $curTime = new \Bitrix\Main\Type\DateTime();
        $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
        $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
        $userRates = $boughtRateEntity::getList(array(
            'order' => array('ID' => 'DESC'),
            'select' => array('*'),
            'filter' => array(
                'UF_USER_ID'=> $userId,
                '>UF_DATE_EXPIRED'=> $curTime,
                'UF_TYPE'=> $categoryType[$iblockId]
            )
        ))->fetchAll();

        if (!empty($userRates)) {
            foreach ($userRates as $rate) {
                if (!empty($rate['UF_ID_ANONC']) && in_array($adId, $rate['UF_ID_ANONC'])) {
                    $key = array_search($adId, $rate['UF_ID_ANONC']);

                    if ($key !== false) {
                        unset($rate['UF_ID_ANONC'][$key]);
                        $boughtRateEntity::update($rate['ID'], [
                            'UF_COUNT_LESS' => $rate['UF_COUNT_LESS'] > 0 ? --$rate['UF_COUNT_LESS'] : 0,
                            'UF_ID_ANONC' => $rate['UF_ID_ANONC']
                        ]);
                        return true;
                    }
                }
            }
        }
    }

    return false;
}

function getPropertyFreeAdValueId(int $iblockId) : ?int
{
    $propInfo = \Bitrix\Iblock\PropertyTable::getList(array(
        'select' => array('*'),
        'filter' => array('CODE' => 'FREE_AD','IBLOCK_ID' => $iblockId),
        'cache' => array(
            'ttl' => 360000,
            'cache_joins' => true
        ),
    ))->fetch();

    if (!empty($propInfo)) {
        $propValue = \Bitrix\Iblock\PropertyEnumerationTable::getList(array(
            'select' => array('*'),
            'filter' => array('PROPERTY_ID' => $propInfo['ID']),
            'cache' => array(
                'ttl' => 3600000,
                'cache_joins' => true
            ),
        ))->fetch();
    }

    return $propValue['ID'] ?? NULL;
}

function canUserCreateAds(int $iblockId, string $categoryCode) : bool
{
    $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
    $arUser = \CUser::GetByID($userId)->Fetch();
    $optimalUserRate = getOptimalActiveUserRate($categoryCode);
    $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass();
    $elements = $iblockClass::getList(array(
        'select' => array('ID', 'NAME'),
        'filter' => ['ID_USER.VALUE' => $userId, '!FREE_AD.VALUE' => false]
    ))->fetchCollection();
    $countUserFreeAds = $elements->count();
    $countRatesAds = !empty($optimalUserRate['ADS_USED']) ? $optimalUserRate['ADS_USED'] : 0;
    return ($countRatesAds + $arUser['UF_FREE_'.$categoryCode] - $arUser['UF_COUNT_'.$categoryCode] - $countUserFreeAds) > 0;
}

function getCurUserActiveRates() : array
{
    $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
    $typeRatesClass = GetEntityDataClass(TYPE_RATES_HL_ID);
    $typesRate = $typeRatesClass::getList(array(
        'select' => array('*'),
        'cache' => [
            'ttl' => 3600000,
            'cache_joins' => true
        ]
    ))->fetchAll();
    $editRates = [];
    if (!empty($typesRate)) {
        foreach ($typesRate as $rate) {
            $editRates[$rate['ID']] = $rate;
        }
    }

    $curTime = new \Bitrix\Main\Type\DateTime();
    $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
    $userRates = $boughtRateEntity::getList(array(
        'order' => array('ID' => 'ASC'),
        'select' => array('*'),
        'filter' => array(
            'UF_USER_ID'=> $userId,
            '>UF_DATE_EXPIRED'=> $curTime
        )
    ))->fetchAll();


    $activeUserRates = [];
    foreach ($userRates as $rateInfo) {
        $activeUserRates[$editRates[$rateInfo['UF_PARENT_XML']]['UF_NAME']] = $rateInfo['UF_DATE_EXPIRED'];
    }

    return $activeUserRates;
}

function addEntryToUserBuyHistory(int $id, string $entryType) : void
{
    $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
    $newEntryData = [
        'UF_TYPE' => $entryType,
        'UF_USER_ID' => $userId,
        'UF_DATE_BUY' => new \Bitrix\Main\Type\DateTime()
    ];

    switch ($entryType) {
        case 'RATE':
            $rateInfo = getRateInfoById($id);
            $newEntryData['UF_NAME'] = $rateInfo['UF_NAME'].' ('.$rateInfo['UF_SECTION'].')';
            break;
        case 'RISE':
            $newEntryData['UF_ITEM_ID'] = $id;
            $itemInfo = \Bitrix\Iblock\ElementTable::getById($id)->fetch();
            $newEntryData['UF_NAME'] = 'Покупка поднятия для '.$itemInfo['NAME'];
            break;
        case 'VIP':
            $newEntryData['UF_ITEM_ID'] = $id;
            $itemInfo = \Bitrix\Iblock\ElementTable::getById($id)->fetch();
            $newEntryData['UF_NAME'] = 'Покупка VIP для '.$itemInfo['NAME'];
            break;
        case 'COLOR':
            $newEntryData['UF_ITEM_ID'] = $id;
            $itemInfo = \Bitrix\Iblock\ElementTable::getById($id)->fetch();
            $newEntryData['UF_NAME'] = 'Покупка выделения цветом для '.$itemInfo['NAME'];
            break;
        case 'RIBBON':
            $newEntryData['UF_ITEM_ID'] = $id;
            $itemInfo = \Bitrix\Iblock\ElementTable::getById($id)->fetch();
            $newEntryData['UF_NAME'] = 'Покупка выделения лентой для '.$itemInfo['NAME'];
            break;
        case 'PROMOTION':
            $newEntryData['UF_ITEM_ID'] = $id;
            $itemInfo = \Bitrix\Iblock\ElementTable::getById($id)->fetch();
            $newEntryData['UF_NAME'] = 'Покупка пакета продвижения для '.$itemInfo['NAME'];
            break;
        case 'SHEKEL':
            $newEntryData['UF_NAME'] = 'Покупка валюты ';
            break;
        case 'EXCHANGE':
            $newEntryData['UF_NAME'] = 'Обмен валюты на TCOINS ';
            break;
    }

    $userHistoryClass = GetEntityDataClass(USER_BUY_HISTORY_HL_ID);
    $userHistoryClass::add($newEntryData);
}


function deleteFavoritesUser($adId) : void
{
    $favoriteHLClass = GetEntityDataClass(FAVORITES_HL_ID);
    $favorites = $favoriteHLClass::getList(array(
        'select' => array('ID'),
        'filter' => ['UF_ID_AD' => $adId],
    ))->fetchCollection();
    foreach ($favorites as $userFavorite) {
        $userFavorite->delete();
    }
}

function isExistActiveFreeAd(string $adCategory) : bool
{
    if (!empty(CATEGORY_TO_IBLOCK_ID[$adCategory])) {
        $iblockId = CATEGORY_TO_IBLOCK_ID[$adCategory];
        $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();

        if (is_array($iblockId)) {
            foreach ($iblockId as $ibId) {
                $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($ibId)->getEntityDataClass();
                $element = $iblockClass::getList(array(
                    'select' => array('ID', 'NAME'),
                    'filter' => ['ID_USER.VALUE' => $userId, '!FREE_AD.VALUE' => false, 'ACTIVE' => 'Y']
                ))->fetchObject();

                if (!empty($element)) return true;
            }
        } else {
            $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass();
            $element = $iblockClass::getList(array(
                'select' => array('ID', 'NAME'),
                'filter' => ['ID_USER.VALUE' => $userId, '!FREE_AD.VALUE' => false, 'ACTIVE' => 'Y']
            ))->fetchObject();

            if (!empty($element)) return true;
        }
    }

    return false;
}

function removeFreeAdPropOnAds(string $adCategory) : void
{
    if (!empty(CATEGORY_TO_IBLOCK_ID[$adCategory])) {
        $iblockId = CATEGORY_TO_IBLOCK_ID[$adCategory];
        $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();

        if (is_array($iblockId)) {
            foreach ($iblockId as $ibId) {
                $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($ibId)->getEntityDataClass();
                $collection = $iblockClass::getList(array(
                    'select' => array('ID', 'NAME'),
                    'filter' => ['ID_USER.VALUE' => $userId, '!FREE_AD.VALUE' => false]
                ))->fetchCollection();

                foreach ($collection as $item) {
                    $item->setFreeAd(false);
                }
                $collection->save();
            }
        } else {
            $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass();
            $collection = $iblockClass::getList(array(
                'select' => array('ID', 'NAME'),
                'filter' => ['ID_USER.VALUE' => $userId, '!FREE_AD.VALUE' => false]
            ))->fetchCollection();
            foreach ($collection as $item) {
                $item->setFreeAd(false);
            }
            $collection->save();
        }
    }
}
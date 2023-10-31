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
        <?if ($die == true) {
            die();
        }?>
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
            'order' => array(),
            'select' => array('*'),
            'filter' => array('UF_SECTION'=> $adsCategory)
        ))->fetchAll();
        $editRates = [];
        if (!empty($typesRate)) {
            foreach ($typesRate as $rate) {
                $editRates[$rate['ID']] = $rate;
            }
        }

        $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
        $userRates = $boughtRateEntity::getList(array(
            'order' => array('ID' => 'DESC'),
            'select' => array('*'),
            'filter' => array('UF_USER_ID'=> $userId, 'UF_TYPE'=> $adsCategory)
        ))->fetchAll();

        $curTime = new DateTime();
        $notExpiredRates = [];
        $notExpiredRatesId = [];
        if (!empty($userRates)) {
            foreach ($userRates as $userRate) {
                $chosenRate = $editRates[$userRate['UF_PARENT_XML']];
                $purchaseRateDate = $userRate['UF_DATE_PURCHASE'];
                $dateExpiredCurRate = !empty($purchaseRateDate) ?
                    DateTime::createFromTimestamp(strtotime($purchaseRateDate.' + '.$chosenRate['UF_DAYS'].' days')) : '';
                if ($curTime < $dateExpiredCurRate) {
                    $notExpiredRatesId[] = $userRate['ID'];
                    $notExpiredRates[$userRate['ID']] = $userRate;
                }
            }
            $earlyActiveUserRateId = min($notExpiredRatesId);
            $userActiveRate = $notExpiredRates[$earlyActiveUserRateId];
            $userActiveRate['RATE_INFO'] = $editRates[$userActiveRate['UF_PARENT_XML']];
        }
    }

    return $userActiveRate ?? NULL;
}

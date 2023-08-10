<?php

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

function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
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
<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!empty($arResult['ITEMS'])) {

    if (!empty($arParams['SECTION_ID'])) {
        $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(PROPERTY_ADS_IBLOCK_ID);
        $sectionAdditionalProps = $entity::getList(array(
            "filter" => array(
                "ID" => $arParams['SECTION_ID'],
                "ACTIVE" => "Y",
            ),
            "select" => array("UF_PROPS"),
            "cache" => [
                'ttl' => 36000000,
                'cache_joins' => true
            ]
        ))->fetch()['UF_PROPS'];
    }

    $mainMobileProps = [
        'PROP_TYPE_APART', // Тип недвижимости
        'MAP_LAYOUT_BIG', // Область
        'MAP_LAYOUT', // Город
        'PROP_COUNT_ROOMS', // Кол-во комнат
        'PRICE',
    ];

    $propRoomsAdditionalCheckbox = [
        "PROP_FREE_LAYOUT",
        "PROP_STUDIO"
    ];

    $additionalFilter = [
        'PROP_AREA_2', // Площадь общая
        'PROP_FLOOR', // Этаж
        'PROP_Completion', // Дата въезда
        'IMMEDIATELY_ENTRY', // Немедленный въезд
        'NOT_FIRST', // Не первый
        'NOT_LAST', // Не последний
    ];

    $newItems = [];
    foreach ($arResult['ITEMS'] as $item) {
        if (!empty($arResult['ITEMS'][IBLOCK_PROPERTY_PROP_TYPE_APART_PROP_ID]['VALUES'])) {
            $valueCodes = [];
            foreach ($arResult['ITEMS'][IBLOCK_PROPERTY_PROP_TYPE_APART_PROP_ID]['VALUES'] as $key => $value) {
                $valueCodes[] = $key;
            }

            $res = getTypePropertyHl($valueCodes);

            if (!empty($res)) {
                foreach ($res as $prop) {
                    if (!empty($arResult['ITEMS'][IBLOCK_PROPERTY_PROP_TYPE_APART_PROP_ID]['VALUES'][$prop['UF_XML_ID']])) {
                        $arResult['ITEMS'][IBLOCK_PROPERTY_PROP_TYPE_APART_PROP_ID]['VALUES'][$prop['UF_XML_ID']]['VALUE'] = $prop['UF_IVRIT'];
                    }
                }
            }
        }


        if (!empty($item['CODE']) && in_array($item['CODE'],$mainMobileProps)) {
            if ($item['CODE'] === 'MAP_LAYOUT_BIG') $arResult['MAIN_PROPS'][0] = $item;
            if ($item['CODE'] === 'MAP_LAYOUT') {
                $item['VALUES'] = $arResult['ITEMS'][IBLOCK_PROPERTY_MAP_LAYOUT_JSON_PROP_ID]['VALUES'];
                $arResult['MAIN_PROPS'][1] = $item;
            }
            if ($item['CODE'] === 'PRICE') $arResult['MAIN_PROPS'][2] = $item;
            if ($item['CODE'] === 'PROP_COUNT_ROOMS') $arResult['MAIN_PROPS'][3] = $item;
            if ($item['CODE'] === 'PROP_TYPE_APART') $arResult['MAIN_PROPS'][4] = $item;
        }

        if (!empty($item['CODE']) && in_array($item['CODE'],$additionalFilter)) $newItems[$item['ID']] = $item;


        if (!empty($item['CODE']) && in_array($item['CODE'],$propRoomsAdditionalCheckbox)) $arResult['ROOMS_ADD_PROP'][] = $item;

        if (!empty($sectionAdditionalProps) && in_array($item['CODE'],$sectionAdditionalProps)) $arResult['ADDITIONAL_PROPS'][] = $item;

    }

    $arResult['ITEMS'] = $newItems;
    ksort($arResult['MAIN_PROPS']);
}

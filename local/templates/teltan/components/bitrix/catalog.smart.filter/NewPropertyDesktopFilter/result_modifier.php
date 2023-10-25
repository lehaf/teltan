<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

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

if (!empty($arResult['ITEMS']) && !empty($arParams['SECTION_ID'])) {
    $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(PROPERTY_ADS_IBLOCK_ID);
    $additionalPropsCode = $entity::getList(array(
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

    foreach ($arResult['ITEMS'] as $item) {
        if (in_array($item['CODE'],$additionalPropsCode) && !empty($item['VALUES'])) $arResult['ADDITIONAL_PROPS'][] = $item;
    }
}
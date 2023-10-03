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
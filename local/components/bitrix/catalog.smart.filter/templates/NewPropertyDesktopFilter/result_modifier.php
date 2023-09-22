<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Highloadblock as HL;

if (!empty($arResult['ITEMS'][IBLOCK_PROPERTY_PROP_TYPE_APART_PROP_ID]['VALUES'])) {
    $valueCodes = [];
    foreach ($arResult['ITEMS'][IBLOCK_PROPERTY_PROP_TYPE_APART_PROP_ID]['VALUES'] as $key => $value) {
        $valueCodes[] = $key;
    }

    $hlblock = HL\HighloadBlockTable::getById(PROPERTY_TYPES_HL_ID)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    $res = $entity_data_class::getList(array(
        "select" => array("*"),
        "order" => array("ID" => "ASC"),
        "filter" => array("UF_XML_ID" => $valueCodes),
        'cache' => [
            'ttl' => 3600000,
            'cache_joins' => true
        ]
    ))->fetchAll();

    if (!empty($res)) {
        foreach ($res as $prop) {
            if (!empty($arResult['ITEMS'][IBLOCK_PROPERTY_PROP_TYPE_APART_PROP_ID]['VALUES'][$prop['UF_XML_ID']])) {
                $arResult['ITEMS'][IBLOCK_PROPERTY_PROP_TYPE_APART_PROP_ID]['VALUES'][$prop['UF_XML_ID']]['VALUE'] = $prop['UF_IVRIT'];
            }
        }
    }
}
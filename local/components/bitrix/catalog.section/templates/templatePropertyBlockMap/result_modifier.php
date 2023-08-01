<?php

$arSelect = Array();//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'],  "ACTIVE"=>"Y", ">=".'PROPERTY_VIP_DATE' => date("Y-m-d"));
$res = CIBlockElement::GetList(Array('property_TIME_RAISE' => 'DESC'), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
    $element = $arFields;
    $arProps = $ob->GetProperties();
    $element['PROPERTIES'] = $arProps;
    $arResult['VIPS'][] = $element;
}
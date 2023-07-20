<?
foreach ($arResult['SEARCH'] as $k => $arItem){
    $IDs[] = $arItem['ID'];
}

$arOrder = array("ID" => $IDs);
if($_GET['sort'] == 'price_a')
{
    $arOrder = array('PROPERTY_PRICE' => 'ASC');
}
if($_GET['sort'] == 'price_d')
{
    $arOrder = array('PROPERTY_PRICE' => 'DESC');
}
if($_GET['sort'] == 'popular')
{
    $arOrder = array('SHOW_COUNTER' => 'DESC');
}

$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "SHOW_COUNTER", "DATE_CREATE", "PREVIEW_PICTURE", "PREVIEW_TEXT", "PROPERTY_PRICE");
$arFilter = Array("ID"=> $IDs, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
    $arFields['PROPERTIES'] = $ob->GetProperties();
    $result[] = $arFields;
}

$arResult['RESULT'] = $result;
?>
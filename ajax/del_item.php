<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');

$PRODUCT_ID = IntVal($_REQUEST['item']);  // изменяем элемент с кодом (ID) 2
CIBlockElement::Delete($PRODUCT_ID);
const MY_HL_BLOCK_ID = 1;
CModule::IncludeModule('highloadblock');

$entity_data_class = GetEntityDataClass(5);
$rsData = $entity_data_class::getList(array(
    'select' => array('*')
));
while($el = $rsData->fetch()){
    if ($el['UF_ID_USER'] == $USER->GetID() && $el['UF_ID_AD'] == $_REQUEST['item']){
        $result = $entity_data_class::delete($el['ID']);
    }
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
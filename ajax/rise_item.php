<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');



$ELEMENT_ID = intval($_REQUEST['id']);
$PROPERTY_CODE = "TIME_RAISE";
$PROPERTY_VALUE = date("Y-m-d H:i:s");


CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
$db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblockId']), $ELEMENT_ID, array("sort" => "asc"), Array("CODE"=>"COUNT_RAISE"));
if($ar_props = $db_props->Fetch())
    $TOPIC_ID = IntVal($ar_props["VALUE"]);
else
    $TOPIC_ID = false;
$newvalue =  $TOPIC_ID -1;
$PROPERTY_CODE = "COUNT_RAISE";
$PROPERTY_VALUE = IntVal($newvalue);


CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
if(LANGUAGE_ID == 'he') {
    if ($newvalue <= 0) {
        echo 'none';
    } else {
        echo '(' .$newvalue . ') '.'להקפיץ' ;
    }

}else{
    if ($newvalue <= 0) {
        echo 'none';
    } else {
        echo 'Raise (' . $newvalue . ')';
    }
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('iblock');
define("MY_HL_BLOCK_ID", 30);
CModule::IncludeModule('highloadblock');

$entity_data_class = GetEntityDataClass(MY_HL_BLOCK_ID);

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
$PRICE = (double)$_REQUEST["price"];

if($_REQUEST['type'] != 'getData') {
    if($_REQUEST['success'] == 'Y') {
        $PRODUCT_ID = IntVal($_REQUEST["idItem"]);
        $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), array("CODE" => "COUNT_RAISE"));
        if ($ar_props = $db_props->Fetch())
            $TOPIC_ID = IntVal($ar_props["VALUE"]);
        else
            $TOPIC_ID = false;

        CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "COUNT_RAISE", $TOPIC_ID += IntVal($_REQUEST["count"]));
        $result = $entity_data_class::add(array(
            'UF_ITEM_ID'         => IntVal($_REQUEST["idItem"]),
            'UF_USER_ID'         => (int)$USER->GetID(),
            'UF_DATE_BUY' => date("d.m.Y H:i:s"),
            'UF_NAME' => 'buy_rise'

        ));
        LocalRedirect("/personal/wallet/");
    }else{
        if ($arUser['UF_TCOINS'] >= $PRICE) {

            $PRODUCT_ID = IntVal($_REQUEST["idItem"]);
            $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), array("CODE" => "COUNT_RAISE"));
            if ($ar_props = $db_props->Fetch())
                $TOPIC_ID = IntVal($ar_props["VALUE"]);
            else
                $TOPIC_ID = false;

            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "COUNT_RAISE", $TOPIC_ID += IntVal($_REQUEST["count"]));
        }
        $user = new CUser;

        $fields = array(
            'UF_TCOINS' => $arUser['UF_TCOINS'] - $PRICE
        );
        $user->Update($USER->GetID(), $fields);
        $result = $entity_data_class::add(array(
            'UF_ITEM_ID'         => IntVal($_REQUEST["idItem"]),
            'UF_USER_ID'         => (int)$USER->GetID(),
            'UF_DATE_BUY' => date("d.m.Y H:i:s"),
            'UF_NAME' => 'buy_rise'

        ));
    }


}else{
    echo $arUser['UF_TCOINS'];
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
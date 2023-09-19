<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('iblock');

CModule::IncludeModule('highloadblock');

$entity_data_class = GetEntityDataClass(30);

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
$PRICE = (double)$_REQUEST["price"];
$countDate = '+ '. $_REQUEST["count"]. ' days';
if($_REQUEST['type'] != 'getData') {
    if($_REQUEST['success'] == 'Y') {
            $PRODUCT_ID = IntVal($_REQUEST["idItem"]);
            $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), array("CODE" => "VIP_DATE"));
            if ($ar_props = $db_props->Fetch())
                $TIME = $ar_props["VALUE"];
            else
                $TIME = false;
            if ($TIME < date("d.m.Y H:i:s")) {

                $TIME = date("d.m.Y H:i:s", strtotime($countDate));
            } else {

                $newTIME = $TIME;
                $TIME = date("d.m.Y H:i:s", strtotime($newTIME . $countDate));
            }
            var_dump($countDate);
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_DATE", $TIME);
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_FLAG", 1);
        $result = $entity_data_class::add(array(
            'UF_ITEM_ID'         => IntVal($_REQUEST["idItem"]),
            'UF_USER_ID'         => (int)$USER->GetID(),
            'UF_DATE_BUY' => date("d.m.Y H:i:s"),
            'UF_NAME' => 'buy_vip'

        ));
        LocalRedirect("/personal/wallet/");
    }else {

        if ($arUser['UF_TCOINS'] >= $PRICE) {

            $PRODUCT_ID = IntVal($_REQUEST["idItem"]);
            $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), array("CODE" => "VIP_DATE"));
            if ($ar_props = $db_props->Fetch())
                $TIME = $ar_props["VALUE"];
            else
                $TIME = false;
            if ($TIME < date("d.m.Y H:i:s")) {

                $TIME = date("d.m.Y H:i:s", strtotime($countDate));
            } else {

                $newTIME = $TIME;
                $TIME = date("d.m.Y H:i:s", strtotime($newTIME . $countDate));
            }
            var_dump($countDate);
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_DATE", $TIME);
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_FLAG", 1);
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
            'UF_NAME' => 'buy_vip'

        ));
        $arResponse = [

        ];
    }
}else{
    echo $arUser['UF_TCOINS'];
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
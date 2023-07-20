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
        $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), Array("CODE"=>"VIP_DATE"));
        if($ar_props = $db_props->Fetch())
            $VIP_DATE = $ar_props["VALUE"];

        $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), Array("CODE"=>"COUNT_RAISE"));
        if($ar_props = $db_props->Fetch())
            $COUNT_RAISE = $ar_props["VALUE"];

        $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), Array("CODE"=>"COLOR_DATE"));
        if($ar_props = $db_props->Fetch())
            $COLOR_DATE = $ar_props["VALUE"];

        $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), Array("CODE"=>"LENTA_DATE"));
        if($ar_props = $db_props->Fetch())
            $LENTA_DATE = $ar_props["VALUE"];

        $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), Array("CODE"=>"TIME_RAISE"));
        if($ar_props = $db_props->Fetch())
            $TIME_RAISE = $ar_props["VALUE"];

        if($VIP_DATE < date("d.m.Y H:i:s")){

            $VIP_DATE = date("d.m.Y H:i:s", strtotime('+ '. $_REQUEST["uf_vip"]. ' days'));
        }else{
            $newTIME = $VIP_DATE;
            $VIP_DATE = date("d.m.Y H:i:s", strtotime($newTIME.'+ '. $_REQUEST["uf_vip"]. ' days'));
        }
        if($LENTA_DATE < date("d.m.Y H:i:s")){

            $LENTA_DATE = date("d.m.Y H:i:s", strtotime('+ '. $_REQUEST["uf_lenta"]. ' days'));
        }else{
            $newTIME = $LENTA_DATE;
            $LENTA_DATE = date("d.m.Y H:i:s", strtotime($newTIME.'+ '. $_REQUEST["uf_lenta"]. ' days'));
        }







        $entity_data_class = GetEntityDataClass(26);
        $result = $entity_data_class::add(array(
            'UF_ITEM'         => IntVal($_REQUEST["idItem"]),
            'UF_COUNT'         => IntVal($_REQUEST["uf_rise_day"]),
            'UF_DAYS'         => IntVal($_REQUEST["uf_rise_count"]),
            'UF_I_BLOCK'         => IntVal($_REQUEST["iblock"]),

        ));
        var_dump($_REQUEST["all"]);

        CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "COUNT_RAISE",  $COUNT_RAISE += IntVal($_REQUEST["uf_rise_count"]));
        CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_DATE",  $VIP_DATE);
        CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_FLAG", 1);
        CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "LENTA_DATE",  $LENTA_DATE);
        CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "TYPE_TAPE",  $_REQUEST["uf_xml_id_lent"]);
        $entity_data_class = GetEntityDataClass(30);
        $result = $entity_data_class::add(array(
            'UF_ITEM_ID'         => IntVal($_REQUEST["idItem"]),
            'UF_USER_ID'         => (int)$USER->GetID(),
            'UF_DATE_BUY' => date("d.m.Y H:i:s"),
            'UF_NAME' => 'buy_item_paket'

        ));
       LocalRedirect("/personal/wallet/");
    }else{
        if ($arUser['UF_TCOINS'] >= $PRICE) {

            $PRODUCT_ID = IntVal($_REQUEST["idItem"]);
            $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), Array("CODE"=>"VIP_DATE"));
            if($ar_props = $db_props->Fetch())
                $VIP_DATE = $ar_props["VALUE"];

            $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), Array("CODE"=>"COUNT_RAISE"));
            if($ar_props = $db_props->Fetch())
                $COUNT_RAISE = $ar_props["VALUE"];

            $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), Array("CODE"=>"COLOR_DATE"));
            if($ar_props = $db_props->Fetch())
                $COLOR_DATE = $ar_props["VALUE"];

            $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), Array("CODE"=>"LENTA_DATE"));
            if($ar_props = $db_props->Fetch())
                $LENTA_DATE = $ar_props["VALUE"];

            $db_props = CIBlockElement::GetProperty(intval($_REQUEST['iblock']), $PRODUCT_ID, array("sort" => "asc"), Array("CODE"=>"TIME_RAISE"));
            if($ar_props = $db_props->Fetch())
                $TIME_RAISE = $ar_props["VALUE"];

            if($VIP_DATE < date("d.m.Y H:i:s")){

                $VIP_DATE = date("d.m.Y H:i:s", strtotime('+ '. $_REQUEST["all"]["uf_vip"]. ' days'));
            }else{
                $newTIME = $VIP_DATE;
                $VIP_DATE = date("d.m.Y H:i:s", strtotime($newTIME.'+ '. $_REQUEST["all"]["uf_vip"]. ' days'));
            }
            if($LENTA_DATE < date("d.m.Y H:i:s")){

                $LENTA_DATE = date("d.m.Y H:i:s", strtotime('+ '. $_REQUEST["all"]["uf_lenta"]. ' days'));
            }else{
                $newTIME = $LENTA_DATE;
                $LENTA_DATE = date("d.m.Y H:i:s", strtotime($newTIME.'+ '. $_REQUEST["all"]["uf_lenta"]. ' days'));
            }







            $entity_data_class = GetEntityDataClass(26);
            $result = $entity_data_class::add(array(
                'UF_ITEM'         => IntVal($_REQUEST["idItem"]),
                'UF_COUNT'         => IntVal($_REQUEST["all"]["uf_rise_day"]),
                'UF_DAYS'         => IntVal($_REQUEST["all"]["uf_rise_count"]),
                'UF_I_BLOCK'         => IntVal($_REQUEST["iblock"]),

            ));
            var_dump($_REQUEST);

            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "COUNT_RAISE",  $COUNT_RAISE += IntVal($_REQUEST["all"]["uf_rise_count"]));
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_DATE",  $VIP_DATE);
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_FLAG", 1);
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "LENTA_DATE",  $LENTA_DATE);
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "TYPE_TAPE",  $_REQUEST['all']["uf_xml_id_lent"]);
            $entity_data_class = GetEntityDataClass(30);
            $result = $entity_data_class::add(array(
                'UF_ITEM_ID'         => IntVal($_REQUEST["idItem"]),
                'UF_USER_ID'         => (int)$USER->GetID(),
                'UF_DATE_BUY' => date("d.m.Y H:i:s"),
                'UF_NAME' => 'buy_item_paket'

            ));
        }
        $user = new CUser;

        $fields = array(
            'UF_TCOINS' => $arUser['UF_TCOINS'] - $PRICE
        );
        $user->Update($USER->GetID(), $fields);
        $arResponse = [

        ];
    }

}else{
    echo $arUser['UF_TCOINS'];
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
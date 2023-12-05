<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();
$price = (double)$_REQUEST["price"];

if ($_REQUEST['type'] != 'getData') {
    if ($arUser['UF_TCOINS'] >= $price && \Bitrix\Main\Loader::includeModule('iblock')) {
        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($_REQUEST['iblock'])->getEntityDataClass();
        $element = $iblockClass::getByPrimary($_REQUEST["idItem"], [
            'select' => array('ID', 'NAME', 'COLOR_DATE')
        ])->fetchObject();

        if ($element->getColorDate()) {
            $oldColorDate = $element->getColorDate()->getValue();
            $newDate = strtotime($oldColorDate. '+ '.$_REQUEST["count"].' days');
            $element->setColorDate(date("Y-m-d H:i:s",$newDate));
        } else {
            $countDate = '+ '. $_REQUEST["count"]. ' days';
            $date = date("Y-m-d H:i:s",strtotime($countDate));
            $element->setColorDate($date);
        }
        $element->save();

        $user = new CUser;
        $fields = array('UF_TCOINS' => $arUser['UF_TCOINS'] - $price);
        $user->Update($userId, $fields);
        addEntryToUserBuyHistory($_REQUEST["idItem"],'COLOR');
    }
} else {
    echo $arUser['UF_TCOINS'];
}

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();
$price = (double)$_REQUEST["price"];

if ($_REQUEST['type'] != 'getData') {
    if ($arUser['UF_TCOINS'] >= $price && \Bitrix\Main\Loader::includeModule('iblock')) {
        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($_REQUEST['iblock'])->getEntityDataClass();
        $element = $iblockClass::getByPrimary($_REQUEST["idItem"], [
            'select' => array('ID', 'NAME', 'COUNT_RAISE')
        ])->fetchObject();

        if ($element->getCountRaise()) {
            $oldCountRise = $element->getCountRaise()->getValue();
            $element->setCountRaise($oldCountRise + $_REQUEST["count"]);
        } else {
            $element->setCountRaise($_REQUEST["count"]);
        }
        $element->save();

        $user = new CUser;
        $fields = array('UF_TCOINS' => $arUser['UF_TCOINS'] - $price);
        $user->Update($userId, $fields);
        addEntryToUserBuyHistory($_REQUEST["idItem"],'RISE');
    }
} else {
    echo $arUser['UF_TCOINS'];
}

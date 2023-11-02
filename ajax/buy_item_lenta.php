<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();
$price = (double)$_REQUEST["price"];

if($_REQUEST['type'] != 'getData') {
    if ($arUser['UF_TCOINS'] >= $price && \Bitrix\Main\Loader::includeModule('iblock')) {
        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($_REQUEST['iblock'])->getEntityDataClass();
        $element = $iblockClass::getByPrimary($_REQUEST["idItem"], [
            'select' => ['ID', 'NAME', 'TYPE_TAPE', 'LENTA_DATE']
        ])->fetchObject();

        if ($element->getLentaDate()) {
            $oldColorDate = $element->getLentaDate()->getValue();
            $newDate = strtotime($oldColorDate. '+ '.$_REQUEST["count"].' days');
            $element->setLentaDate(\Bitrix\Main\Type\DateTime::createFromTimestamp($newDate));
        } else {
            $countDate = '+ '. $_REQUEST["count"]. ' days';
            $date = \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime($countDate));
            $element->setLentaDate($date);
        }

        if (!empty($_REQUEST['xml'])) $element->setTypeTape($_REQUEST['xml']);
        $element->save();

        $user = new CUser;
        $fields = array('UF_TCOINS' => $arUser['UF_TCOINS'] - $price);
        $user->Update($userId, $fields);
        addEntryToUserBuyHistory($_REQUEST["idItem"],'RIBBON');
    }
} else {
    echo $arUser['UF_TCOINS'];
}

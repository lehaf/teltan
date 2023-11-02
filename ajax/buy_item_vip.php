<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();
$price = (double)$_REQUEST["price"];

if($_REQUEST['type'] != 'getData') {
    if ($arUser['UF_TCOINS'] >= $price && \Bitrix\Main\Loader::includeModule('iblock')) {
        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($_REQUEST['iblock'])->getEntityDataClass();
        $element = $iblockClass::getByPrimary($_REQUEST["idItem"], [
            'select' => array('ID', 'NAME', 'VIP_DATE', 'VIP_FLAG')
        ])->fetchObject();

        $vipFlagPropInfo = \Bitrix\Iblock\PropertyTable::getList(array(
            'select' => array('*'),
            'filter' => array('CODE' => 'VIP_FLAG','IBLOCK_ID' => $_REQUEST['iblock']),
            'cache' => array(
                'ttl' => 360000,
                'cache_joins' => true
            ),
        ))->fetch();

        if (!empty($vipFlagPropInfo)) {
            $vipFlagPropValue = \Bitrix\Iblock\PropertyEnumerationTable::getList(array(
                'select' => array('*'),
                'filter' => array('PROPERTY_ID' => $vipFlagPropInfo['ID']),
                'cache' => array(
                    'ttl' => 3600000,
                    'cache_joins' => true
                ),
            ))->fetch();

            if (!empty($vipFlagPropValue['ID'])) {
                $element->setVipFlag($vipFlagPropValue['ID']);
            }
        }

        if ($element->getVipDate()) {
            $oldVipDate = $element->getVipDate()->getValue();
            $newDate = strtotime($oldVipDate. '+ '.$_REQUEST["count"].' days');
            $element->setVipDate(\Bitrix\Main\Type\DateTime::createFromTimestamp($newDate));
        } else {
            $vipDateUntil = '+ '. $_REQUEST["count"]. ' days';
            $element->setVipDate(\Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime($vipDateUntil)));
        }

        $element->save();

        $user = new CUser;
        $fields = array('UF_TCOINS' => $arUser['UF_TCOINS'] - $price);
        $user->Update($userId, $fields);
        addEntryToUserBuyHistory($_REQUEST["idItem"],'VIP');
    }
} else {
    echo $arUser['UF_TCOINS'];
}

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();
$price = (double)$_REQUEST["price"];
$countDate = '+ '. $_REQUEST["count"]. ' days';

if($_REQUEST['type'] != 'getData') {
    if ($arUser['UF_TCOINS'] >= $price && \Bitrix\Main\Loader::includeModule('iblock')) {

        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($_REQUEST['iblock'])->getEntityDataClass();
        $element = $iblockClass::getByPrimary($_REQUEST["idItem"], [
            'select' => ['ID', 'NAME', 'TYPE_TAPE', 'LENTA_DATE', 'VIP_DATE', 'VIP_FLAG', 'COUNT_RAISE','PAKET_DATE']
        ])->fetchObject();
        // set RIBBON
        if ($element->getLentaDate()) {
            $oldColorDate = $element->getLentaDate()->getValue();
            $newDate = strtotime($oldColorDate. '+ '.$_REQUEST["all"]["uf_lenta"].' days');
            $element->setLentaDate(\Bitrix\Main\Type\DateTime::createFromTimestamp($newDate));
        } else {
            $countDate = '+ '. $_REQUEST["all"]["uf_lenta"]. ' days';
            $date = \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime($countDate));
            $element->setLentaDate($date);
        }
        $element->setTypeTape($_REQUEST['all']["uf_xml_id_lent"]);
        // set VIP
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
            $newDate = strtotime($oldVipDate. '+ '.$_REQUEST["all"]["uf_vip"].' days');
            $element->setVipDate(\Bitrix\Main\Type\DateTime::createFromTimestamp($newDate));
        } else {
            $vipDateUntil = '+ '. $_REQUEST["all"]["uf_vip"]. ' days';
            $element->setVipDate(\Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime($vipDateUntil)));
        }
        // set RISE
        if ($element->getCountRaise()) {
            $oldCountRise = $element->getCountRaise()->getValue();
            $element->setCountRaise($oldCountRise + $_REQUEST["all"]["uf_rise_count"]);
        } else {
            $element->setCountRaise($_REQUEST["all"]["uf_rise_count"]);
        }
        // set PROMOTION
        $daysPromotion = max([$_REQUEST["all"]["uf_vip"],$_REQUEST["all"]["uf_lenta"]]);
        if (!empty($daysPromotion)) {
            if ($element->getPaketDate()) {
                $oldPromotionDate = $element->getPaketDate()->getValue();
                $newDate = strtotime($oldPromotionDate. '+ '.$daysPromotion.' days');
                $element->setPaketDate(\Bitrix\Main\Type\DateTime::createFromTimestamp($newDate));
            } else {
                $promotionDate = '+ '. $daysPromotion. ' days';
                $element->setPaketDate(\Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime($promotionDate)));
            }
        }

        $element->save();

        $user = new CUser;
        $fields = array('UF_TCOINS' => $arUser['UF_TCOINS'] - $price);
        $user->Update($userId, $fields);
        addEntryToUserBuyHistory($_REQUEST["idItem"],'PROMOTION');
    }
} else {
    echo $arUser['UF_TCOINS'];
}

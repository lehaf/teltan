<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

if (Loader::includeModule('iblock')) {

    $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($_REQUEST['iblockId'])->getEntityDataClass();
    $element = $iblockClass::getByPrimary($_REQUEST['id'], array(
        'select' => array('ID', 'TIME_RAISE', 'COUNT_RAISE'),
    ))->fetchObject();
    $element->setTimeRaise(date('Y-m-d H:i:s'));
    $countRaise = !empty($element->getCountRaise()) && $element->getCountRaise()->getValue() > 0 ?
        $element->getCountRaise()->getValue() - 1 : 0;
    $element->setCountRaise($countRaise);
    $element->save();
    $taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();
    $taggedCache->clearByTag('iblock_id_'.$_REQUEST['iblockId']);

    if (LANGUAGE_ID == 'he') {
        if ($countRaise <= 0) {
            echo 'none';
        } else {
            echo '(' .$countRaise . ') '.'להקפיץ' ;
        }

    }else{
        if ($countRaise <= 0) {
            echo 'none';
        } else {
            echo 'Raise (' . $countRaise . ')';
        }
    }
}



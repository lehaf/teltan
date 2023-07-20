<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Localization\Loc;

CModule::IncludeModule('iblock');
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('highloadblock');
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
$arSelect = [];
$b = false;


switch ($_REQUEST['data']['iblockId']){
    case 1:
        $arSelect = ['UF_USER_ID'=> $USER->GetID(),'UF_TYPE'=> 'FLEA'];
        $typeOperand = 'FLEA';
        $entity_data_class = GetEntityDataClass(28);
        $rsData = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => $arSelect
        ));
        while ($arPaket[] = $rsData->fetch()) {

        }
        foreach($arPaket as $arItem){
            $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'] ;
            if($a > 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ '. $arItem['UF_DAYS_REMAIN']. ' days'))){
                $b = true;
            }
        }
        if($arUser['UF_DAYS_FREE1'] - $arUser['UF_COUNT_FLEA'] > 0 || $b) {

        }else{
            $error = true;
        }

        break;
    case 2:
        $arSelect = ['UF_USER_ID'=> $USER->GetID(), 'UF_TYPE'=> 'Prop'];
        $typeOperand = 'Prop';
        $entity_data_class = GetEntityDataClass(28);
        $rsData = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => $arSelect
        ));
        while ($arPaket[] = $rsData->fetch()) {

        }
        foreach($arPaket as $arItem){
            $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'] ;
            if($a > 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ '. $arItem['UF_DAYS_REMAIN']. ' days'))){
                $b = true;
            }
        }
        if($arUser['UF_DAYS_FREE3'] - $arUser['UF_COUNT_APART'] > 0 || $b) {

        }else{
            $error = true;
        }
        break;
    case 7:
    case 8:
    case 3:
        $arSelect = ['UF_USER_ID'=> $USER->GetID(), 'UF_TYPE'=> 'AUTO'];
        $typeOperand = 'AUTO';
    $entity_data_class = GetEntityDataClass(28);
    $rsData = $entity_data_class::getList(array(
        'select' => array('*'),
        'filter' => $arSelect
    ));
    while ($arPaket[] = $rsData->fetch()) {

    }
    foreach($arPaket as $arItem){
        $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'] ;
        if($a > 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ '. $arItem['UF_DAYS_REMAIN']. ' days'))){
            $b = true;
        }
    }
    if($arUser['UF_UF_DAYS_FREE2'] - $arUser['UF_COUNT_AUTO'] > 0 || $b) {

    }else{
        $error = true;
    }
        break;
}





$PRODUCT_ID = IntVal($_REQUEST['data']['itemId']);



    $el = new CIBlockElement;
    if ($_REQUEST['value'] == 'green') {
        $arLoadProductArray = array(
            "ACTIVE" => "N",
        );
        $return = 'не отображать';
        $VIO = 0;
        switch ($typeOperand){
            case 'FLEA':
                $user = new CUser;
                foreach($arUser['UF_COUNT_ITEM_FLEA'] as $key => $item){
                    if ($item == floatval($PRODUCT_ID)){
                        unset($arUser['UF_COUNT_ITEM_FLEA'][$key]);

                        $fields = array(
                            'UF_COUNT_FLEA' => --$arUser['UF_COUNT_FLEA'],
                            'UF_COUNT_ITEM_FLEA' =>  $arUser['UF_COUNT_ITEM_FLEA']
                        );
                        if($fields['UF_COUNT_FLEA'] == 0){
                            $fields['UF_DAYS_FLEA_REMAIN'] = 30;
                        }
                        $user->Update($USER->GetID(), $fields);
                        $VIO++;
                    }
                   if($VIO < 1) {
                        foreach ($arPaket as $arItem) {
                            $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'];
                            if ($a >= 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ ' . $arItem['UF_DAYS_REMAIN'] . ' days'))) {
                                $idForUpdate = $arItem['ID'];
                                foreach($arItem['UF_ID_ANONC'] as $key => $item){
                                    if ($item == $PRODUCT_ID){
                                        unset($arItem['UF_ID_ANONC'][$key]);
                                    }
                                }
                                $entity_data_class = GetEntityDataClass(28);
                                if($arItem['UF_COUNT_LESS'] == 0){
                                    var_dump($idForUpdate);
                                    $result = $entity_data_class::update($idForUpdate, array(
                                        'UF_COUNT_LESS' => 0,
                                        'UF_ID_ANONC' => $arItem['UF_ID_ANONC']
                                    ));
                                }else {
                                    $result = $entity_data_class::update($idForUpdate, array(
                                        'UF_COUNT_LESS' => --$arItem['UF_COUNT_LESS'],
                                        'UF_ID_ANONC' => $arItem['UF_ID_ANONC']
                                    ));
                                }
                                break;
                            }
                        }
                    }

                }
                break;
            case 'Prop':
                $user = new CUser;
                foreach($arUser['UF_COUNT_ITEM_PROP'] as $key => $item){
                    if ($item == floatval($PRODUCT_ID)){
                        unset($arUser['UF_COUNT_ITEM_PROP'][$key]);

                        $fields = array(
                            'UF_COUNT_APART' => --$arUser['UF_COUNT_APART'],
                            'UF_COUNT_ITEM_PROP' =>  $arUser['UF_COUNT_ITEM_PROP']
                        );
                        if($fields['UF_COUNT_APART'] == 0){
                            $fields['UF_DAYS_PROP_REMAIN'] = 30;
                        }
                        $user->Update($USER->GetID(), $fields);
                        $VIO++;
                    }
                    if($VIO < 1) {
                        foreach ($arPaket as $arItem) {
                            $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'];
                            if ($a >= 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ ' . $arItem['UF_DAYS_REMAIN'] . ' days'))) {
                                $idForUpdate = $arItem['ID'];
                                foreach($arItem['UF_ID_ANONC'] as $key => $item){
                                    if ($item == $PRODUCT_ID){
                                        unset($arItem['UF_ID_ANONC'][$key]);
                                    }
                                }
                                if($arItem['UF_COUNT_LESS'] == 0){
                                    $result = $entity_data_class::update($idForUpdate, array(
                                        'UF_COUNT_LESS' => 0,
                                        'UF_ID_ANONC' => $arItem['UF_ID_ANONC']
                                    ));
                                }else {
                                    $result = $entity_data_class::update($idForUpdate, array(
                                        'UF_COUNT_LESS' => --$arItem['UF_COUNT_LESS'],
                                        'UF_ID_ANONC' => $arItem['UF_ID_ANONC']
                                    ));
                                }
                                break;
                            }
                        }
                    }

                }
                break;
            case 'AUTO':

                    $user = new CUser;
                    foreach($arUser['UF_COUNT_ITEM_AUTO'] as $key => $item){
                        if ($item == floatval($PRODUCT_ID)){
                            unset($arUser['UF_COUNT_ITEM_AUTO'][$key]);

                            $fields = array(
                                'UF_COUNT_AUTO' => --$arUser['UF_COUNT_AUTO'],
                                'UF_COUNT_ITEM_AUTO' =>  $arUser['UF_COUNT_ITEM_AUTO']
                            );
                            if($fields['UF_COUNT_AUTO'] == 0){
                                $fields['UF_DAYS_AUTO_REMAIN'] = 30;
                            }
                            $user->Update($USER->GetID(), $fields);
                            $VIO++;
                        }
                        if($VIO < 1) {
                            foreach ($arPaket as $arItem) {
                                $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'];
                                if ($a >= 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ ' . $arItem['UF_DAYS_REMAIN'] . ' days'))) {
                                    $idForUpdate = $arItem['ID'];
                                    foreach($arItem['UF_ID_ANONC'] as $key => $item){
                                        if ($item == $PRODUCT_ID){
                                            unset($arItem['UF_ID_ANONC'][$key]);
                                        }
                                    }
                                    $entity_data_class = GetEntityDataClass(28);
                                    if($arItem['UF_COUNT_LESS'] == 0){
                                        $result = $entity_data_class::update($idForUpdate, array(
                                            'UF_COUNT_LESS' => 0,
                                            'UF_ID_ANONC' => $arItem['UF_ID_ANONC']
                                        ));
                                    }else {
                                        $result = $entity_data_class::update($idForUpdate, array(
                                            'UF_COUNT_LESS' => --$arItem['UF_COUNT_LESS'],
                                            'UF_ID_ANONC' => $arItem['UF_ID_ANONC']
                                        ));
                                    }
                                    break;
                                }
                            }
                        }

                    }
                break;
        }
echo Loc::getMessage('DEACTIVATE_ITEM');
    } else {
        if ($_REQUEST['value'] == 'red') {
            if (!$error) {
                $arLoadProductArray = array(
                    "ACTIVE" => "Y",
                );
                $return = 'отображать';
                switch ($typeOperand) {
                    case 'FLEA':
                        if ($arUser['UF_DAYS_FREE1'] - $arUser['UF_COUNT_FLEA'] > 0) {
                            $user = new CUser;
                            $arUser['UF_COUNT_ITEM_FLEA'][] = intval($PRODUCT_ID);
                            $fields = array(
                                'UF_COUNT_FLEA' => ++$arUser['UF_COUNT_FLEA'],
                                'UF_COUNT_ITEM_FLEA' => $arUser['UF_COUNT_ITEM_FLEA']
                            );
                            $user->Update($USER->GetID(), $fields);
                        } else {

                            foreach ($arPaket as $arItem) {
                                $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'];
                                if ($a > 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ ' . $arItem['UF_DAYS_REMAIN'] . ' days'))) {
                                    $idForUpdate = $arItem['ID'];
                                    $arItem['UF_ID_ANONC'][] = intval($PRODUCT_ID);
                                    $entity_data_class = GetEntityDataClass(28);
                                    $result = $entity_data_class::update($idForUpdate, array(
                                        'UF_COUNT_LESS' => ++$arItem['UF_COUNT_LESS'],
                                        'UF_ID_ANONC' => $arItem['UF_ID_ANONC']
                                    ));
                                    break;
                                }
                            }
                        }
                        break;
                    case 'Prop':
                        if ($arUser['UF_DAYS_FREE3'] - $arUser['UF_COUNT_APART'] > 0) {
                            print_r(++$arUser['UF_COUNT_APART']);
                            $user = new CUser;
                            $arUser['UF_COUNT_ITEM_PROP'][] = intval($PRODUCT_ID);
                            $fields = array(
                                'UF_COUNT_APART' => ++$arUser['UF_COUNT_APART'],
                                'UF_COUNT_ITEM_PROP' => $arUser['UF_COUNT_ITEM_PROP']
                            );
                            $user->Update($USER->GetID(), $fields);
                        } else {

                            foreach ($arPaket as $arItem) {
                                $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'];
                                if ($a > 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ ' . $arItem['UF_DAYS_REMAIN'] . ' days'))) {
                                    $idForUpdate = $arItem['ID'];
                                    $arItem['UF_ID_ANONC'][] = intval($PRODUCT_ID);
                                    $entity_data_class = GetEntityDataClass(28);
                                    $result = $entity_data_class::update($idForUpdate, array(
                                        'UF_COUNT_LESS' => ++$arItem['UF_COUNT_LESS'],
                                        'UF_ID_ANONC' => $arItem['UF_ID_ANONC']
                                    ));
                                    break;
                                }
                            }
                        }
                        break;
                    case 'AUTO':

                        if ($arUser['UF_UF_DAYS_FREE2'] - $arUser['UF_COUNT_AUTO'] > 0) {
                            // print_r(++$arUser['UF_COUNT_AUTO']);
                            $user = new CUser;
                            $arUser['UF_COUNT_ITEM_AUTO'][] = intval($PRODUCT_ID);
                            $fields = array(
                                'UF_COUNT_AUTO' => ++$arUser['UF_COUNT_AUTO'],
                                'UF_COUNT_ITEM_AUTO' => $arUser['UF_COUNT_ITEM_AUTO']
                            );
                            $user->Update($USER->GetID(), $fields);
                        } else {

                            foreach ($arPaket as $arItem) {
                                $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'];
                                if ($a > 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ ' . $arItem['UF_DAYS_REMAIN'] . ' days'))) {
                                    $idForUpdate = $arItem['ID'];
                                    $arItem['UF_ID_ANONC'][] = intval($PRODUCT_ID);
                                    $entity_data_class = GetEntityDataClass(28);
                                    $result = $entity_data_class::update($idForUpdate, array(
                                        'UF_COUNT_LESS' => ++$arItem['UF_COUNT_LESS'],
                                        'UF_ID_ANONC' => $arItem['UF_ID_ANONC']
                                    ));
                                    break;
                                }
                            }
                        }
                        break;
                }
                echo Loc::getMessage('ACTIVATE_ITEM');
            }else{
                echo'error';
            }
        }
    }

    $res = $el->Update($PRODUCT_ID, $arLoadProductArray);



require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
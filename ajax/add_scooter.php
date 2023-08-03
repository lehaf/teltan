<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('highloadblock');

$entity_data_class = GetEntityDataClass(28);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    'filter' => array('UF_USER_ID'=> $USER->GetID(), 'UF_TYPE'=> 'AUTO')
));
while ($arPaket[] = $rsData->fetch()) {

}
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

$b = false;
foreach($arPaket as $arItem){
    $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'] ;
    if($a > 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ '. $arItem['UF_DAYS_REMAIN']. ' days'))){
        $b = true;
    }
}
if($arUser['UF_UF_DAYS_FREE2'] - $arUser['UF_COUNT_AUTO'] > 0 || $b || $_REQUEST['EDIT'] == 'Y') {
$el = new CIBlockElement;
$checkedVaue = [];
$count = 0;
$unCheckedValue = [];
$stringValue = [];
$PROP = [];
foreach($_REQUEST as $arItem){

    if(is_string($arItem) == false){
        if($arItem['val'] == 'true') {
            $checkedVaue[] = $arItem;
        }else{
            $stringValue[] = $arItem;
        }
    }else{
        $stringValue[] = $arItem;
    }
    $count++;
}

foreach($stringValue as $arItem){
    if(is_string($arItem) == false && $arItem['val'] != 'on'){
        $PROP[$arItem["data"]["id_prop"]] = $arItem["val"];
    }
}
foreach($checkedVaue as $arItem){
    $PROP[$arItem["data"]["id_prop"]] = $arItem["data"]["idSelf"];
}

//var_dump($stringValue);
$FILENAME = $USER->GetID();

$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST["img-base64"]));

file_put_contents($_SERVER["DOCUMENT_ROOT"].'/imgbs64.png', $data);

$arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/imgbs64.png");
    if($_REQUEST['anytime']['val'] == 'true'){
        $PROP['UF_CALL_ANYTIME'] = 1;
    }else{
        $PROP['UF_CALL_TO'] = $_REQUEST['$data2']['callTo'][1] . ':00';
        $PROP['UF_CALL_FROM'] = $_REQUEST['$data2']['callFrom'][1] . ':00';
    }
    if($_REQUEST['PriceExchangeIsPossible']['val'] == 'true'){
        $PROP['UF_WITH_EXCHANGE'] = 1;
    }else{
        $PROP['UF_WITH_EXCHANGE'] = '';
    }
    if($_REQUEST['PriceExchangeIsPossible']['val'] == 'true'){
        $PROP['UF_WITH_VAT'] = 1;
    }else{
        $PROP['UF_WITH_VAT'] = '';
    }
$PROP['PRICE'] = $_POST['userItemPrice']['val'];
$PROP['TIME_RAISE'] = date("d.m.Y H:i:s");
$PROP['PROP_MODIFICATION'] = $_POST['Modification']['val'];
$PROP['UF_PHONE_1'] = $_POST['phone1']['val'];
$PROP['UF_PHONE_2'] = $_POST['phone2']['val'];
$PROP['UF_PHONE_3'] = $_POST['phone3']['val'];
$PROP['UF_NAME'] = $_POST['Legalname']['val'];
$PROP['LOCATION'] = $_POST['LOCATION'];
$SECTION_ID = $PROP['PROP_BRAND'];
if (isset($PROP['PROP_MODEL'])){
    $SECTION_ID = $PROP['PROP_MODEL'];
}
    $res = CIBlockSection::GetByID($PROP['PROP_BRAND']);
    if($ar_res = $res->GetNext())
        $PROP['PROP_BRAND'] = $ar_res['NAME'];
    $res = CIBlockSection::GetByID($PROP['PROP_MODEL']);
    if($ar_res = $res->GetNext())
        $PROP['PROP_MODEL'] = $ar_res['NAME'];
$NAME = $PROP['PROP_BRAND'] . ' ' . $PROP['PROP_MODEL'] . ' ' .   $_POST['Modification']['val'] .' '. $PROP['PROP_YAERH'];
//$PROP[146] = $_POST['phone3']['val'];
$PROP['ID_USER'] = $USER->GetID();
$arParams = array("replace_space"=>"-","replace_other"=>"-");
$translit = Cutil::translit($NAME,"ru",$arParams) . $USER->GetID(). randString(10);;
    foreach ($_POST['$data2'] as $key => $data){
        if ($data[0] != '') {
            $PROP[$data[0]] = $data[1];
        }elseif( $key == 'PROP_BODY_TYPE_val'){
            $PROP['PROP_BODY_TYPE'] = $data[1];
        }
    }
    if ($_REQUEST['EDIT'] != 'Y') {
        $arLoadProductArray = array(
            'MODIFIED_BY' => $GLOBALS['USER']->GetID(),
            // 'IBLOCK_SECTION_ID' => (int)$_POST['section_id']['id_section'],
            'IBLOCK_ID' => SCOOTER_IBLOCK_ID,
            'IBLOCK_SECTION_ID' => $SECTION_ID,
            'CODE' => $translit,
            'PROPERTY_VALUES' => $PROP,
            'NAME' => $NAME,
            'ACTIVE' => 'Y',
            'PREVIEW_TEXT' => $_POST['itemDescription'],
            'DETAIL_TEXT' => $_POST['itemDescription'],
           /* 'PREVIEW_PICTURE' => $arFile,
            'DETAIL_PICTURE' => $arFile*/
        );
    }else{
        $arLoadProductArray = array(
            'MODIFIED_BY' => $GLOBALS['USER']->GetID(),
            // 'IBLOCK_SECTION_ID' => (int)$_POST['section_id']['id_section'],
            'IBLOCK_ID' => SCOOTER_IBLOCK_ID,
            'IBLOCK_SECTION_ID' => $SECTION_ID,
            'CODE' => $translit,
            'PROPERTY_VALUES' => $PROP,
            'NAME' => $NAME,
            'PREVIEW_TEXT' => $_POST['itemDescription'],
            'DETAIL_TEXT' => $_POST['itemDescription'],
            /*'PREVIEW_PICTURE' => $arFile,
            'DETAIL_PICTURE' => $arFile*/
        );
    }
    if($arFile["type"]== "image/png" || $arFile["type"]== "image/jpeg" ) {

    }else{
        unset($arLoadProductArray['PREVIEW_PICTURE']);
    }

    // Создание элемента
    if ($_REQUEST['EDIT'] != 'Y') {
        if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
            foreach ($_REQUEST as $value) {
                if ($value['val'] == 'true') {
                    $multiselect[$value['data']['id_prop']][] = $value['data']['idSelf'];
                }
            }

            if ($_POST['dateSelectSelector'] !== 'no-value') {
                CIBlockElement::SetPropertyValueCode($PRODUCT_ID, 'PROP_YAERH_Left', $_POST['dateSelectSelector']);
            }

            $arLoadProductProp['VIP_FLAG'] = 0; // по стандарту объявления не VIP
            if (!empty($_REQUEST['PROP_BODY_TYPE'])) $arLoadProductProp['PROP_BODY_TYPE'] =  $_REQUEST['PROP_BODY_TYPE'];
            if (!empty($_POST['region'])) $arLoadProductProp['UF_REGION'] = $_POST['region'];
            if (!empty($_POST['city'])) $arLoadProductProp['UF_CITY'] = $_POST['city'];
            foreach ($arLoadProductProp as $propCode => $propValue) {
                CIBlockElement::SetPropertyValueCode($PRODUCT_ID, $propCode, $propValue);
            }

            foreach ($multiselect as $key => $value) {
                if (!is_string($key) && !empty($key)) {
                    CIBlockElement::SetPropertyValueCode($PRODUCT_ID, $key, $value);
                }
            }

            if ($arUser['UF_UF_DAYS_FREE2'] - $arUser['UF_COUNT_AUTO'] > 0) {
                print_r(++$arUser['UF_COUNT_AUTO']);
                $user = new CUser;
                $arUser['UF_COUNT_ITEM_AUTO'][]= intval($PRODUCT_ID);
                $fields = array(
                    'UF_COUNT_AUTO' => ++$arUser['UF_COUNT_AUTO'],
                    'UF_COUNT_ITEM_AUTO' =>  $arUser['UF_COUNT_ITEM_AUTO']
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
                $mainPhoto = 0;

                $i = 1;
                foreach ($_POST['img'] as $item) {
                    $FILENAME = rand();
                    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $item[0]));
                    file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', $data);
                    $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');

                    if ($item[5] > 0){
                        $rotate = (int)$item[5] * 90 * 3;
                        RotateJpg($item[0], $rotate , $_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png' , $arFile['type']);
                    }

                    $arFile["MODULE_ID"] = "iblock";

                    if ($item[4] == 'isActive'){
                        $arLoadProductArray = array(
                            'PREVIEW_PICTURE' => $arFile,
                            'DETAIL_PICTURE' => $arFile
                        );
                        $el->Update($PRODUCT_ID, $arLoadProductArray);
                        $mainPhoto++;
                    }elseif(count($_POST['img']) == $i && $mainPhoto == 0){
                        $arLoadProductArray = array(
                            'PREVIEW_PICTURE' => $arFile,
                            'DETAIL_PICTURE' => $arFile
                        );
                        $el->Update($PRODUCT_ID, $arLoadProductArray);
                        $mainPhoto++;
                    }else{
                        CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "PHOTOS", array("VALUE" => $arFile));
                    }
                    unlink($_SERVER["DOCUMENT_ROOT"].'/' . $FILENAME . '.png');
                    $i++;
                }
            }
            echo json_encode(array('success' => 1));
        } else {
            echo json_encode(array('success' => 0, 'responseBitrix' => $el->LAST_ERROR), JSON_UNESCAPED_UNICODE);
        }

    // Редактирование элемента
    } else {

        if($PROP['PROP_BRAND'] == null || $PROP['PROP_MODEL'] == null || $PROP['Modification']['val'] == null ){
            unset($arLoadProductArray['NAME']);
        }

        foreach ($arLoadProductArray as $key => $value){
            if($value == ''){
                unset($arLoadProductArray[$key]);
            }

        }
        $arLoadProductProp = [];
        foreach ($arLoadProductArray['PROPERTY_VALUES'] as $key => $value){
            if($value == ''){
                unset($arLoadProductArray['PROPERTY_VALUES'][$key]);
            }else {
                $arLoadProductProp[$key] = $value;
            }

        }
        unset($arLoadProductArray['PROPERTY_VALUES']);
        if($res = $el->Update(intval($_REQUEST['EDIT_ID']), $arLoadProductArray)){
            foreach ($_REQUEST as $value) {
                if ($value['val'] == 'true') {
                    $multiselect[$value['data']['id_prop']][] = $value['data']['idSelf'];
                }
            }

            if ($_POST['dateSelectSelector'] !== 'no-value') {
                CIBlockElement::SetPropertyValueCode($_REQUEST['EDIT_ID'], 'PROP_YAERH_Left', $_POST['dateSelectSelector']);
            }

            $arLoadProductProp['PROP_MODIFICATION'] = $_POST['Modification']['val'];
            $arLoadProductProp['UF_REGION'] = $_POST['region'];
            $arLoadProductProp['UF_CITY'] = $_POST['city'];
            foreach ($arLoadProductProp as $key => $value) {
                CIBlockElement::SetPropertyValueCode($_REQUEST['EDIT_ID'], $key, $value);
            }
            foreach ($multiselect as $key => $value) {
                if (!is_string($key) && !empty($key)) {

                    CIBlockElement::SetPropertyValueCode($_REQUEST['EDIT_ID'], $key, $value);
                }
            }
            $dbElements = \CIBlockElement::GetList([], ["ACTIVE" => "Y", "IBLOCK_ID" => 8, "ID" => intval($_REQUEST['EDIT_ID']),], false, false, ['IBLOCK_ID', 'ID', 'PROPERTY_PHOTOS',]);
            $neddAddMain = true;
            $index = 0;
            if (count($_POST['img']) >= 1) {
                foreach ($_POST['img'] as $key => $img) {

                    if ($img[4] == 'isActive') {
                        $neddAddMain = false;
                    }
                    $_POST['img'][$index] = $img;
                    unset($_POST['img'][$key]);
                    $index++;
                }

                if ($neddAddMain) {
                    $_POST['img'][0][4] = 'isActive';
                }

                foreach ($_POST['img'] as $key => $item) {

                    if ($item[5] > 0 && $item[4] != 'isActive' && $item[3] < 1 || preg_match('/^data:(\w*)\/(\w*);/', $item[0], $matches) > 0) {
                        $FILENAME = rand();

                        file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', file_get_contents($item[0]));
                        $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');
                        $arFile["MODULE_ID"] = "iblock";
                        $rotate = (int)$item[5] * 90 * 3;
                        if ($rotate > 0) {
                            RotateJpg($item[0], $rotate, $_SERVER["DOCUMENT_ROOT"] . str_replace(SITE_DOMAIN, '', $item[0]), $arFile['type']);
                        }
                        unlink($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');
                    }

                    if ($item[1]) {

                        if ($item[4] != 'isActive') {
                            unset($_POST['img'][$key]);
                        } else {

                        }
                        $allPhoto[] = $item[1];
                    }
                }

                while ($obFields = $dbElements->GetNext()) {
                    $aElementID = $obFields['ID'];
                    foreach ($obFields['PROPERTY_PHOTOS_VALUE'] as $iKeyValue => $sValue) {
                        if (!in_array($sValue, $allPhoto)) {
                            $arDeleteList["PHOTOS"][$obFields['PROPERTY_PHOTOS_PROPERTY_VALUE_ID'][$iKeyValue]] = [
                                'VALUE' => [
                                    'del' => 'Y',
                                ]
                            ];
                        }
                    }
                    if (!empty($arDeleteList)) {
                        foreach ($arDeleteList as $sPropForDelete => $arDeleteFiles) {
                            CIBlockElement::SetPropertyValueCode(
                                $aElementID,
                                $sPropForDelete,
                                $arDeleteFiles
                            );
                        }
                    }

                }

                $mainPhotoCount = 0;

                foreach ($_POST['img'] as $img) {

                    $FILENAME = rand();
                    file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', file_get_contents($img[0]));
                    $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');
                    preg_match('/^data:(\w*)\/(\w*);/', $img[0], $matches);
                    $rotate = (int)$img[5] * 90 * 3;
                    if ($rotate > 0) {
                        RotateJpg($img[0], $rotate, $_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', $arFile['type'], $matches);
                    }
                    $arFile["MODULE_ID"] = "iblock";

                    if ($img[4] == 'isActive') {
                        $arLoadProductArray['PREVIEW_PICTURE'] = $arFile;
                        $el->Update(intval($_REQUEST['EDIT_ID']), $arLoadProductArray);
                        $mainPhotoCount++;
                        $dbElements = \CIBlockElement::GetList([], ["ACTIVE" => "Y", "IBLOCK_ID" => 8, "ID" => intval($_REQUEST['EDIT_ID']),], false, false, ['IBLOCK_ID', 'ID', 'PROPERTY_PHOTOS',]);
                        while ($obFields = $dbElements->GetNext()) {
                            $aElementID = $obFields['ID'];
                            foreach ($obFields['PROPERTY_PHOTOS_VALUE'] as $iKeyValue => $sValue) {
                                if ($sValue == (int)$img[1]) {
                                    $arDeleteList["PHOTOS"][$obFields['PROPERTY_PHOTOS_PROPERTY_VALUE_ID'][$iKeyValue]] = [
                                        'VALUE' => [
                                            'del' => 'Y',
                                        ]
                                    ];
                                }
                            }
                            if (!empty($arDeleteList)) {
                                foreach ($arDeleteList as $sPropForDelete => $arDeleteFiles) {
                                    CIBlockElement::SetPropertyValueCode(
                                        $aElementID,
                                        $sPropForDelete,
                                        $arDeleteFiles
                                    );
                                }
                            }

                        }
                    } else {
                        CIBlockElement::SetPropertyValueCode(intval($_REQUEST['EDIT_ID']), "PHOTOS", array("VALUE" => $arFile));
                    }
                    unlink($_SERVER["DOCUMENT_ROOT"].'/'.$FILENAME.'.png');
                };
            }


            if (count($_POST['img']) < 1 || $_POST['img'][0][0] == null) {
                $arLoadProductArray = array(
                    "PREVIEW_PICTURE" => array('del' => 'Y'),
                    "DETAIL_PICTURE" => array('del' => 'Y'),
                );
                $el->Update(intval($_REQUEST['EDIT_ID']), $arLoadProductArray);
                while ($obFields = $dbElements->GetNext()) {
                    $aElementID = $obFields['ID'];
                    foreach ($obFields['PROPERTY_PHOTOS_VALUE'] as $iKeyValue => $sValue) {
                        if (!in_array($sValue, $allPhoto)) {
                            $arDeleteList["PHOTOS"][$obFields['PROPERTY_PHOTOS_PROPERTY_VALUE_ID'][$iKeyValue]] = [
                                'VALUE' => [
                                    'del' => 'Y',
                                ]
                            ];
                        }
                    }
                    if (!empty($arDeleteList)) {
                        foreach ($arDeleteList as $sPropForDelete => $arDeleteFiles) {
                            CIBlockElement::SetPropertyValueCode(
                                $aElementID,
                                $sPropForDelete,
                                $arDeleteFiles
                            );
                        }
                    }

                }
            }
            if ($mainPhotoCount < 1) {
                $FILENAME = rand();
                $img = array_shift($arMain);
                file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', file_get_contents($img[0]));
                $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');
                $arFile["MODULE_ID"] = "iblock";
                $arLoadProductArray = array(
                    "PREVIEW_PICTURE" => $arFile,
                    "DETAIL_PICTURE" => $arFile,
                );
                $el->Update(intval($_REQUEST['EDIT_ID']), $arLoadProductArray);
            }

            echo json_encode(array('success' => 1));
        }else {
            echo json_encode(array('success' => 0, 'responseBitrix' => $el->LAST_ERROR), JSON_UNESCAPED_UNICODE);
        }
    }
}else{
    echo json_encode(array('success' => 0, 'responseBitrix' => 'У вас закончились объявления!'), JSON_UNESCAPED_UNICODE);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
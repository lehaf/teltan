<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

CModule::IncludeModule('highloadblock');

$entity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
$arPaket = $entity::getList(array(
    'select' => array('*'),
    'filter' => array('UF_USER_ID'=> $USER->GetID(), 'UF_TYPE'=> 'AUTO'),
    'cache' => [
        'ttl' => 360000,
        'cache_joins' => true
    ]
))->fetchAll();

$arUser = CUser::GetByID($USER->GetID())->Fetch();

$b = false;
foreach ($arPaket as $arItem) {
    $a = $arItem['UF_COUNT_REMAIN'] - $arItem['UF_COUNT_LESS'];
    if ($a > 0 || date("d.m.Y H:i:s") < date("d.m.Y H:i:s", strtotime('+ ' . $arItem['UF_DAYS_REMAIN'] . ' days'))) {
        $b = true;
    }
}

if ($arUser['UF_COUNT_RENT'] > $arUser['UF_COUNT_APART'] || $b || $_REQUEST['EDIT'] == 'Y') {
    CModule::IncludeModule('iblock');
    $el = new CIBlockElement;
    $checkedVaue = [];
    $count = 0;
    $unCheckedValue = [];
    $stringValue = [];
    $PROP = [];
    foreach ($_REQUEST as $arItem) {

        if (is_string($arItem) == false) {
            if ($arItem['val'] == 'true') {
                $checkedVaue[] = $arItem;
            } else {
                $stringValue[] = $arItem;
            }
        } else {
            $stringValue[] = $arItem;
        }
        $count++;
    }

    foreach ($stringValue as $arItem) {
        if (is_string($arItem) == false && $arItem['val'] != 'on' && !empty($arItem['val'])) {
            $PROP[$arItem["data"]["id_prop"]] = $arItem["val"];
        }
    }
    foreach ($checkedVaue as $arItem) {
        $PROP[$arItem["data"]["id_prop"]] = $arItem["data"]["idSelf"];
    }
    $PROP['MAP_LATLNG'] = $_REQUEST['MAP_LATLNG'];
    $PROP['MAP_POSITION'] = $_REQUEST['MAP_POSITION'];
    $PROP['MAP_LAYOUT'] = $_REQUEST['MAP_LAYOUT'];
    $PROP['MAP_LAYOUT_BIG'] = $_REQUEST['MAP_LAYOUT_BIG'];
    $arJJ = ['parent-id' => base64_encode($_REQUEST['MAP_LAYOUT_BIG']), 'id' => $_REQUEST['MAP_LAYOUT']];
    $jsonMapData = json_encode($arJJ);
    $PROP['MAP_LAYOUT_JSON'] = implode(":", $arJJ);

    switch ($PROP[109]) {
        case 114:
            $countRooms = 1;
            break;
        case 115:
            $countRooms = 2;
            break;
        case 116:
            $countRooms = 3;
            break;
        case 117:
            $countRooms = 4;
            break;
        case 118:
            $countRooms = 5;
            break;
    }

    if ($_POST["typeResidential"]["val"] == 'true') {
        $sectionIdNedv = 34;
        $PROP['BUY'] = 150;
        $NAME = $PROP['PROP_TYPE_APART'] . ' ' . $PROP[174] . 'm2' . ' этаж ' . $PROP['PROP_FLOOR'] . '|' . $PROP['PROP_FLOOR_IN'] . ' комнат - ' . $countRooms;
    } elseif ($_POST["typeNewBuildings"]["val"] == 'true') {
        $sectionIdNedv = 30;
        $PROP['BUY'] = 150;
        $NAME = $PROP['PROP_TYPE_APART'] . ' ' . $PROP[174] . 'm2' . ' этаж ' . $PROP['PROP_FLOOR'] . '|' . $PROP['PROP_FLOOR_IN'] . ' комнат - ' . $countRooms;
    } elseif ($_POST["typeCommercial"]["val"] == 'true') {
        $sectionIdNedv = 32;
        $PROP['BUY'] = 150;
        $NAME = $PROP['PROP_TYPE_APART'] . ' ' . $PROP[174] . 'm2' . ' этаж ' . $PROP['PROP_FLOOR'] . '|' . $PROP['PROP_FLOOR_IN'];
    }

    $FILENAME = $USER->GetID();
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST["img-base64"]));
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/imgbs64.png', $data);

    $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/imgbs64.png");
    if ($_REQUEST['anytime']["val"] == 'true') {
        $PROP['UF_CALL_ANYTIME'] = 1;
    } else {
        $PROP['UF_CALL_ANYTIME'] = 0;
        $PROP['UF_CALL_TO'] = $_REQUEST['callTo'] . ':00';
        $PROP['UF_CALL_FROM'] = $_REQUEST['callFrom'] . ':00';
    }

    if ($_REQUEST['forOwner']['val'] == 'true') {
        $PROP['UF_SELLER_TYPE'] = 312;
    } elseif ($_REQUEST['forAgency']['val'] == 'true') {
        $PROP['UF_SELLER_TYPE'] = 313;
    }

    $PROP['UF_NAME'] = $_REQUEST['Legalname']['val'];
    $PROP[61] = $_POST['sellPrice']['val'];
    $PROP[114] = date("d.m.Y H:i:s");
    $PROP[141] = $_POST['phone1']['val'];
    $PROP[142] = $_POST['phone2']['val'];
    $PROP[143] = $_POST['phone3']['val'];
    //$PROP[134] = $_POST['Legalname']['val'];
    foreach ($_REQUEST as $value) {
        if ($value['val'] == 'true') {
            $multiselect[$value['data']['id_prop']][] = $value['data']['idSelf'];
        }
        if ($value['data']['id_prop'] == 166 && $value['val'] == 'true') {
            $restriction[] = $value['data']['idSelf'];
        }
    }
    $PROP['ID_USER'] = $USER->GetID();
    $PROP['PROP_Completion'] = date("d.m.Y H:i:s", strtotime($_POST['PROP_Completion'] ));
    $arParams = array("replace_space" => "-", "replace_other" => "-");
    $translit = Cutil::translit($NAME, "ru", $arParams) . $USER->GetID(). randString(10);;
    if ($PROP[109] > 1){
        $PROP['NOT_FIRST'] = 'Y';
        $PROP['NOT_LAST'] = 'Y';
    }

    $PROP['IMMEDIATELY_ENTRY'] = 'Y';
    if ($_REQUEST['EDIT'] != 'Y') {
        $arLoadProductArray = array(
            'MODIFIED_BY' => $GLOBALS['USER']->GetID(),
            'IBLOCK_SECTION_ID' => $sectionIdNedv,
            'IBLOCK_ID' => 2,
            'CODE' => $translit,
            'PROPERTY_VALUES' => $PROP,
            'NAME' => $NAME,
            'ACTIVE' => 'Y',
            'PREVIEW_TEXT' => $_POST['itemDescription'],
            'DETAIL_TEXT' => $_POST['itemDescription'],
            // 'PREVIEW_PICTURE' => $arFile,
            // 'DETAIL_PICTURE' => $arFile
        );
    } else {
        $arLoadProductArray = array(
            'MODIFIED_BY' => $GLOBALS['USER']->GetID(),
            'IBLOCK_SECTION_ID' => $sectionIdNedv,
            'IBLOCK_ID' => 2,
            'CODE' => $translit,
            'PROPERTY_VALUES' => $PROP,
            'NAME' => $NAME,
            'ACTIVE' => 'Y',
            'PREVIEW_TEXT' => $_POST['itemDescription'],
            'DETAIL_TEXT' => $_POST['itemDescription'],
            //  'PREVIEW_PICTURE' => $arFile,
            //   'DETAIL_PICTURE' => $arFile
        );
    }

    if ($arFile["type"] == "image/png" || $arFile["type"] == "image/jpeg") {

    } else {
        unset($arLoadProductArray['PREVIEW_PICTURE']);
    }

    // Создание нового элемента
    if ($_REQUEST['EDIT'] != 'Y') {

        if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
            foreach ($_REQUEST as $value) {
                if ($value['val'] == 'true') {
                    $multiselect[$value['data']['id_prop']][] = $value['data']['idSelf'];
                }
            }
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_FLAG", 0);
            $arLoadProductProp['UF_REGION'] = $_POST['region'];
            $arLoadProductProp['UF_CITY'] = $_POST['city'];
            foreach ($multiselect as $key => $value) {
                if (!is_string($key) && !empty($key)) {
                    CIBlockElement::SetPropertyValueCode($PRODUCT_ID, $key, $value);
                }
            }

            foreach ($multiselect as $key => $value) {
                if (!is_string($key) && !empty($key)) {
                    CIBlockElement::SetPropertyValueCode($PRODUCT_ID, $key, $value);
                }
            }

            // Увеличение счетчика объявлений
            $user = new \CUser;
            $arUser['UF_COUNT_ITEM_PROP'][] = intval($PRODUCT_ID);
            $fields = array(
                'UF_COUNT_APART' => ++$arUser['UF_COUNT_APART'],
                'UF_COUNT_ITEM_PROP' => $arUser['UF_COUNT_ITEM_PROP']
            );
            $user->Update($USER->GetID(), $fields);

            if ($arUser['UF_DAYS_FREE3'] - $arUser['UF_COUNT_APART'] <= 0) {
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
            $mainPhoto = 0;

            $i = 1;

            foreach ($_POST['img'] as $item) {
                $FILENAME = rand();

                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $item[0]));

                file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', $data);

                $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');
                if ($item[5] > 0 && $item[5] != 'i') {
                    $rotate = (int)$item[5] * 90 * 3;
                    RotateJpg($item[0], $rotate, $_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', $arFile['type']);
                }
                $arFile["MODULE_ID"] = "iblock";

                if ($item[4] == 'isActive') {
                    $arLoadProductArray = array(
                        'PREVIEW_PICTURE' => $arFile,
                        'DETAIL_PICTURE' => $arFile
                    );
                    $el->Update($PRODUCT_ID, $arLoadProductArray);
                    $mainPhoto++;
                } elseif (count($_POST['img']) == $i && $mainPhoto == 0) {
                    $arLoadProductArray = array(
                        'PREVIEW_PICTURE' => $arFile,
                        'DETAIL_PICTURE' => $arFile
                    );
                    $el->Update($PRODUCT_ID, $arLoadProductArray);
                    $mainPhoto++;
                } else {
                    CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "PHOTOS", array("VALUE" => $arFile));
                }
                unlink($_SERVER["DOCUMENT_ROOT"].'/' . $FILENAME . '.png');
                $i++;
            }
            echo json_encode(array('success' => 1));
        } else {
            echo json_encode(array('success' => 0, 'responseBitrix' => $el->LAST_ERROR), JSON_UNESCAPED_UNICODE);
        }
      /*  foreach ($_POST['img'] as $item) {
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $item));

            file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', $data);

            $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');

            $arFile["MODULE_ID"] = "iblock";
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "PHOTOS", array("VALUE" => $arFile));
        }*/

    // Редактирование элемента
    } else {
        if ($PROP['PROP_TYPE_APART'] == null || $PROP[174] == null || $PROP['PROP_FLOOR'] == null) {
            unset($arLoadProductArray['NAME']);
        }

        foreach ($arLoadProductArray as $key => $value) {
            if ($value == '') unset($arLoadProductArray[$key]);
        }

        $arLoadProductProp = [];
        foreach ($arLoadProductArray['PROPERTY_VALUES'] as $key => $value) {
            if ($value == '') {
                unset($arLoadProductArray['PROPERTY_VALUES'][$key]);
            } else {
                $arLoadProductProp[$key] = $value;
            }
        }
        unset($arLoadProductProp);

        if ($res = $el->Update(intval($_REQUEST['EDIT_ID']), $arLoadProductArray)) {
            foreach ($_REQUEST as $value) {
                if ($value['val'] == 'true') $multiselect[$value['data']['id_prop']][] = $value['data']['idSelf'];
                if ($value['data']['id_prop'] == 166 && $value['val'] == 'true') $restriction[] = $value['data']['idSelf'];
            }

            if (empty($restriction)) $arLoadProductProp[166] = [];


            if ($_REQUEST['forOwner']['val'] == 'true') {
                $arLoadProductProp['UF_SELLER_TYPE'] = 312;
            } elseif ($_REQUEST['forAgency']['val'] == 'true') {
                $arLoadProductProp['UF_SELLER_TYPE'] = 313;
            }

            $arLoadProductProp['UF_NAME'] = $_REQUEST['Legalname']['val'];

            foreach ($arLoadProductProp as $key => $value) {
                CIBlockElement::SetPropertyValueCode($_REQUEST['EDIT_ID'], $key, $value);
            }

            foreach ($multiselect as $key => $value) {
                if (!is_string($key) && !empty($key)) {
                    CIBlockElement::SetPropertyValueCode($_REQUEST['EDIT_ID'], $key, $value);
                }
            }

            $arLoadProductProps = array('UF_SELLER_TYPE' => $arLoadProductProp['UF_SELLER_TYPE']);
            foreach ($arLoadProductProps as $key => $value) {
                CIBlockElement::SetPropertyValueCode($_REQUEST['EDIT_ID'], $key, $value);
            }

            echo json_encode(['success' => 1]);

            $dbElements = \CIBlockElement::GetList(
                [],
                ["ACTIVE" => "Y", "IBLOCK_ID" => PROPERTY_ADS_IBLOCK_ID, "ID" => intval($_REQUEST['EDIT_ID'])],
                false,
                false,
                ['IBLOCK_ID', 'ID', 'PROPERTY_PHOTOS']
            );
            $neddAddMain = true;
            $index = 0;
            if (!empty($_POST['img'])) {

                foreach ($_POST['img'] as $key => $img) {
                    if ($img[4] == 'isActive') $neddAddMain = false;
                    $_POST['img'][$index] = $img;
                    unset($_POST['img'][$key]);
                    $index++;
                }

                if ($neddAddMain) $_POST['img'][0][4] = 'isActive';

                foreach ($_POST['img'] as $key => $item) {
                    if ($item[5] > 0 && $item[4] != 'isActive' && $item[3] < 1 || preg_match('/^data:(\w*)\/(\w*);/', $item[0], $matches) > 0) {
                        $temporaryFilePath = $_SERVER["DOCUMENT_ROOT"] . '/' . rand() . '.png';
                        file_put_contents($temporaryFilePath, file_get_contents($item[0]));
                        $arFile = CFile::MakeFileArray($temporaryFilePath);
                        $arFile["MODULE_ID"] = "iblock";
                        $rotate = (int)$item[5] * 90 * 3;
                        RotateJpg($item[0], $rotate, $temporaryFilePath, $arFile['type']);
                        unlink($temporaryFilePath);
                    }

                    if ($item[1]) {
                        if ($item[4] != 'isActive') {
                            unset($_POST['img'][$key]);
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
                    $temporaryFilePath = $_SERVER["DOCUMENT_ROOT"] . '/' . rand() . '.png';
                    file_put_contents($temporaryFilePath, file_get_contents($img[0]));
                    $arFile = CFile::MakeFileArray($temporaryFilePath);
                    preg_match('/^data:(\w*)\/(\w*);/', $img[0], $matches);
                    $rotate = (int)$img[5] * 90 * 3;
                    $serverHost = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
                    $img[0] = str_replace($serverHost,$_SERVER['DOCUMENT_ROOT'],$img[0]);
                    $img[0] = explode('?',$img[0])[0];
                    RotateJpg($img[0], $rotate, $temporaryFilePath, $arFile['type'], $matches);
                    $arFile["MODULE_ID"] = "iblock";
                    if ($img[4] == 'isActive') {
                        $arLoadProductArray['PREVIEW_PICTURE'] = $arFile;
                        $el->Update(intval($_REQUEST['EDIT_ID']), $arLoadProductArray);
                        $mainPhotoCount++;
                        $dbElements = \CIBlockElement::GetList([], ["ACTIVE" => "Y", "IBLOCK_ID" => 2, "ID" => intval($_REQUEST['EDIT_ID']),], false, false, ['IBLOCK_ID', 'ID', 'PROPERTY_PHOTOS',]);
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
                    unlink($temporaryFilePath);
                }
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
                $temporaryFilePath = $_SERVER["DOCUMENT_ROOT"] . '/' . rand() . '.png';
                $img = array_shift($arMain);
                file_put_contents($temporaryFilePath, file_get_contents($img[0]));
                $arFile = CFile::MakeFileArray($temporaryFilePath);
                $arFile["MODULE_ID"] = "iblock";
                $arLoadProductArray = array(
                    "PREVIEW_PICTURE" => $arFile,
                    "DETAIL_PICTURE" => $arFile,
                );
                $el->Update(intval($_REQUEST['EDIT_ID']), $arLoadProductArray);
                unlink($temporaryFilePath);
            }
        } else {
            echo json_encode(array('success' => 0, 'responseBitrix' => $el->LAST_ERROR), JSON_UNESCAPED_UNICODE);
        }
    }
} else {
    echo json_encode(array('success' => 0, 'responseBitrix' => 'У вас закончились объявления!'), JSON_UNESCAPED_UNICODE);
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");

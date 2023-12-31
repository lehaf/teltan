<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('highloadblock');
$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();
$canUserCreateAds = canUserCreateAds(SIMPLE_ADS_IBLOCK_ID,FLEA_ADS_TYPE_CODE);

foreach ($_POST['img'] as $key => $value) {
    if (!preg_match("#^data:image/\w+;base64,#i", $value[0]))
        $_POST['img'][$key][0] = strstr($value[0], '?', true);
}

if ($canUserCreateAds || $_REQUEST['EDIT'] == 'Y') {

    $isFreeAdd = false;
    CModule::IncludeModule('iblock');
    $el = new CIBlockElement;
    $PROP = array();
    foreach ($_POST as $arElem) {
        if (is_string($arElem) == false) {
            if ($arElem['val'] == 'true') {
                $PROP[$arElem['data']["id_prop"]] = $arElem['data']["idSelf"];
            } elseif ($arElem['val'] != 'on') {
                $PROP[$arElem['data']["id_prop"]] = $arElem['val'];
            }
        }
    }
    $FILENAME = $userId;

    if ($_REQUEST['anytime']["val"] == 'true') {
        $PROP['UF_CALL_ANYTIME'] = 1;
    } else {
        $PROP['UF_CALL_TO'] = $_REQUEST['callTo']["val"] . ':00';
        $PROP['UF_CALL_FROM'] = $_REQUEST['callFrom']["val"] . ':00';
    }

    $PROP['TIME_RAISE'] = date("d.m.Y H:i:s");
    $PROP['LOCATION'] = $_POST['LOCATION'];
    $PROP['UF_REGION'] = $_POST['region'];
    $PROP['UF_CITY'] = $_POST['city'];
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST["img-base64"]));

    file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/imgbs64.png', $data);

    $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/imgbs64.png");
    if ($arFile['type'] == 'application/x-empty' || $arFile['type'] == 'application/octet-stream') {
        $arFile = [];
    }

    $PROP[15] = $_POST['itemPrice']['val'];
    $PROP[70] = date("d.m.Y H:i:s");
    $PROP['ID_USER'] = $userId;

    $arParams = array("replace_space" => "-", "replace_other" => "-");
    $translit = Cutil::translit($_POST['itemTitle']['val'], "ru", $arParams) . $userId . randString(10);
    if ($_REQUEST['EDIT'] != 'Y') {
        if ($_POST['section_id'] != null) {
            $arLoadProductArray = array(
                'MODIFIED_BY' => $GLOBALS['USER']->GetID(),
                'IBLOCK_SECTION_ID' => (int)$_POST['section_id'],
                'IBLOCK_ID' => SIMPLE_ADS_IBLOCK_ID,
                'CODE' => $translit,
                'PROPERTY_VALUES' => $PROP,
                'NAME' => $_POST['itemTitle']['val'],
                'ACTIVE' => 'Y',
                'PREVIEW_TEXT' => $_POST['itemDescription'],
                'DETAIL_TEXT' => $_POST['itemDescription'],
            );

            // Получаем всю инфу о самом первом активном купленном пакете
            $optimalUserRate = getOptimalActiveUserRate(FLEA_ADS_TYPE_CODE);
            // Если пользователь еще не создавал объявления то первое объявление будет бесплатным
            if (isExistActiveFreeAd(FLEA_ADS_TYPE_CODE) === false) {
                removeFreeAdPropOnAds(FLEA_ADS_TYPE_CODE);
                $isFreeAdd = true;
                $arLoadProductArray['PROPERTY_VALUES']['FREE_AD'] = getPropertyFreeAdValueId(SIMPLE_ADS_IBLOCK_ID);
                $unixTime = strtotime('+ '.DAYS_EXPIRED_FREE_ADS.' days');
                $arLoadProductArray['DATE_ACTIVE_TO'] = \Bitrix\Main\Type\DateTime::createFromTimestamp($unixTime);
            } else {
                $arLoadProductArray['DATE_ACTIVE_TO'] = $optimalUserRate['UF_DATE_EXPIRED'];
            }
        }
    } else {
        $arLoadProductArray = array(
            'MODIFIED_BY' => $GLOBALS['USER']->GetID(),
            'IBLOCK_SECTION_ID' => (int)$_POST['section_id'],
            'IBLOCK_ID' => SIMPLE_ADS_IBLOCK_ID,
            'CODE' => $translit,
            'PROPERTY_VALUES' => $PROP,
            'NAME' => $_POST['itemTitle']['val'],
            'PREVIEW_TEXT' => $_POST['itemDescription'],
            'DETAIL_TEXT' => $_POST['itemDescription'],
        );
    }

    if ($arFile["type"] !== "image/png" || $arFile["type"] !== "image/jpeg") unset($arLoadProductArray['PREVIEW_PICTURE']);

    $arLoadProductArray['PROPERTY_VALUES']['UF_PHONE_1'] = $_POST['itemPhone1']['val'];
    $arLoadProductArray['PROPERTY_VALUES']['UF_PHONE_2'] = $_POST['itemPhone2']['val'];
    $arLoadProductArray['PROPERTY_VALUES']['UF_PHONE_3'] = $_POST['itemPhone3']['val'];

    // Создание элемента
    if ($_REQUEST['EDIT'] != 'Y') {
        if ($_POST['section_id'] != null) {

            if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
                foreach ($_REQUEST as $value) {
                    if ($value['val'] == 'true') $multiselect[$value['data']['id_prop']][] = $value['data']['idSelf'];
                }

                CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_FLAG", 0);
                $arLoadProductProp['UF_REGION'] = $_POST['region'];
                $arLoadProductProp['UF_CITY'] = $_POST['city'];
                foreach ($multiselect as $key => $value) {
                    if (!is_string($key) && !empty($key)) CIBlockElement::SetPropertyValueCode($PRODUCT_ID, $key, $value);
                }

                // Увеличение счетчика объявлений
                $user = new \CUser;
                $arUser['UF_COUNT_ITEM_FLEA'][] = $PRODUCT_ID;
                $fields = array(
                    'UF_COUNT_FLEA' => ++$arUser['UF_COUNT_FLEA'],
                    'UF_COUNT_ITEM_FLEA' => $arUser['UF_COUNT_ITEM_FLEA']
                );
                $user->Update($userId, $fields);

                // Обновление пользовательских пакетов (Кпленных тарифов)
                if (!$isFreeAdd) {
                    $countAvailableAds = $optimalUserRate['UF_COUNT_REMAIN'] - $optimalUserRate['UF_COUNT_LESS'];
                    $unixTimeUntilUserRate = strtotime($optimalUserRate['UF_DATE_EXPIRED']);
                    $countActiveRateDays = floor(($unixTimeUntilUserRate - time()) / (60 * 60 * 24));
                    if (!empty($optimalUserRate['UF_DATE_PURCHASE']) && $countAvailableAds > 0 && time() < $unixTimeUntilUserRate) {
                        $optimalUserRate['UF_ID_ANONC'][] = intval($PRODUCT_ID);
                        $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
                        $boughtRateEntity::update($optimalUserRate['ID'], array(
                            'UF_COUNT_LESS' => ++$optimalUserRate['UF_COUNT_LESS'],
                            'UF_ID_ANONC' => $optimalUserRate['UF_ID_ANONC'],
                            'UF_DAYS_REMAIN' => $countActiveRateDays
                        ));
                    }
                }

                echo json_encode(array('success' => 1));

            } else {

                echo json_encode(array('success' => 0, 'responseBitrix' => $el->LAST_ERROR), JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode(array('success' => 0, 'responseBitrix' => 'Вы не выбрали раздел'), JSON_UNESCAPED_UNICODE);
        }
        $mainPhoto = 0;

        $i = 1;
        foreach ($_POST['img'] as $item) {
            $FILENAME = rand();

            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $item[0]));

            file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', $data);

            $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');
            if ($item[5] > 0) {
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
    // Редактирование элемента
    } else {

        foreach ($arLoadProductArray as $key => $value) {
            if ($value == '') unset($arLoadProductArray[$key]);
        }

        $arLoadProductProp = [];
        foreach ($arLoadProductArray['PROPERTY_VALUES'] as $key => $value) {
            $arLoadProductProp[$key] = $value;
        }

        $arLoadProductArray['PROPERTY_VALUES']['UF_PHONE_1'] = $_POST['itemPhone1']['val'];
        $arLoadProductArray['PROPERTY_VALUES']['UF_PHONE_2'] = $_POST['itemPhone2']['val'];
        $arLoadProductArray['PROPERTY_VALUES']['UF_PHONE_3'] = $_POST['itemPhone3']['val'];
        unset($arLoadProductArray['PROPERTY_VALUES']);

        if ($res = $el->Update(intval($_REQUEST['EDIT_ID']), $arLoadProductArray)) {

            unset($arLoadProductArray);
            foreach ($arLoadProductProp as $key => $value) {
                CIBlockElement::SetPropertyValuesEx($_REQUEST['EDIT_ID'], SIMPLE_ADS_IBLOCK_ID, array($key => $value));
            }

            foreach ($_REQUEST as $value) {
                if ($value['val'] == 'true') $multiselect[$value['data']['id_prop']][] = $value['data']['idSelf'];
            }

            $arLoadProductProp['UF_REGION'] = $_POST['region'];
            $arLoadProductProp['UF_CITY'] = $_POST['city'];
            foreach ($multiselect as $key => $value) {
                if (!is_string($key) && !empty($key)) CIBlockElement::SetPropertyValueCode($_REQUEST['EDIT_ID'], $key, $value);
            }
            echo $el->LAST_ERROR;
            $dbElements = \CIBlockElement::GetList([], ["ACTIVE" => "Y", "IBLOCK_ID" => 1, "ID" => intval($_REQUEST['EDIT_ID']),], false, false, ['IBLOCK_ID', 'ID', 'PROPERTY_PHOTOS',]);
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
                        $siteDomain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];
                        RotateJpg($item[0], $rotate, $_SERVER["DOCUMENT_ROOT"] . str_replace($siteDomain, '', $item[0]), $arFile['type']);
                        unlink($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');
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

                    $FILENAME = rand();
                    file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', file_get_contents($img[0]));
                    $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');
                    preg_match('/^data:(\w*)\/(\w*);/', $img[0], $matches);
                    $rotate = (int)$img[5] * 90 * 3;

                    RotateJpg($img[0], $rotate, $_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', $arFile['type'], $matches);
                    $arFile["MODULE_ID"] = "iblock";

                    if ($img[4] == 'isActive') {
                        $arLoadProductArray['PREVIEW_PICTURE'] = $arFile;
                        $el->Update(intval($_REQUEST['EDIT_ID']), $arLoadProductArray);
                        $mainPhotoCount++;
                        $dbElements = \CIBlockElement::GetList([], ["ACTIVE" => "Y", "IBLOCK_ID" => 1, "ID" => intval($_REQUEST['EDIT_ID']),], false, false, ['IBLOCK_ID', 'ID', 'PROPERTY_PHOTOS',]);
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
                    unlink($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');
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
        } else {
            echo json_encode(array('success' => 0, 'responseBitrix' => $el->LAST_ERROR), JSON_UNESCAPED_UNICODE);
        }
    }
} else {
    echo json_encode(array('success' => 0, 'responseBitrix' => 'У вас закончились объявления!'), JSON_UNESCAPED_UNICODE);
}


<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('highloadblock');
$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$arUser = CUser::GetByID($userId)->Fetch();
$canUserCreateAds = canUserCreateAds(AUTO_IBLOCK_ID,AUTO_ADS_TYPE_CODE);

if ($canUserCreateAds || $_REQUEST['EDIT'] == 'Y') {

    $isFreeAdd = false;
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
        if (is_string($arItem) == false && $arItem['val'] != 'on') {
            $PROP[$arItem["data"]["id_prop"]] = $arItem["val"];
        }
    }
    foreach ($checkedVaue as $arItem) {
        $PROP[$arItem["data"]["id_prop"]] = $arItem["data"]["idSelf"];
    }


    $FILENAME = $userId;

    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST["img-base64"]));

    file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/imgbs64.png', $data);

    $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/imgbs64.png");
    if ($_REQUEST['anytime'] == 'true') {
        $PROP['UF_CALL_ANYTIME'] = 1;
    } else {
        $PROP['UF_CALL_TO'] = $_REQUEST['$data2']['callTo'][1] . ':00';
        $PROP['UF_CALL_FROM'] = $_REQUEST['$data2']['callFrom'][1] . ':00';
    }

    $PROP['TIME_RAISE'] = date("d.m.Y H:i:s");
    $PROP[51] = $_POST['userItemPrice']['val'];
    $PROP[117] = date("d.m.Y H:i:s");
    $PROP[120] = $_POST['Modification']['val'];
    $PROP[131] = $_POST['phone1']['val'];
    $PROP['UF_REGION'] = $_POST['region'];
    $PROP['UF_CITY'] = $_POST['city'];
    $SECTION_ID = $PROP['PROP_BRAND'];
    if (isset($PROP['PROP_MODEL'])) {
        $SECTION_ID = $PROP['PROP_MODEL'];
    }
    $PROP[132] = $_POST['phone2']['val'];
    $PROP[133] = $_POST['phone3']['val'];
    $PROP[134] = $_POST['Legalname']['val'];
    $PROP['LOCATION'] = $_POST['LOCATION'];
    $res = CIBlockSection::GetByID($PROP['PROP_BRAND']);
    if ($ar_res = $res->GetNext())
        $PROP['PROP_BRAND'] = $ar_res['NAME'];
    $res = CIBlockSection::GetByID($PROP['PROP_MODEL']);
    if ($ar_res = $res->GetNext())
        $PROP['PROP_MODEL'] = $ar_res['NAME'];
    $NAME = $PROP['PROP_BRAND'] . ' ' . $PROP['PROP_MODEL'] . ' ' . $_POST['Modification']['val'] . ' ' . $PROP['PROP_YAERH_Left'];
    $PROP['ID_USER'] = $userId;

    $arParams = array("replace_space" => "-", "replace_other" => "-");
    $translit = Cutil::translit($NAME, "ru", $arParams) . $userId . randString(10);;
    foreach ($_POST['$data2'] as $data){
        if ($data[0] != '') {
            $PROP[$data[0]] = $data[1];
        }
    }

    if ($_REQUEST['EDIT'] != 'Y') {
        $arLoadProductArray = array(
            'MODIFIED_BY' => $GLOBALS['USER']->GetID(),
            'IBLOCK_ID' => AUTO_IBLOCK_ID,
            'IBLOCK_SECTION_ID' => $SECTION_ID,
            'CODE' => $translit,
            'PROPERTY_VALUES' => $PROP,
            'NAME' => $NAME,
            'ACTIVE' => 'Y',
            'PREVIEW_TEXT' => trim($_POST['itemDescription']),
            'DETAIL_TEXT' => trim($_POST['itemDescription']),
        );

        // Получаем всю инфу о самом первом активном купленном пакете
        $optimalUserRate = getOptimalActiveUserRate(AUTO_ADS_TYPE_CODE);
        // Если пользователь еще не создавал объявления то первое объявление будет бесплатным
        if (isExistActiveFreeAd(AUTO_ADS_TYPE_CODE) === false) {
            removeFreeAdPropOnAds(AUTO_ADS_TYPE_CODE);
            $isFreeAdd = true;
            $arLoadProductArray['PROPERTY_VALUES']['FREE_AD'] = getPropertyFreeAdValueId(AUTO_IBLOCK_ID);
            $unixTime = strtotime('+ '.DAYS_EXPIRED_FREE_ADS.' days');
            $arLoadProductArray['DATE_ACTIVE_TO'] = \Bitrix\Main\Type\DateTime::createFromTimestamp($unixTime);
        } else {
            $arLoadProductArray['DATE_ACTIVE_TO'] = $optimalUserRate['UF_DATE_EXPIRED'];
        }
    } else {
        $arLoadProductArray = array(
            'MODIFIED_BY' => $GLOBALS['USER']->GetID(),
            'IBLOCK_ID' => AUTO_IBLOCK_ID,
            'IBLOCK_SECTION_ID' => $SECTION_ID,
            'CODE' => $translit,
            'PROPERTY_VALUES' => $PROP,
            'NAME' => $NAME,
            'PREVIEW_TEXT' => trim($_POST['itemDescription']),
            'DETAIL_TEXT' => trim($_POST['itemDescription']),
        );
    }

    if ($arFile["type"] !== "image/png" || $arFile["type"] !== "image/jpeg") unset($arLoadProductArray['PREVIEW_PICTURE']);

    if ($_REQUEST['EDIT'] != 'Y') {

        if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
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

            // Увеличение счетчика объявлений
            $user = new \CUser;
            $arUser['UF_COUNT_ITEM_AUTO'][] = $PRODUCT_ID;
            $fields = array(
                'UF_COUNT_AUTO' => ++$arUser['UF_COUNT_AUTO'],
                'UF_COUNT_ITEM_AUTO' => $arUser['UF_COUNT_ITEM_AUTO']
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

            $mainPhoto = 0;
            $i = 1;
            foreach ($_POST['img'] as $item) {
                $FILENAME = rand();

                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $item[0]));

                file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', $data);

                $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png');
                if ($item[5] > 0) {
                    $rotate = (int)$item[5] * 90 * 3;
                    if ($rotate > 0){
                        RotateJpg($item[0], $rotate, $_SERVER["DOCUMENT_ROOT"] . '/' . $FILENAME . '.png', $arFile['type']);

                    }
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
                unlink($_SERVER['DOCUMENT_ROOT'].'/' . $FILENAME . '.png');
                $i++;
            }
        } else {

            echo json_encode(array('success' => 0, 'responseBitrix' => $el->LAST_ERROR), JSON_UNESCAPED_UNICODE);
        }

    // Редактирование элемента
    } else {
        if ($PROP['PROP_BRAND'] == null || $PROP['PROP_MODEL'] == null || $PROP['Modification']['val'] == null) {
            unset($arLoadProductArray['NAME']);
        }

        foreach ($arLoadProductArray as $key => $value) {
            if ($value == '') {
                unset($arLoadProductArray[$key]);
            }

        }
        $arLoadProductProp = [];
        $arLoadProductProp['PROP_BODY_TYPE'] =  $PROP['PROP_BODY_TYPE'];
        foreach ($arLoadProductArray['PROPERTY_VALUES'] as $key => $value) {
            if ($value == '') {
                unset($arLoadProductArray['PROPERTY_VALUES'][$key]);
            } else {
                $arLoadProductProp[$key] = $value;
            }

        }
        unset($arLoadProductArray['PROPERTY_VALUES']);
        if ($res = $el->Update(intval($_REQUEST['EDIT_ID']), $arLoadProductArray)) {

            foreach ($_REQUEST as $value) {
                if ($value['val'] == 'true') {
                    $multiselect[$value['data']['id_prop']][] = $value['data']['idSelf'];
                }
            }
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

            if (!empty($_POST['dateSelectSelector']) && $_POST['dateSelectSelector'] !== 'no-value') {
                CIBlockElement::SetPropertyValueCode($_REQUEST['EDIT_ID'], 'PROP_YAERH_Left', $_POST['dateSelectSelector']);
            }


            $dbElements = \CIBlockElement::GetList([], ["ACTIVE" => "Y", "IBLOCK_ID" => 3, "ID" => intval($_REQUEST['EDIT_ID']),], false, false, ['IBLOCK_ID', 'ID', 'PROPERTY_PHOTOS',]);
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
                            $siteDomain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];
                            RotateJpg($item[0], $rotate, $_SERVER["DOCUMENT_ROOT"] . str_replace($siteDomain, '', $item[0]), $arFile['type']);
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
                        $dbElements = \CIBlockElement::GetList([], ["ACTIVE" => "Y", "IBLOCK_ID" => 3, "ID" => intval($_REQUEST['EDIT_ID']),], false, false, ['IBLOCK_ID', 'ID', 'PROPERTY_PHOTOS',]);
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

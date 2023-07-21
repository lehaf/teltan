<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Добавить объявление");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
global $arSetting;

CModule::IncludeModule("iblock");
$IBLOCK_ID = 1;
$properties = CIBlockProperty::GetList(array("sort" => "asc", "name" => "asc"), array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID));
while ($prop_fields[] = $properties->GetNext()) {
}
$arProp = [];

$rsSections = CIBlockSection::GetList(
    array(),
    array(
        "IBLOCK_ID" => $IBLOCK_ID,
        "ID" => $_GET['ids']
    ),
    false,
    array("ID", "DEPTH_LEVEL", "SECTION_PAGE_URL", "UF_*")
);
while ($arSection = $rsSections->Fetch())
    $listProps = $arSection['UF_PROPS_LIST'];


foreach ($prop_fields as $field) {
    if (!in_array($field['CODE'], $listProps)) {
        continue;
    }
    $needle = 'ROP';
    $pos = strripos($field['CODE'], $needle);
    if ($pos == 1) {
        if ($field['PROPERTY_TYPE'] == 'L') {
            $db_enum_list = CIBlockProperty::GetPropertyEnum($field['ID'], array("sort" => "asc"), array("IBLOCK_ID" => 1, 'PROPERTY_ID' => $field['ID']));
            while ($ar_enum_list[] = $db_enum_list->GetNext()) {
                $field['PROP_ENUM_VAL'] = $ar_enum_list;
            }
        }
        $ar_enum_list = [];
        $arProp[] = $field;
    }
    if ($field['USER_TYPE_SETTINGS']['TABLE_NAME'] == 'b_hlbd_tsveta') {
        $entity_data_class = GetEntityDataClass(13);
        $rsData = $entity_data_class::getList(array(
            'order' => array('UF_NAME' => 'ASC'),
            'select' => array('*'),
            'filter' => array('!UF_NAME' => false)
        ));
        while ($elCol[] = $rsData->fetch()) {
        }
        if ($elCol) {
            unset($field['PROPERTY_TYPE']);
            $field['COLOUR'] = $elCol;
            $arProp[] = $field;

        }
    }
}
$userPhone = getUserInfoByID()['PERSONAL_PHONE'];
if (!$userPhone)
    LocalRedirect($GLOBALS['arSetting'][SITE_ID]['href'] . 'personal/edit/');

if ($_GET['EDIT'] == 'Y' && $_GET['ID']) {
    $arSelect = array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_*", "PREVIEW_TEXT", "PREVIEW_PICTURE");
    $arFilter = array("IBLOCK_ID" => 1, 'ID' => $_GET['ID'], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        // pr($arFields);
        $arProps = $ob->GetProperties();
        // pr($arProps);
    }
}
$arLink = CIBlockSectionPropertyLink::GetArray($IBLOCK_ID, $_GET['ids']);

ps($arProp);
?>

    <div class="container">
        <div class="preloader">
            <div class="preloader__row">
                <div class="preloader__item"></div>
                <div class="preloader__item"></div>
            </div>
        </div>
        <h2 class="d-block mb-4 subtitle">
            <?= Loc::getMessage('submit your ad'); ?>
            <div id="subtitleprepend"></div>
        </h2>

        <div class="p-4 card user-add-item">
            <form id="mainForm" onsubmit="submitForm(event)">
                <h2 class="mb-4 d-flex justify-content-center align-items-center section-title"> <?= Loc::getMessage('Description'); ?></h2>

                <? $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "sections_menu_add",
                    array(
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "N",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COUNT_ELEMENTS" => "N",
                        "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                        "FILTER_NAME" => "sectionsFilter",
                        "IBLOCK_ID" => "1",
                        "IBLOCK_TYPE" => "announcements",
                        "SECTION_CODE" => "",
                        "SECTION_FIELDS" => array("UF_NAME_EN", "UF_NAME_HEB", "UF_ICON", "UF_SVG_ICON_URL"),
                        "SECTION_ID" => $_REQUEST["SECTION_ID"],
                        "SECTION_URL" => "",
                        "SECTION_USER_FIELDS" => array("", ""),
                        "SHOW_PARENT_NAME" => "Y",
                        "TOP_DEPTH" => "2",
                        "VIEW_MODE" => "LINE"
                    )
                ); ?>


                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10">
                        <input type="text" value="<?= $arFields['NAME'] ?>" class="form-control"
                               placeholder="Enter Title" id="itemTitle" data-req="Y">
                    </div>
                    <label for="itemTitle" class="col col-lg-2 label-name"> כותרת *</label>
                </div>
                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10">
                        <textarea data-req="Y" type="text" placeholder="Enter Description" class="form-control"
                                  id="itemDescription"
                                  rows="4"><?= $arFields['PREVIEW_TEXT'] ?></textarea>
                    </div>
                    <label for="itemDescription"
                           class="col col-lg-2 label-name"><?= Loc::getMessage('Description'); ?> *</label>
                </div>
                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10">
                        <input data-req="Y" value="<?= $arProps['PRICE']['VALUE'] ?>" type="text"
                               placeholder="Enter Price"
                               class="form-control" id="itemPrice">
                    </div>
                    <label for="itemPrice" class="col col-lg-2 label-name"><?= Loc::getMessage('Price'); ?> *</label>
                </div>
                <? require_once 'city.php' ?>

                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10">
                        <input type="text" value="<?= $arProps['UF_PHONE_1']['VALUE'] ?>" class="form-control"
                               placeholder="<?= Loc::getMessage('Enter your phone number in international format'); ?>"
                               id="itemPhone1" data-req="Y">
                    </div>
                    <label for="itemPhone1" class="col col-lg-2 label-name">טלפון 1 *</label>
                </div>
                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10">
                        <input type="text" value="<?= $arProps['UF_PHONE_2']['VALUE'] ?>" class="form-control"
                               placeholder="<?= Loc::getMessage('Enter your phone number in international format'); ?>"
                               id="itemPhone2">
                    </div>
                    <label for="itemPhone2" class="col col-lg-2 label-name">טלפון 2</label>
                </div>
                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10">
                        <input type="text" value="<?= $arProps['UF_PHONE_3']['VALUE'] ?>" class="form-control"
                               placeholder="<?= Loc::getMessage('Enter your phone number in international format'); ?>"
                               id="itemPhone3">
                    </div>
                    <label for="itemPhone3" class="col col-lg-2 label-name">טלפון 3</label>
                </div>

                <div class="mb-2 row flex-column-reverse flex-lg-row property-step-contact__time">
                    <div class="d-lg-flex col-3 btn-time">
                        <div style="max-width: none" class="form_radio_btn">
                            <input <?= ($arProps['UF_CALL_ANYTIME']['VALUE'] == '1') ? 'checked' : '' ?> id="anytime"
                                                                                                         type="checkbox"
                                                                                                         name="anytime"
                                                                                                         value="anytime">
                            <label class="mr-3 mb-0" for="anytime"><?= Loc::getMessage('Anytime'); ?></label>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 ">
                        <div class="row row-select-time">
                            <div class="col">
                                <select id="callTo" class="selectpicker"
                                        data-style-base="form-control form-control-select" data-style="">
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '00:00') ? 'selected' : '' ?>
                                            value="00"><?= Loc::getMessage('to'); ?> <span>00:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '01:00') ? 'selected' : '' ?>
                                            value="01"><?= Loc::getMessage('to'); ?> <span>01:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '02:00') ? 'selected' : '' ?>
                                            value="02"><?= Loc::getMessage('to'); ?> <span>02:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '03:00') ? 'selected' : '' ?>
                                            value="03"><?= Loc::getMessage('to'); ?> <span>03:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '04:00') ? 'selected' : '' ?>
                                            value="04"><?= Loc::getMessage('to'); ?> <span>04:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '05:00') ? 'selected' : '' ?>
                                            value="05"><?= Loc::getMessage('to'); ?> <span>05:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '06:00') ? 'selected' : '' ?>
                                            value="06"><?= Loc::getMessage('to'); ?> <span>06:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '07:00') ? 'selected' : '' ?>
                                            value="07"><?= Loc::getMessage('to'); ?> <span>07:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '08:00') ? 'selected' : '' ?>
                                            value="08"><?= Loc::getMessage('to'); ?> <span>08:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '09:00') ? 'selected' : '' ?>
                                            value="09"><?= Loc::getMessage('to'); ?> <span>09:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '10:00') ? 'selected' : '' ?>
                                            value="10"><?= Loc::getMessage('to'); ?> <span>10:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '11:00') ? 'selected' : '' ?>
                                            value="11"><?= Loc::getMessage('to'); ?> <span>11:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '12:00') ? 'selected' : '' ?>
                                            value="12"><?= Loc::getMessage('to'); ?> <span>12:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '13:00') ? 'selected' : '' ?>
                                            value="13"><?= Loc::getMessage('to'); ?> <span>13:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '14:00') ? 'selected' : '' ?>
                                            value="14"><?= Loc::getMessage('to'); ?> <span>14:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '15:00') ? 'selected' : '' ?>
                                            value="15"><?= Loc::getMessage('to'); ?> <span>15:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '16:00') ? 'selected' : '' ?>
                                            value="16"><?= Loc::getMessage('to'); ?> <span>16:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '17:00') ? 'selected' : '' ?>
                                            value="17"><?= Loc::getMessage('to'); ?> <span>17:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '18:00') ? 'selected' : '' ?>
                                            value="18"><?= Loc::getMessage('to'); ?> <span>18:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '19:00') ? 'selected' : '' ?>
                                            value="19"><?= Loc::getMessage('to'); ?> <span>19:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '20:00') ? 'selected' : '' ?>
                                            value="20"><?= Loc::getMessage('to'); ?> <span>20:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '21:00') ? 'selected' : '' ?>
                                            value="21"><?= Loc::getMessage('to'); ?> <span>21:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '22:00') ? 'selected' : '' ?>
                                            value="22"><?= Loc::getMessage('to'); ?> <span>22:00</span></option>
                                    <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '23:00') ? 'selected' : '' ?>
                                            value="23"><?= Loc::getMessage('to'); ?> <span>23:00</span></option>
                                </select>
                            </div>
                            <div class="col">
                                <select id="callFrom" class="selectpicker"
                                        data-style-base="form-control form-control-select" data-style="">
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '00:00') ? 'selected' : '' ?>
                                            value="00"><?= Loc::getMessage('from'); ?> <span>00:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '01:00') ? 'selected' : '' ?>
                                            value="01"><?= Loc::getMessage('from'); ?> <span>01:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '02:00') ? 'selected' : '' ?>
                                            value="02"><?= Loc::getMessage('from'); ?> <span>02:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '03:00') ? 'selected' : '' ?>
                                            value="03"><?= Loc::getMessage('from'); ?> <span>03:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '04:00') ? 'selected' : '' ?>
                                            value="04"><?= Loc::getMessage('from'); ?> <span>04:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '05:00') ? 'selected' : '' ?>
                                            value="05"><?= Loc::getMessage('from'); ?> <span>05:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '06:00') ? 'selected' : '' ?>
                                            value="06"><?= Loc::getMessage('from'); ?> <span>06:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '07:00') ? 'selected' : '' ?>
                                            value="07"><?= Loc::getMessage('from'); ?> <span>07:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '08:00') ? 'selected' : '' ?>
                                            value="08"><?= Loc::getMessage('from'); ?> <span>08:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '09:00') ? 'selected' : '' ?>
                                            value="09"><?= Loc::getMessage('from'); ?> <span>09:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '10:00') ? 'selected' : '' ?>
                                            value="10"><?= Loc::getMessage('from'); ?> <span>10:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '11:00') ? 'selected' : '' ?>
                                            value="11"><?= Loc::getMessage('from'); ?> <span>11:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '12:00') ? 'selected' : '' ?>
                                            value="12"><?= Loc::getMessage('from'); ?> <span>12:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '13:00') ? 'selected' : '' ?>
                                            value="13"><?= Loc::getMessage('from'); ?> <span>13:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '14:00') ? 'selected' : '' ?>
                                            value="14"><?= Loc::getMessage('from'); ?> <span>14:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '15:00') ? 'selected' : '' ?>
                                            value="15"><?= Loc::getMessage('from'); ?> <span>15:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '16:00') ? 'selected' : '' ?>
                                            value="16"><?= Loc::getMessage('from'); ?> <span>16:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '17:00') ? 'selected' : '' ?>
                                            value="17"><?= Loc::getMessage('from'); ?> <span>17:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '18:00') ? 'selected' : '' ?>
                                            value="18"><?= Loc::getMessage('from'); ?> <span>18:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '19:00') ? 'selected' : '' ?>
                                            value="19"><?= Loc::getMessage('from'); ?> <span>19:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '20:00') ? 'selected' : '' ?>
                                            value="20"><?= Loc::getMessage('from'); ?> <span>20:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '21:00') ? 'selected' : '' ?>
                                            value="21"><?= Loc::getMessage('from'); ?> <span>21:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '22:00') ? 'selected' : '' ?>
                                            value="22"><?= Loc::getMessage('from'); ?> <span>22:00</span></option>
                                    <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '23:00') ? 'selected' : '' ?>
                                            value="23"><?= Loc::getMessage('from'); ?> <span>23:00</span></option>
                                </select>
                            </div>


                        </div>
                    </div>

                    <div class="col-12 col-lg-2 d-flex justify-content-end align-items-center">
                        <p class="text-right mb-3 mb-lg-0 font-weight-bold"><?= Loc::getMessage('Call:'); ?></p>
                    </div>
                </div>


                <? if ($arProp) { ?>

                    <h2 class="mb-4 d-flex justify-content-center align-items-center section-title"><?= Loc::getMessage('DETAILED DESCRIPTION'); ?></h2>
                <? } ?>
                <?

                foreach ($arProp as $prop) { ?>
                    <?
                    $pattern = '/ID(\d+)/';
                    preg_match_all($pattern, $prop['CODE'], $matches);
                     $id = $matches[1];
                                        $id = array_reverse($id);
                    ?>
                    <? if ($prop['PROPERTY_TYPE'] == 'N' || $prop['PROPERTY_TYPE'] == 'S' && $prop['MULTIPLE'] == 'N') {
                        if ($prop['USER_TYPE_SETTINGS']['TABLE_NAME'] != "b_hlbd_tsveta") {
                            ?>
                            <div class="mb-4 row flex-column-reverse flex-lg-row">
                                <div class="col col-lg-10">
                                    <div class="d-flex justify-content-end">
                                        <?if ($id){foreach ($id as $ids){drawElement($arProp[$ids] , $arLink ,$arProps);}}?>

                                        <div class="d-flex form-group">
                                            <input id="<?= $prop['CODE'] ?>" data-id_prop="<?= $prop['ID'] ?>"
                                                   class="ml-2 form-control" type="text"
                                                   placeholder="type here ..."
                                                   data-req="<?= $prop['IS_REQUIRED'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-2 d-lg-block">
                                    <p class="m-0 mb-2 mb-lg-0 font-weight-bold label-name"><?= $prop['NAME'] ?> <?= ($prop['IS_REQUIRED'] == 'Y') ? ' * ' : '' ?></p>
                                </div>
                            </div>
                        <? }
                    }
                    if ($prop['PROPERTY_TYPE'] == 'L') {
                        if ($arLink[$prop['ID']]['DISPLAY_TYPE'] == 'P') {
                            ?>
                            <div class="mb-4 row flex-column-reverse flex-lg-row">
                                <div class="col col-lg-10">
                                    <div class="d-flex justify-content-end">
                                        <?if ($id){drawElement($arProp[$id] , $arLink ,$arProps);}?>

                                        <div class="dropdown bootstrap-select"><select class="selectpicker"
                                                                                       data-style-base="form-control form-control-select"
                                                                                       data-code_prop="<?= $prop['CODE'] ?>"
                                                                                       data-id_prop="<?= $prop['ID'] ?>"
                                                                                       data-style=""
                                                                                       data-req="<?= $prop['IS_REQUIRED'] ?>"
                                                                                       name="<?= $prop['ID'] ?>"
                                                                                       id="<?= $prop['ID'] ?>"
                                                                                       tabindex="-98">
                                                <? foreach ($prop['PROP_ENUM_VAL'] as $enumProp) { ?>
                                                    <option value="<?= $enumProp['ID'] ?>"><?= $enumProp['VALUE'] ?></option>
                                                <? } ?>
                                            </select>

                                            <div class="dropdown-menu ">
                                                <div class="inner show" role="listbox" id="bs-select-22" tabindex="-1">
                                                    <ul class="dropdown-menu inner show" role="presentation">

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 d-lg-block">
                                    <p class="m-0 mb-2 mb-lg-0 font-weight-bold label-name"><?= $prop['NAME'] ?> <?= ($prop['IS_REQUIRED'] == 'Y') ? ' * ' : '' ?></p>
                                </div>
                            </div>


                            <?


                        } else {
                            ?>
                            <div class="mb-4 row flex-column-reverse flex-lg-row">
                                <div class="col col-lg-10">
                                    <div class="d-flex flex-wrap justify-content-end <?= ($prop['IS_REQUIRED'] == 'Y') ? 'div-req' : '' ?>">
                                        <?if ($id){drawElement($arProp[$id] , $arLink ,$arProps);}?>

                                        <? foreach ($prop['PROP_ENUM_VAL'] as $enumProp) { ?>
                                            <div class="form_radio_btn">
                                                <input id="<?= 'PROPERTY_ID' . $enumProp['PROPERTY_ID'] . $enumProp['VALUE'] ?>"
                                                    <? if ($prop['MULTIPLE'] == 'N') { ?>
                                                        type="radio"
                                                    <? } else { ?>
                                                        type="checkbox"
                                                    <? } ?>
                                                       name="<?= $enumProp['PROPERTY_ID'] ?>"
                                                       data-id_prop="<?= $enumProp['PROPERTY_ID'] ?>"
                                                       data-id-self="<?= $enumProp['ID'] ?>"
                                                       data-code_prop="<?= $prop['CODE'] ?>"
                                                >

                                                <label style="max-width: none" class="mileage-btn line-height"
                                                       for="<?= 'PROPERTY_ID' . $enumProp['PROPERTY_ID'] . $enumProp['VALUE'] ?>"><?= $enumProp['VALUE'] ?></label>
                                            </div>
                                        <? } ?>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2  d-lg-block">
                                    <p class="m-0 mb-2 mb-lg-0 font-weight-bold label-name"><?= $prop['NAME'] ?>
                                        : <?= ($prop['IS_REQUIRED'] == 'Y') ? ' * ' : '' ?></p>
                                </div>
                            </div>
                        <? }
                    }
                    if ($prop['COLOUR']) {
                        ?>
                        <div class="mb-4 row flex-column-reverse flex-lg-row">
                            <div class="col col-lg-10">
                                <div class="d-lg-flex auto-ad-step3__colors <?= ($prop['IS_REQUIRED'] == 'Y') ? 'div-req' : '' ?>"
                                     style="display: flex;justify-content: end !important;">
                                    <? foreach ($prop['COLOUR'] as $color) {
                                        if ($color['UF_XML_ID'] != null) {
                                            ?>
                                            <input <?= ($arProps['PROP_COLOR']['VALUE'] == $color['UF_XML_ID']) ? 'checked=""' : '' ?>
                                                    type="radio" data-id_prop="PROP_COLOR"
                                                    data-id-self="<?= $color['UF_XML_ID'] ?>" class="d-none"
                                                    name="color" id="<?= $color['UF_NAME'] ?>">
                                            <label class="colour-element" for="<?= $color['UF_NAME'] ?>"
                                                   style="background: #<?= $color['UF_XML_ID'] ?>;"></label>
                                        <? }
                                    } ?>
                                </div>
                            </div>

                            <div class="col-12 col-lg-2 d-lg-block">
                                <p class="m-0 mb-2 mb-lg-0 font-weight-bold label-name"><?= $prop['NAME'] ?>
                                    : <?= ($prop['IS_REQUIRED'] == 'Y') ? ' * ' : '' ?></p>
                            </div>
                        </div>
                        <?
                    }
                }
                unset($id);
                ?>

                <h2 class="mb-4 d-flex justify-content-center align-items-center section-title"><?= Loc::getMessage('Product Photos'); ?></h2>

                <div class="mb-5 row">
                    <div class="col">
                        <div class="step-photos">
                            <div id="fileUploaderRenderContainer"
                                 class="mb-3 mb-lg-5 row row-cols-2 row-cols-lg-4 row-cols-xl-5 flex-row-reverse">
                                <? if ($arFields['PREVIEW_PICTURE']) { ?>
                                    <div class="mb-4 col main-photo__item"
                                         data-file-id="<?= $arFields['PREVIEW_PICTURE'] ?>Снимок.PNG">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <div class="mb-3 d-flex justify-content-center align-items-center photo">
                                                <img src="<?= CFile::GetPath($arFields['PREVIEW_PICTURE']) ?>?cache=<?= rand() ?>"
                                                     data-activephoto="isActive" data-rotate="0" data-main="Y"
                                                     data-file-id="<?= $arFields['PREVIEW_PICTURE'] ?>"
                                                     class="rotate-img">
                                            </div>

                                            <label id="main-selector-photo"
                                                   class="mb-2 p-0 btn text-center text-primary main-selector-photo">
                                                <input type="radio" name="fileMain" value="Снимок.PNG"
                                                       class="d-none main-selector-photo">
                                                <div onclick="addActivePhoto(this)" id="213213" class="set-main-text">
                                                    <?=Loc::getMessage('photoMain')?>
                                                </div>
                                            </label>

                                            <div class="d-flex justify-content-around">
                                                <div class="mr-3 d-flex justify-content-center align-items-center element-control"
                                                     data-file-remove-id="<?= $arFields['PREVIEW_PICTURE'] ?>Снимок.PNG">
                                                    <i class="mr-2 icon-clear"></i>
                                                    <span class="d-none d-lg-inline-block"><?=Loc::getMessage('deletePhoto')?></span>
                                                </div>

                                                <div class="d-flex justify-content-center align-items-center element-control rotate-control">
                                                    <input type="hidden"
                                                           name="rotate[<?= $arFields['PREVIEW_PICTURE'] ?>Снимок.PNG]"
                                                           value="0">
                                                    <i onclick="rotateThis(this)" class="mr-2 icon-replay"></i>
                                                    <span onclick="rotateThis(this)" class="d-none d-lg-inline-block"><?=Loc::getMessage('rotatePhoto')?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                                <? if ($arProps['PHOTOS']['VALUE']) { ?>
                                    <? foreach ($arProps['PHOTOS']['VALUE'] as $PHOTO) { ?>
                                        <div class="mb-4 col main-photo__item" data-file-id="<?= $PHOTO ?>.PNG">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <div class="mb-3 d-flex justify-content-center align-items-center photo">
                                                    <img src="<?= CFile::GetPath($PHOTO) ?>?cache=<?= rand() ?>"
                                                         data-rotate="0" data-id="<?= $PHOTO ?>" class="rotate-img">
                                                </div>

                                                <label id="main-selector-photo"
                                                       class="mb-2 p-0 btn text-center text-primary main-selector-photo">
                                                    <input type="radio" name="fileMain" value="<?= $PHOTO ?>.PNG"
                                                           class="d-none main-selector-photo">
                                                    <div onclick="addActivePhoto(this)" id="<?= $PHOTO ?>"
                                                         class="set-main-text"><?=Loc::getMessage('setPhotoMain')?>
                                                    </div>
                                                </label>

                                                <div class="d-flex justify-content-around">
                                                    <div class="mr-3 d-flex justify-content-center align-items-center element-control"
                                                         data-file-remove-id="<?= $PHOTO ?>.PNG">
                                                        <i class="mr-2 icon-clear"></i>
                                                        <span class="d-none d-lg-inline-block"><?=Loc::getMessage('deletePhoto')?></span>
                                                    </div>

                                                    <div class="d-flex justify-content-center align-items-center element-control rotate-control">
                                                        <input type="hidden" name="rotate[<?= $PHOTO ?>.PNG]" value="0">
                                                        <i onclick="rotateThis(this)" class="mr-2 icon-replay"></i>
                                                        <span onclick="rotateThis(this)"
                                                              class="d-none d-lg-inline-block"><?=Loc::getMessage('rotatePhoto')?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                                <? } ?>
                                <input id="fileUploaderFiles" class="d-none" type="file" name="files[]" multiple>

                                <div class="col">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <label for="fileUploaderFiles" class="mb-0 label-add-photo">
                                            <p class="mb-2"><i class="icon-camera-1"></i></p>
                                            <p class="mb-0 label-add-photo__text "><?= Loc::getMessage('Add photo'); ?></p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-lg-flex  col-2">
                        <p class="label-name"><?= Loc::getMessage('Add photo'); ?></p>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    <button type="btn" class="btn btn-primary text-uppercase font-weight-bold p-3">
                        <?= Loc::getMessage('Submit your ad'); ?>
                    </button>
                </div>
            </form>

        </div>
    </div>
<?ps($arProps)?>
    <script>

        let flagPhoto = true;
        $(document).ready(function () {
            let props = <?=json_encode($arProps)?>;
            let fields = <?=json_encode($arFields)?>;
            console.log(props);
            console.log(fields);
            <?if(!$_GET['ids'] && $_GET['EDIT']){?>
            window.location.href = document.location.href + `&ids=${fields.IBLOCK_SECTION_ID}`
            <?}?>
            <?if($_GET['EDIT']){?>
            $('#mainForm').find('input').each(function (index) {
                if ($(this).val() === '') {
                    if (props[$(this).attr('id')] !== undefined) {
                        $(this).val(props[$(this).attr('id')]['VALUE'])
                    }
                }
                let id_prop = $(this).data();

                if (id_prop.idSelf !== undefined) {
                    if (props[id_prop.code_prop] !== undefined) {
                        if (id_prop.idSelf == props[id_prop.code_prop]['VALUE_ENUM_ID']) {

                            $(this).prop('checked', true);
                        }
                    }
                }
                if (id_prop.idSelf !== undefined) {
                    if (props[id_prop.code_prop] !== undefined) {
                        if (props[id_prop.code_prop]['VALUE_ENUM_ID'].includes(id_prop.idSelf)) {
                            $(this).prop('checked', true);
                        }
                    }
                }
            })
            <?}?>
        })

        function addActivePhoto(item) {
            if (item !== undefined) {
                let mainText = document.querySelectorAll(".set-main-text");

                mainText.forEach((el) => {
                    el.innerText = "<?=Loc::getMessage('setPhotoMain')?>";
                    el.closest(".main-photo__item").querySelector(".rotate-img").removeAttribute("data-activePhoto");
                })
                item.closest(".main-photo__item").querySelector(".rotate-img").setAttribute("data-activePhoto", "isActive");

                item.innerText = "<?=Loc::getMessage('photoMain')?>";
            }
        }

        function rotateThis(item) {
            let count_rotate = $(item).parents('.main-photo__item').find('img').attr('data-rotate');
            console.log($(item).parents('.main-photo__item').find('img').attr('data-rotate'))
            count_rotate = parseInt(count_rotate) + 1;
            $(item).closest('.main-photo__item').find('img').attr('data-rotate', count_rotate);
        }

        class FileUploader {
            fileList = null

            template = ''

            templateOptions = {
                name: 'name',
            }

            constructor(renderContainerId, fileListId, template) {

                const self = this
                this.renderContainerId = renderContainerId
                this.fileListId = fileListId
                this.template = template

                $(fileListId).on('change', (e) => {
                    this.addFiles(e.target.files)

                    e.target.value = ''
                })

                $(document).on('click', '[data-file-remove-id]', function () {
                    self.removeFile($(this).data('fileRemoveId'));
                })

                $(document).on('click', '.rotate-control', function () {
                    const $rotateInput = $(this).find('input');
                    const currentRotate = Number($rotateInput.val()) || 0;
                    const newRotate = (currentRotate + 90) % 360;

                    $(this).closest('[data-file-id]').find('.rotate-img')
                        .css({'transform': `rotate(${newRotate}deg)`})

                    $rotateInput.val(newRotate)
                })
            }

            readFileAsync = (file) => {
                return new Promise((resolve, reject) => {
                    let reader = new FileReader();


                    reader.onload = () => {
                        resolve(reader.result);
                    };

                    reader.onerror = reject;

                    reader.readAsDataURL(file);
                })
            }

            updateOutputInput = () => {
                const $fileListInput = $(this.fileListId)

                if ($fileListInput && this.fileList) {
                    $fileListInput[0].files = this.fileList;
                }
                addActivePhoto()
            }

            addFiles = (files) => {
                const newFilesArr = Array.from(files)

                const allFiles = [...Array.from(this.fileList || []), ...newFilesArr]

                this.fileList = allFiles.reduce((dt, file) => {
                    dt.items.add(file)

                    return dt;
                }, new DataTransfer()).files;

                newFilesArr.forEach(async (file) => {
                    const dataUrl = await this.readFileAsync(file);
                    console.log(allFiles);
                    let photoList = document.querySelectorAll(".main-selector-photo .set-main-text");
                    photoList.forEach((el) => {
                        let textItem = el.innerText;
                        if (textItem === "<?=Loc::getMessage('photoMain')?>") {
                            return flagPhoto = false
                        }
                    })

                    if (flagPhoto) {
                        setTimeout(function () {
                            let photoItems = document.querySelectorAll(".main-photo__item")
                            let mainPhoto = photoItems[photoItems.length - 1]
                            mainPhoto.querySelector("img").setAttribute("data-activePhoto", "isActive");
                            mainPhoto.querySelector(".set-main-text").innerText = "<?=Loc::getMessage('photoMain')?>"

                            flagPhoto = false
                        }, 0);
                    }


                    const filledTemplate = Object.entries(this.templateOptions).reduce((tmp, [key, value]) => {
                        const output = tmp.replaceAll(`{{${key}}}`, file[value])

                        return output
                    }, this.template.replace('{{dataUrl}}', dataUrl))

                    $('#fileUploaderRenderContainer').prepend(filledTemplate)
                })

                this.updateOutputInput()
            }

            removeFile = (fileId) => {
                const dt = new DataTransfer()
                // const filteredFiles = Array.from(this.fileList).filter((file) => file.name !== fileId)
                // filteredFiles.forEach((file) => dt.items.add(file))

                // this.fileList = dt.files

                // this.updateOutputInput()

                $(`[data-file-id="${fileId}"]`).remove()
            }
        }

        new FileUploader(
            // container where will images rendered (prepend method useing)
            '#fileUploaderRenderContainer',
            // single input file element, all files will be merged there
            '#fileUploaderFiles',
            // render image templte
            // {{example}} - placeholders for templateOptions render (dataUrl at lest required)
            // data-file-id - container
            // data-file-remove-id - data for remove btn (whould has the same as container value)
            // .rotate-control button to rotate image
            // .rotate-img - element for rotating
            `<div class="mb-4 col main-photo__item" data-file-id="{{name}}">
      <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="mb-3 d-flex justify-content-center align-items-center photo">
          <img data-rotate="0" src="{{dataUrl}}" class="rotate-img">
        </div>

        <label id="main-selector-photo" class="mb-2 p-0 btn text-center text-primary main-selector-photo">
          <input type="radio" name="fileMain" value="{{name}}" class="d-none main-selector-photo" />
           <div onclick="addActivePhoto(this)" id="213213" class="set-main-text"><?=Loc::getMessage('setPhotoMain')?></div>
        </label>

        <div class="d-flex justify-content-around">
          <div class="mr-3 d-flex justify-content-center align-items-center element-control" data-file-remove-id="{{name}}">
            <i class="mr-2 icon-clear"></i>
            <span class="d-none d-lg-inline-block"><?=Loc::getMessage('deletePhoto')?></span>
          </div>

          <div class="d-flex justify-content-center align-items-center element-control rotate-control">
            <input  type="hidden" name="rotate[{{name}}]" value="0" />
            <i onclick="rotateThis(this)" class="mr-2 icon-replay"></i>
            <span onclick="rotateThis(this)" class="d-none d-lg-inline-block"><?=Loc::getMessage('rotatePhoto')?></span>
          </div>
        </div>
      </div>
    </div>`,
        )
        <?if(!$_GET['ids'] && !$_GET['EDIT']){?>

        $('#v-pills-tabDescriptionContent').find('li').each(function (index) {
            if (index < 1) {
                let id_section = $(this).children('a').attr('data-id_section');
                window.location.href = `/add/fm/?ids=${id_section}`;
            }
        })
        <?}
        if (empty($_GET['ids'])) {
            $_GET['ids'] = 0;
        }
        ?>
        $('.section_id_a').click(function (e) {
            $('.activeSection').each(function () {
                if (e.target != this) {
                    this.checked = false;
                    $(this).toggleClass('activeSection')
                }

            });
            $(this).toggleClass('activeSection')
            let id_section = $(this).attr('data-id_section');
            window.location.href = `/add/fm/?ids=${id_section}`
        })

        function submitForm(event) {
            let errors = 0;
            let errorsDiv = 0;
            let skip = false;
            event.preventDefault();
            $('#mainForm').find('input').each(function () {
                let inputData = $(this).data()
                let value = $(this).val()

                if (inputData.req === 'Y') {
                    if ($(this).attr('type') == 'radio') {
                    } else {
                        if (value === '') {
                            errors++;
                            $(this).addClass('error');
                            $(this).parent('label').addClass('error');
                        } else {
                            $(this).removeClass('error');
                            $(this).parent('label').removeClass('error');
                        }
                    }
                }

            });
            $('#mainForm').find('select').each(function () {
                let inputData = $(this).data()
                let value = $(this).val()

                if (inputData.req === 'Y') {

                        if (value === '') {
                            errors++;
                            $(this).addClass('error');
                            $(this).parent('div').addClass('error');
                        } else {
                            $(this).removeClass('error');
                            $(this).parent('div').removeClass('error');
                        }

                }

            });
            $('#mainForm').find('textarea').each(function () {
                let inputData = $(this).data()
                let value = $(this).val()

                if (inputData.req === 'Y') {
                    if ($(this).attr('type') == 'radio') {
                    } else {
                        if (value === '') {
                            errors++;
                            $(this).addClass('error');
                            $(this).parent('label').addClass('error');
                        } else {
                            $(this).removeClass('error');
                            $(this).parent('label').removeClass('error');
                        }
                    }
                }

            });
            let thisdiv = 0;
            let checkedData = '';
            $('#mainForm').find('.div-req').each(function () {
                errorsDiv++;
                thisdiv++;
                $(this).find('input').each(function (index) {
                    if ($(this).is(':checked') != false) {
                        errorsDiv--;
                        thisdiv = 0;
                    }
                })
                if (thisdiv > 0) {
                    $(this).find('label').each(function (index) {
                        $(this).addClass('error')
                    })
                } else {
                    $(this).find('label').each(function (index) {
                        $(this).removeClass('error')
                    })
                }
            });
            if (!$('.show-country ').hasClass('selected')) {
                $('.first-drop').addClass('error');
            } else {
                $('.first-drop').removeClass('error');
            }
            console.log(errors)
            console.log(thisdiv)
            if (errors < 1 && errorsDiv < 1) {
                if ($('.show-country ').hasClass('selected')) {
                    var $data = {};
                    $('.preloader').css({"z-index": "1", "opacity": "100", "position": "fixed"});
                    $('#mainForm').find('input').each(function () {
                        let object;
                        if (this.checked) {
                            //alert("checked");
                            object = {};
                            object.val = this.checked;
                            object.data = $(this).data();
                            $data[this.id] = object

                        } else {
                            object = {};
                            object.val = $(this).val();
                            object.data = $(this).data();
                            $data[this.id] = object;
                        }
                    });
                    $('#mainForm').find('select').each(function () {
                        if ($(this).val() != '') {
                            let object = {};
                            object.val = $(this).val();
                            object.data = {id_prop: $(this).attr('data-id_prop')};
                            $data[this.id] = object;
                        }
                    });
                    let a = 0;
                    const $imgobject = {};

                    $('#mainForm').find('.rotate-img').each(function () {
                        var dataMain = $(this).data();
                        if (dataMain.activephoto == 'isActive') {
                            $data['img-base64'] = $(this).prop('src');
                        }
                        $imgobject['img' + a] = [$(this).prop('src'), $(this).attr('data-id'), $(this).attr('data-main'), $(this).attr('data-file-id'), $(this).attr('data-activephoto'), $(this).attr('data-rotate')];
                        a++;
                    });
                    if ($data['img-base64'] == null) {
                        $data['img-base64'] = $('.rotate-img').prop('src');
                    }
                    $data['img'] = $imgobject;

                    <?if($_GET['EDIT'] == 'Y'){?>
                    $data['EDIT'] = 'Y';
                    $data['CALL_FROM'] = $('#callFrom').val();
                    $data['CALL_TO'] = $('#callTo').val();
                    $data['EDIT_ID'] = '<?=$_GET['ID']?>'
                    <?}?>
                    $data['itemDescription'] = $('#itemDescription').val();
                    $data['section_id'] = <?=$_GET['ids']?>;

                    $data['LOCATION'] = $('.first-drop').html() + $('.second-drop').html()
                    $data['region'] = $('.first-drop').html().trim();
                    $data['city'] = $('.second-drop').html().trim();
                    var deferred = $.ajax({
                        type: "POST",
                        url: "/ajax/add_flea.php",
                        data: $data,
                        dataType: 'json'
                    });
                    deferred.done(function (data) {
                        if (data.success == 1) {
                            window.location.href = '/personal/'
                        } else {
                            $('.preloader').css({"z-index": "0", "opacity": "100", "position": "fixed"});
                            $('.pop-up').addClass('active');
                            $('.pop-up__text').html(data.responseBitrix)
                        }
                    });

                } else {
                    $('.first-drop').addClass('error');
                }
            }
        }
    </script>
    <style>
        .activeSection {
            color: #3fb465 !important;
        }
        .dropdown .dropdown-menu a.active {
            color: #3fb465 !important;
        }
        .dropdown-item{
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 8px 15px;
            cursor: pointer;
            margin-bottom: 0.5rem;
            line-height: 1.8;
        }
    </style>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
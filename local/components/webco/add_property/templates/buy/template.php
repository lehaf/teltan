<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/add-page.css");
Loc::loadMessages(__FILE__);

$deletingChairs = [
    "<br />",
    "<br/>",
    "<br>",
    "&lt;br /&gt;",
    "&lt;br/&gt;",
    "&lt;br&gt;",
];

$APPLICATION->SetTitle("Добавить объявление");
global $arSetting;
// Если нет номера телефона, то редиректим на форму с его добавлением
$userPhone = getUserInfoByID()['PERSONAL_PHONE'];
if (!$userPhone) LocalRedirect($GLOBALS['arSetting'][SITE_ID]['href'] . 'personal/edit/');
$IBLOCK_ID = PROPERTY_ADS_IBLOCK_ID;
if ($_GET['EDIT'] == 'Y' && $_GET['ID']) {
    $arSelect = array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_*", "PREVIEW_TEXT", "PREVIEW_PICTURE");
    $arFilter = array("IBLOCK_ID" => $IBLOCK_ID, 'ID' => $_GET['ID']);
    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();
    }
}

$arLink = \CIBlockSectionPropertyLink::GetArray($IBLOCK_ID, 27);
$GLOBALS['MAP_EDIT_RESULT_CORDINATES'] = $arProps['MAP_LATLNG']['~VALUE'];
$GLOBALS['MAP_EDIT_RESULT_POSITION'] = $arProps['MAP_POSITION']['~VALUE'];


CModule::IncludeModule('highloadblock');
$entity_data_class = GetEntityDataClass(PROPERTY_TYPES_HL_ID);
$rentType = $entity_data_class::getList(array(
    'select' => array('*'),
    'cache' => [
        'ttl' => 36000000,
        'cache_joins' => true
    ]
))->fetchAll();

$this->addExternalCss(SITE_TEMPLATE_PATH.'/css/map.css');
?>
<div class="container full-height">
    <h2 class="mb-5 d-flex justify-content-end subtitle">
        submit your ad
    </h2>

    <div class="card">
        <div class="preloader">
            <div class="preloader__row">
                <div class="preloader__item"></div>
                <div class="preloader__item"></div>
            </div>
        </div>
        <div class="propert-sell-main">
            <div id="wizard" data-iblock-id="<?=$IBLOCK_ID?>">
                <div class="d-flex justify-content-between border-bottom propert-sell-main__header">
                    <div class="d-flex step wizard-step" data-wizard-step="4">
                        <div class="pr-2 pr-md-4 d-flex flex-column text-right">
                            <span class="step__title"> <?=Loc::getMessage('Step5');?></span>
                            <span class="step__subtitle"><?=Loc::getMessage('Contacts');?></span>
                        </div>

                        <div class="d-flex justify-content-center align-items-center step__icone">
                            <i class="icon-invitation"></i>
                        </div>
                    </div>

                    <div class="d-flex step wizard-step" data-wizard-step="3">
                        <div class="pr-2 pr-md-4 d-flex flex-column text-right">
                            <span class="step__title"><?=Loc::getMessage('Step4');?></span>
                            <span class="step__subtitle"><?=Loc::getMessage('Terms-of-sale');?></span>
                        </div>

                        <div class="d-flex justify-content-center align-items-center step__icone">
                            <i class="icon-information"></i>
                        </div>
                    </div>

                    <div class="d-flex step wizard-step" data-wizard-step="2">
                        <div class="pr-2 pr-md-4 d-flex flex-column text-right">
                            <span class="step__title"><?=Loc::getMessage('Step3');?></span>
                            <span class="step__subtitle"><?=Loc::getMessage('Detailed-description');?></span>
                        </div>

                        <div class="d-flex justify-content-center align-items-center step__icone">
                            <i class="icon-job-seeking"></i>
                        </div>
                    </div>

                    <div class="d-flex step wizard-step" data-wizard-step="1">
                        <div class="pr-2 pr-md-4 d-flex flex-column text-right">
                            <span class="step__title"><?=Loc::getMessage('Step2');?></span>
                            <span class="step__subtitle"><?=Loc::getMessage('Apartment-address');?></span>
                        </div>

                        <div class="d-flex justify-content-center align-items-center step__icone">
                            <i class="icon-placeholder-1"></i>
                        </div>
                    </div>

                    <div class="d-flex step wizard-step" data-wizard-step="0">
                        <div class="pr-2 pr-md-4 d-flex flex-column text-right">
                            <span class="step__title"><?=Loc::getMessage('Step1');?></span>
                            <span class="step__subtitle"><?=Loc::getMessage('Uploading-photos');?></span>
                        </div>

                        <div class="d-flex justify-content-center align-items-center step__icone">
                            <i class="icon-camera-1"></i>
                        </div>
                    </div>
                </div>
                <form id="mainForm" action="/" onsubmit="submitForm(event)">
                    <div>
                        <div class="wizard-content" data-wizard-content="0">
                            <div class="d-flex flex-column step-one step-photos">
                                <h2 class="step-one__title"><?=Loc::getMessage('What-type-of-object');?></h2>

                                <div class="mb-4 row">
                                    <div class="col-9 col-lg-10">
                                        <div class="d-flex justify-content-end flex-wrap gap-1 property-type-radio">
                                            <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                                                <input  <?=$arFields['IBLOCK_SECTION_ID'] == 35 ? 'checked' : ''?>
                                                        data-section-id="35"
                                                        data-type-section-id="27"
                                                        id="typeResidential"
                                                        type="radio"
                                                        name="type"
                                                        class="type-sections"
                                                >
                                                <label id="typeResidentialLable" onclick="hideModelBrand(27, this)" class="px-2 py-1" for="typeResidential">
                                                    <?=Loc::getMessage('Residential');?>
                                                </label>
                                            </div>
                                            <?/* Новостройки
                                            <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                                                <input  <?=($arFields['IBLOCK_SECTION_ID'] == 31) ? 'checked' : ''?>
                                                        data-section-id="<?=31?>"
                                                        id="typeNewBuildings"
                                                        type="radio"
                                                        name="type"
                                                        class="type-sections"
                                                >
                                                <label onclick="hideModelBrand(29, this)" class="px-2 py-1" for="typeNewBuildings">
                                                    <?=Loc::getMessage('New-buildings');?>
                                                </label>
                                            </div>
                                            */?>
                                            <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                                                <input <?=($arFields['IBLOCK_SECTION_ID'] == 33) ? 'checked' : ''?>
                                                        data-section-id="33"
                                                        data-type-section-id="28"
                                                        id="typeCommercial"
                                                        type="radio"
                                                        name="type"
                                                        class="type-sections"
                                                >
                                                <label onclick="hideModelBrand(28, this)" class="px-2 py-1" for="typeCommercial">
                                                    <?=Loc::getMessage('Commercial');?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col d-flex font-weight-bold">
                                        <p class="m-0 text-left w-100 font-weight-bold"><?=Loc::getMessage('Type');?></p>
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <div class="col-9 col-lg-10">
                                        <div class="d-flex justify-content-end flex-wrap div-req gap-1">
                                            <?foreach($rentType as $arItem):?>
                                                <div data-parent-id="<?= $arItem['UF_PARENT_ID']?>"
                                                     style="display: none"
                                                     class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn"
                                                >
                                                    <input <?=$arProps['PROP_TYPE_APART']['VALUE'] == $arItem['UF_XML_ID'] ? 'checked' : ''?>
                                                            data-id-self="<?=$arItem['UF_XML_ID']?>"
                                                            data-id_prop="PROP_TYPE_APART"
                                                            id="type<?=$arItem['UF_XML_ID']?>"
                                                            type="radio"
                                                            name="type1"
                                                            required
                                                    >
                                                    <label class="px-2 py-1" for="type<?=$arItem['UF_XML_ID']?>">
                                                        <?=!empty($arItem['UF_IVRIT']) ? $arItem['UF_IVRIT'] : $arItem['UF_XML_ID']?>
                                                    </label>
                                                </div>
                                            <?endforeach;?>
                                        </div>
                                    </div>

                                    <div class="col d-flex font-weight-bold">
                                        <p class="m-0 text-left w-100 font-weight-bold"><?=Loc::getMessage('Type-rent');?> *</p>
                                    </div>
                                </div>
                                <script>
                                    function hideModelBrand(id, el) {
                                        element = $("#mainForm").find(`[data-parent-id]`).hide();
                                        element = $("#mainForm").find(`[data-parent-id='${id}']`).show();
                                    }
                                </script>
                                <h2 class="step-one__title"><?
                                    $dir = $APPLICATION->GetCurDir();
                                    $dirName = str_replace('/', '', $dir); // PHP код
                                    $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        Array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_TEMPLATE_PATH."/includes/area/".mb_strtolower($dirName)."-h2-ru.php",
                                            "EDIT_TEMPLATE" => ""
                                        )
                                    );
                                    // символы для удаления


                                    ?></h2>

                                <p class="step-one__text"><?
                                    $dir = $APPLICATION->GetCurDir();
                                    $dirName = str_replace('/', '', $dir); // PHP код
                                    $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        Array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_TEMPLATE_PATH."/includes/area/".mb_strtolower($dirName)."-p2-ru.php",
                                            "EDIT_TEMPLATE" => ""
                                        )
                                    );
                                    // символы для удаления


                                    ?></p>

                                <div class="row row-cols-3 row-cols-lg-5 step-one__icons-line">
                                    <div class="col">
                                        <span class="icon"><i class="icon-bed"></i></span>
                                        <p class="mb-0"><?=Loc::getMessage('Rooms');?></p>
                                    </div>

                                    <div class="col">
                                        <span class="icon"><i class="icon-kitchen"></i></span>
                                        <p class="mb-0"><?=Loc::getMessage('Kitchen');?></p>
                                    </div>

                                    <div class="col">
                                        <span class="icon"><i class="icon-toilet"></i></span>
                                        <p class="mb-0"><?=Loc::getMessage('Bathroom');?></p>
                                    </div>

                                    <div class="col">
                                        <span class="icon"><i class="icon-windows"></i></span>
                                        <p class="mb-0"><?=Loc::getMessage('View-from-the-window');?></p>
                                    </div>
                                </div>

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
                                                    <div onclick="addActivePhoto(this)" id="213213"
                                                         class="set-main-text">
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
                                                        <span onclick="rotateThis(this)"
                                                              class="d-none d-lg-inline-block"><?=Loc::getMessage('rotatePhoto')?></span>
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
                                                             data-rotate="0" data-id="<?= $PHOTO ?>"
                                                             class="rotate-img">
                                                    </div>

                                                    <label id="main-selector-photo"
                                                           class="mb-2 p-0 btn text-center text-primary main-selector-photo">
                                                        <input type="radio" name="fileMain"
                                                               value="<?= $PHOTO ?>.PNG"
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
                                                            <input type="hidden" name="rotate[<?= $PHOTO ?>.PNG]"
                                                                   value="0">
                                                            <i onclick="rotateThis(this)"
                                                               class="mr-2 icon-replay"></i>
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
                                                <p class="mb-0 label-add-photo__text"><?= Loc::getMessage('Add photo'); ?></p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <p><?=Loc::getMessage('Ads-are-published-only-with-photos');?></p>
                            </div>
                        </div>
                        <div class="wizard-content" data-wizard-content="1">
                            <div class="step-two">
                                <h2 class="text-center text-uppercase font-weight-bolder step-two__title"><?=Loc::getMessage('Citystreet');?></h2>
                                <div class="map-wrapper">
                                    <div class="steps-map">
                                        <div id='map' style="width: 100%; height: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-content" data-wizard-content="2">
                            <div class="property step-three">
                                <h3 class="mb-3 mb-lg-4 text-center text-uppercase font-weight-bolder auto-step2__title">What apartment are you renting?</h3>
                                <div class="mb-5 d-flex flex-column">
                                    <p class="pt-0 text-right text-before-ta">
                                        <?php
                                        $dir = $APPLICATION->GetCurDir();
                                        $dirName = str_replace('/', '', $dir); // PHP код
                                        $APPLICATION->IncludeComponent(
                                            "bitrix:main.include",
                                            "",
                                            Array(
                                                "AREA_FILE_SHOW" => "file",
                                                "PATH" => SITE_TEMPLATE_PATH."/includes/area/".mb_strtolower($dirName)."-p5-ru.php",
                                                "EDIT_TEMPLATE" => ""
                                            )
                                        );?>
                                    </p>
                                    <textarea class="w-100 p-3 pt-2 border rounded"
                                              placeholder="תיאור"
                                              name="discriptions"
                                              id="text-discriptions"
                                              rows="4"><?=str_replace($deletingChairs, "",$arFields['PREVIEW_TEXT'])?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-content" data-wizard-content="3">
                            <div class="property-step-price">
                                <h2 class="mb-4 text-center text-uppercase font-weight-bolder auto-step2__title"><?=Loc::getMessage('rent-price');?></h2>
                                <p class="text-center">
                                    <?php
                                    $dir = $APPLICATION->GetCurDir();
                                    $dirName = str_replace('/', '', $dir); // PHP код
                                    $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        Array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_TEMPLATE_PATH."/includes/area/".mb_strtolower($dirName)."-p3-ru.php",
                                            "EDIT_TEMPLATE" => ""
                                        )
                                    );?>
                                </p>
                                <p class="mb-4 text-center">
                                    <?php
                                    $dir = $APPLICATION->GetCurDir();
                                    $dirName = str_replace('/', '', $dir); // PHP код
                                    $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        Array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_TEMPLATE_PATH."/includes/area/".mb_strtolower($dirName)."-p4-ru.php",
                                            "EDIT_TEMPLATE" => ""
                                        )
                                    );?>
                                </p>
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="d-flex">
                                        <p class="icon-currency-shek" style="font-size: 33px;
                                                        margin-top: 5px;
                                                        color: #3fb465;
                                                        padding-right: 10px;
                                                        ">
                                            <?= ICON_CURRENCY; ?>
                                        </p>
                                        <div class="ml-4 mb-0 form-group">
                                            <input type="number" class="form-control" id="sellPrice" placeholder="0" required value="<?=(is_array($arProps['PRICE']['VALUE'])) ? $arProps['PRICE']['VALUE'][0]: $arProps['PRICE']['VALUE'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-content" data-wizard-content="4">
                            <div class="mb-4 property-step-contact">
                                <h2 class="mb-4 text-center text-uppercase font-weight-bolder"><?=Loc::getMessage('Contact-Information');?></h2>

                                <div class="d-flex flex-column contact__main">
                                    <div class="mb-4 d-flex justify-center div-req">

                                        <div class="mr-2 form_radio_btn">
                                            <input data-id-self="Agency" id="forAgency" type="radio"
                                                   name="thisUserStatus"
                                                   data-id_prop="146"
                                                <?= ($arProps['UF_SELLER_TYPE']['VALUE'] == "Agency") ? 'checked' : '' ?>
                                                   value="Agency" required>
                                            <label for="forAgency"><?=Loc::getMessage('Agency');?></label>
                                        </div>

                                        <div class="form_radio_btn">
                                            <input data-id-self="Owner" id="forOwner" type="radio"
                                                   data-id_prop="146"
                                                   name="thisUserStatus" value="Owner"
                                                <?= ($arProps['UF_SELLER_TYPE']['VALUE'] == "Owner") ? 'checked' : '' ?>

                                                   required>
                                            <label for="forOwner"><?=Loc::getMessage('Owner');?></label>
                                        </div>
                                    </div>

                                    <div class="agency">
                                        <div class="form-group">
                                            <input data-id-self="Legalname" id="Legalname" class="form-control" value="<?=$arProps['UF_NAME']['VALUE']?>"
                                                   type="text" placeholder="<?=Loc::getMessage('Legal-name');?> *"
                                                   required>
                                        </div>
                                    </div>


                                    <div class="number-section">
                                        <div class="form-group">
                                            <input data-req="Y" data-id-self="phone1" id="phone1" class="form-control"  value="<?=$arProps['UF_PHONE_1']['VALUE']?>"
                                                   type="text"
                                                   placeholder="<?=Loc::getMessage('Enter-your-phone-number-in-international-format');?> *"
                                                   required>
                                        </div>

                                        <div class="form-group">
                                            <input data-id-self="phone2" id="phone2" class="form-control" value="<?=$arProps['UF_PHONE_2']['VALUE']?>"
                                                   type="text"
                                                   placeholder="<?=Loc::getMessage('Enter-your-phone-number-in-international-format');?>"
                                                   required>
                                        </div>

                                        <div class="form-group">
                                            <input data-id-self="phone3" id="phone3" class="form-control" value="<?=$arProps['UF_PHONE_3']['VALUE']?>"
                                                   type="text"
                                                   placeholder="<?=Loc::getMessage('Enter-your-phone-number-in-international-format');?>"
                                                   required>
                                        </div>
                                    </div>

                                 

                                    <div class="mb-4 row flex-column-reverse flex-lg-row property-step-contact__time">
                                        <div class="d-none d-lg-flex col-3">
                                            <div class="form_radio_btn">
                                                <input  <?=$arProps["UF_CALL_ANYTIME"]['VALUE'] > 0 ? 'checked' : '' ?>
                                                        id="anytime"
                                                        type="checkbox"
                                                        name="anytime"
                                                        value="anytime"
                                                        data-id_prop="UF_CALL_ANYTIME"
                                                        data-id-self="1"
                                                >
                                                <label class="mr-3 mb-0" for="anytime">
                                                    <?=Loc::getMessage('Anytime')?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7">
                                            <div class="row">
                                                <div class="col">
                                                    <select id="callTo"
                                                            class="selectpicker"
                                                            data-style-base="form-control form-control-select"
                                                    >
                                                        <?php foreach (DAY_TIME as $time):?>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == $time) ? 'selected' : '' ?>
                                                                    value="<?=explode(':',$time)[0]?>"
                                                            >
                                                                <?= Loc::getMessage('to')?>
                                                                <span><?=$time?></span>
                                                            </option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <select id="callFrom"
                                                            class="selectpicker"
                                                            data-style-base="form-control form-control-select"
                                                    >
                                                        <?php foreach (DAY_TIME as $time):?>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == $time) ? 'selected' : '' ?>
                                                                    value="<?=explode(':',$time)[0]?>"
                                                            >
                                                                <?=Loc::getMessage('from')?>
                                                                <span><?=$time?></span>
                                                            </option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-2 d-flex justify-content-end align-items-center">
                                            <p class="text-right mb-3 mb-lg-0 font-weight-bold">
                                                <?=Loc::getMessage('Call:')?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="propert-sell-main__step-control">
                        <button onclick="submitForm(event)" class="btn btn-primary wizard-control-final">
                            <span><?=Loc::getMessage('Submit your ad');?></span>
                        </button>
                        <button type="button" class="btn steps-button wizard-control-next">
                            <span class="btn-icon"><i class="icon-left-arrow"></i></span>
                            <span><?=Loc::getMessage('Next step');?></span>
                        </button>
                        <button type="button" class="btn wizard-control-prev">
                            <span class="mr-2"><?=Loc::getMessage('Next step');?></span>
                            <span class="btn-icon icon-arrow-right"><i class="icon-left-arrow"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="allert alert-confirmation flex-column card">
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex justify-content-center allert__text"><?=Loc::getMessage('Moderation message')?></div>
        <div class="d-flex justify-content-center mt-4">
            <button onclick="window.location.href = '/personal/'" class="btn_confirm btn border-primary text-uppercase font-weight-bold text-primary py-3 px-5">
                <?=Loc::getMessage('Go to personal')?>
            </button>
        </div>
    </div>
</div>

<script>
    /*$('#Legalname').hide();*/
    $('#forAgency').click(function () {
        $('#Legalname').show();
    })
    $('#forOwner').click(function () {
        $('#Legalname').hide();
    })

    if (window.location.href.indexOf("EDIT") > -1) {
        if ($('#Legalname').val().length > 0) {
            $('#forAgency').prop('checked', true);
            $('#Legalname').show();
        } else {
            $('#forOwner').prop('checked', true);
            $('#Legalname').hide();
        }
    } else {
        $('#forOwner').prop('checked', true);
        $('#Legalname').hide();
    }

    function checkFinalFields() {
        let errors = 0;
        let errorsDiv = 0;
        $(this).find('input').each(function () {
            let inputData = $(this).data()
            inputData.req = $(this).attr('data-req')
            let value = $(this).val()

            if (inputData.req === 'Y') {
                if ($(this).attr('type') == 'radio') {

                } else {
                    if (value === '') {
                        errors++;
                        $(this).css('border-block-color', 'red')
                    } else {
                        $(this).css('border-block-color', '')
                    }
                }
            }

        });

        $(this).find('.div-req').each(function () {
            errorsDiv++;
            $(this).find('input').each(function (index) {
                if ($(this).is(':checked') != false)
                    errorsDiv--;
            })
        });

        $('.property-step-contact input[data-req="Y"].form-control').each(function () {
            if ($(this).val().length <= 0) errors++;
        });

        if (errors > 0) {
            $('.wizard-control-final').removeClass('active');
        } else {
            $('.wizard-control-final').addClass('active');
            if (errorsDiv > 0) {
                ('.wizard-control-final').removeClass('active');
            } else {
                $('.wizard-control-final').addClass('active');
            }
        }
    }

    $(document).ready(() => {
        $('.property-step-contact .div-req .form_radio_btn').each(function () {
            $(this).click(() => {
                let selectedSellerTypeOwner = $('#forOwner').is(':checked')
                if (selectedSellerTypeOwner) {
                    $('#Legalname').hide();
                    $('#Legalname').attr('data-req', 'N');
                } else {
                    $('#Legalname').show();
                    $('#Legalname').attr('data-req', 'Y');
                    $('#Legalname').on("keyup", () => {
                        checkFinalFields();
                    });
                }

                checkFinalFields();
            });
        });

        $('.property-step-contact input[data-req="Y"].form-control').each(function () {
            $(this).on("keyup", () => {
                checkFinalFields();
            });
        });

        let allWizardsContent = document.querySelectorAll('form#mainForm div.wizard-content');
        $('.wizard-control-next').click(function () {
            if (allWizardsContent) {
                const lastKey = allWizardsContent.length - 1;
                allWizardsContent.forEach((wizardContainer,index) => {
                    if (index === lastKey) {
                        let isLastStep = wizardContainer.classList.contains('active');
                        if (isLastStep) {
                            checkFinalFields();
                        }
                    }
                });
            }
        })
    });

    let flagPhoto = true;
    function addActivePhoto(item){
        if(item !== undefined){
            let mainText = document.querySelectorAll(".set-main-text");

            mainText.forEach((el)=>{
                el.innerText = "<?=Loc::getMessage('setPhotoMain');?>";
                el.closest(".main-photo__item").querySelector(".rotate-img").removeAttribute("data-activePhoto");
            })
            item.closest(".main-photo__item").querySelector(".rotate-img").setAttribute("data-activePhoto", "isActive");

            item.innerText = "<?=Loc::getMessage('photoMain');?>";
        }
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
                let photoList = document.querySelectorAll(".main-selector-photo .set-main-text");
                photoList.forEach((el) => {
                    let textItem = el.innerText;
                    if (textItem === "<?=Loc::getMessage('photoMain');?>") {
                        return flagPhoto = false
                    }
                })

                if (flagPhoto) {
                    setTimeout(function () {
                        let photoItems = document.querySelectorAll(".main-photo__item")
                        let mainPhoto = photoItems[photoItems.length - 1]
                        mainPhoto.querySelector("img").setAttribute("data-activePhoto", "isActive");
                        mainPhoto.querySelector(".set-main-text").innerText = "<?=Loc::getMessage('photoMain');?>"
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

    function rotateThis(item) {
        let count_rotate = $(item).parents('.main-photo__item').find('img').attr('data-rotate');
        $(item).parents('.main-photo__item').find('img').attr('data-rotate')
        count_rotate = parseInt(count_rotate) + 1;
        $(item).closest('.main-photo__item').find('img').attr('data-rotate', count_rotate);
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
           <div onclick="addActivePhoto(this)" id="213213" class="set-main-text"><?=Loc::getMessage('setPhotoMain');?></div>
        </label>

        <div class="d-flex justify-content-around">
          <div class="mr-3 d-flex justify-content-center align-items-center element-control" data-file-remove-id="{{name}}">
            <i class="mr-2 icon-clear"></i>
            <span class="d-none d-lg-inline-block"><?=Loc::getMessage('deletePhoto');?></span>
          </div>

          <div class="d-flex justify-content-center align-items-center element-control rotate-control">
            <input  type="hidden" name="rotate[{{name}}]" value="0" />
            <i onclick="rotateThis(this)" class="mr-2 icon-replay"></i>
            <span onclick="rotateThis(this)" class="d-none d-lg-inline-block"><?=Loc::getMessage('rotatePhoto');?></span>
          </div>
        </div>
      </div>
    </div>`,
    );

    $('.section_id_a').click(function (e) {
        $('.activeSection').each(function () {
            if (e.target != this) {
                this.checked = false;
                $(this).toggleClass('activeSection')
            }
        });
        $(this).toggleClass('activeSection')
    })

    function submitForm(event) {
        event.preventDefault();
        // get main form data
        var $data = {};
        $('#mainForm').find('input').each(function () {
            if (this.checked) {
                var display = $(this).parents('.flex-lg-row');
                if (display.css('display') === 'none'){
                }else {
                    var object = {}
                    object.val = this.checked;
                    object.data = $(this).data();
                    $data[this.id] = object

                }

            } else {
                var display = $(this).parents('.flex-lg-row');
                if (display.css('display') === 'none'){
                }else {
                    var object = {}
                    object.val = $(this).val();
                    object.data = $(this).data();
                    $data[this.id] = object;

                }
            }
        });
        // get select values
        $('#mainForm').find('select').each(function () {
            $data[this.id] = $(this).val();
        });
        // get img
        var a = 0;
        var $imgobject = {};
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
        $data['itemDescription'] = $('#text-discriptions').val();

        // check if is edit page
        <?if($_GET['EDIT'] == 'Y'){?>
            $data['EDIT'] = 'Y';
            $data['EDIT_ID'] = '<?=$_GET['ID']?>'
        <?}?>

        $data['section_id'] = $('.activeSection').data();
        // get marker
        let marker = JSON.parse(localStorage.getItem('markerData')); // object
        let locationPosition = localStorage.getItem('locationDataPosition');
        let locationLatLng = localStorage.getItem('locationDataLatLng');

        $data['UF_NAME'] = $('#Legalname').val();
        $data['MAP_LATLNG'] = locationLatLng;
        $data['MAP_POSITION'] = locationPosition;
        $data['MAP_LAYOUT'] = marker.districtName;
        $data['MAP_LAYOUT_BIG']= marker.regionName;

        $('.preloader').addClass('preloader-visible');
        let deferred = $.ajax({
            type: "POST",
            url: "/ajax/add_buy.php",
            data: $data,
            dataType: 'json'
        });
        deferred.done(function (data) {
            $('.preloader').removeClass('preloader-visible');
            if (data.success == 1) {
                $('.allert').addClass('show');
            } else {
                $('.pop-up').addClass('active');
                $('.pop-up__text').html(data.responseBitrix)
            }
        });
    }

</script>
<style>
    .activeSection {
        color: #3fb465 !important;
    }

</style>


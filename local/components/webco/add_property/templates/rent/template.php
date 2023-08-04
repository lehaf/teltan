<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/add-page.css");

Loc::loadMessages(__FILE__);
$APPLICATION->SetTitle("Добавить объявление");
global $arSetting;
$arLink = CIBlockSectionPropertyLink::GetArray(2, 27);
// Если нет номера телефона, то редиректим на форму с его добавлением
$userPhone = getUserInfoByID()['PERSONAL_PHONE'];
if (!$userPhone)
    LocalRedirect($GLOBALS['arSetting'][SITE_ID]['href'] . 'personal/edit/');

$IBLOCK_ID = 2;
if ($_GET['EDIT'] == 'Y' && $_GET['ID']) {
    $arSelect = array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_*", "PREVIEW_TEXT", "PREVIEW_PICTURE");
    $arFilter = array("IBLOCK_ID" => $IBLOCK_ID, 'ID' => $_GET['ID'], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();
    }
}
ps($arProps);

$GLOBALS['MAP_EDIT_RESULT_CORDINATES'] = $arProps['MAP_LATLNG']['~VALUE'];
$GLOBALS['MAP_EDIT_RESULT_POSITION'] = $arProps['MAP_POSITION']['~VALUE'];
?>
    <div class="container">
        <h2 class="mb-5 d-flex justify-content-end subtitle"><?=Loc::getMessage('titleH2Main')?></h2>
        <div class="card">
            <div class="propert-sell-main">
                <div id="wizard">
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
                    <?
                    CModule::IncludeModule('highloadblock');
                    $entity_data_class = GetEntityDataClass(17);
                    $arTypesRent = $entity_data_class::getList(array(
                        'select' => array('*'),
                        'cache' => [
                            'ttl' => 360000,
                            'cache_joins' => true
                        ]
                    ))->fetchAll();

                    ?>
                    <form id="mainForm" action="/" onsubmit="submitForm(event)">
                        <div>
                            <div class="wizard-content" data-wizard-content="0">
                                <div class="d-flex flex-column step-one step-photos">
                                    <h2 class="step-one__title"><?=Loc::getMessage('What-type-of-object');?></h2>

                                    <div class="mb-4 row">
                                        <div class="col-9 col-lg-10">
                                            <div class="d-flex justify-content-end flex-wrap gap-1">
                                                <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                                                    <input <?=($arFields['IBLOCK_SECTION_ID'] == REAL_ESTATE_LIVE_RENT_SECTION_ID)? 'checked' : ''?> id="typeResidential" type="radio" name="type">
                                                    <label id="typeResidentialLable" onclick="hideModelBrand(27, this)" class="px-2 py-1" for="typeResidential"><?=Loc::getMessage('Residential');?></label>
                                                    <?if($arFields['IBLOCK_SECTION_ID'] == REAL_ESTATE_LIVE_RENT_SECTION_ID){?>
                                                        <script>
                                                            $(document).ready(function(){
                                                                $("#typeResidential").siblings('label').trigger("click");
                                                            });
                                                        </script>
                                                    <?}?>
                                                </div>

                                                <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                                                    <input <?=($arFields['IBLOCK_SECTION_ID'] == 30)? 'checked' : ''?> id="typeNewBuildings" type="radio" name="type">
                                                    <label onclick="hideModelBrand(29, this)" class="px-2 py-1" for="typeNewBuildings"><?=Loc::getMessage('New-buildings');?></label>
                                                    <?if($arFields['IBLOCK_SECTION_ID'] == 30){?>
                                                        <script>
                                                            $(document).ready(function(){
                                                                $("#typeNewBuildings").siblings('label').trigger("click");
                                                            });
                                                        </script>
                                                    <?}?>
                                                </div>

                                                <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                                                    <input <?=($arFields['IBLOCK_SECTION_ID'] == 32)? 'checked' : ''?> id="typeCommercial" type="radio" name="type">
                                                    <label onclick="hideModelBrand(28, this)" class="px-2 py-1" for="typeCommercial"><?=Loc::getMessage('Commercial');?></label>
                                                    <?if($arFields['IBLOCK_SECTION_ID'] == 32){?>
                                                        <script>
                                                            $(document).ready(function(){
                                                                $("#typeCommercial").siblings('label').trigger("click");
                                                            });
                                                        </script>
                                                    <?}?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col d-flex font-weight-bold">
                                            <p class="m-0 text-left w-100 font-weight-bold"><?=Loc::getMessage('Type');?></p>
                                        </div>
                                    </div>

                                    <div class="mb-4 row">
                                        <div class="col-9 col-lg-10">
                                            <div class="d-flex justify-content-end flex-wrap data-property-req gap-1">
                                                <?foreach($arTypesRent as $arItem){?>
                                                    <div data-parent-id="<?= $arItem['UF_PARENT_ID']?>" style="display: none" class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn ">
                                                        <input required <?=($arProps['PROP_TYPE_APART']['VALUE'] == $arItem['UF_NAME']) ? 'checked' : ''?>
                                                               data-id-self="<?= $arItem['UF_XML_ID'] ?>"
                                                               data-id_prop="PROP_TYPE_APART"
                                                               id="type<?=$arItem['UF_XML_ID']?>"
                                                               type="radio"
                                                               name="type1"
                                                        >
                                                        <label class="px-2 py-1" for="type<?=$arItem['UF_XML_ID']?>"><?=Loc::getMessage($arItem['UF_XML_ID']);?></label>
                                                    </div>
                                                <?}?>
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
                                    <h2 class="step-one__title"><?=Loc::getMessage('titleH2')?></h2>
                                    <script>
                                        $(document).ready(function(){
                                            setTimeout(() => {
                                                $("#typeПентхаус").siblings('label').trigger("click");
                                                console.log("Delayed for 1 second.");
                                            }, 1000);

                                        });
                                    </script>
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
                                                            <div onclick="addActivePhoto(this)" id="<?= $PHOTO ?>" class="set-main-text">
                                                                <?=Loc::getMessage('setPhotoMain')?>
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
                                        <input id="fileUploaderFiles" class="d-none" type="file" name="files[]"
                                               multiple>

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
                                            <!--<div action="/" class="row d-flex justify-content-start justify-content-lg-center steps-map__form">
                                                <div class="col-6 mb-0 form-group">
                                                    <input data-id_prop="55" type="text" placeholder="City" class="border-0 form-control" id="55locla" aria-describedby="">
                                                </div>
                                            </div>
                                            -->

                                            <div id='map' style="width: 100%; height: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-content" data-wizard-content="2">
                                <?
                                $entity_data_class = GetEntityDataClass(8);
                                $rsData = $entity_data_class::getList(array(
                                    'select' => array('*')
                                ));
                                while ($arPropsSection[] = $rsData->fetch()) {
                                    //  print_r($arPropsSection);
                                }
                                if (CModule::IncludeModule("iblock"))
                                    $IBLOCK_ID = 2;
                                $properties = CIBlockProperty::GetList(array("sort" => "asc", "name" => "asc"), array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID));
                                while ($prop_fields[] = $properties->GetNext()) {
                                    //echo $prop_fields["ID"]." - ".$prop_fields["NAME"]."<br>";
                                }
                                $arProp = [];
                                foreach ($prop_fields as $field) {
                                    $needle = 'ROP';
                                    $pos = strripos($field['CODE'], $needle);
                                    if ($pos == 1 ) {
                                        if ($field['PROPERTY_TYPE'] == 'L') {
                                            $db_enum_list = CIBlockProperty::GetPropertyEnum($field['ID'], array("sort" => "asc"), array("IBLOCK_ID" => 2, 'PROPERTY_ID' => $field['ID']));
                                            while ($ar_enum_list[] = $db_enum_list->GetNext()) {
                                                $field['PROP_ENUM_VAL'] = $ar_enum_list;
                                            }
                                            // print_r($ar_enum_list);
                                        }
                                        $ar_enum_list = [];
                                        $arProp[] = $field;

                                    }
                                }

                                function in_array_r($needle, $haystack, $strict = false) {
                                    foreach ($haystack as $item) {
                                        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                                            return true;
                                        }
                                    }

                                    return false;
                                }
                                $filterProps = [];
                                $filterProps2 = [];
                                $filterProps3 = [];
                                $restrictions = [];
                                foreach($arProp as $arItem){
                                    if(in_array_r($arItem['ID'], $arPropsSection[0]) == true && $arItem['CODE'] != 'PROP_restrictions'){

                                        $filterProps[1][$arItem['ID']] = $arItem;
                                    }elseif($arItem['CODE'] == 'PROP_restrictions'){
                                        $restrictions = $arItem;
                                    }
                                    if(in_array_r($arItem['ID'], $arPropsSection[1]) == true && $arItem['CODE'] != 'PROP_restrictions'){

                                        $filterProps[2][$arItem['ID']] = $arItem;
                                    }
                                    if(in_array_r($arItem['ID'], $arPropsSection[2]) == true && $arItem['CODE'] != 'PROP_restrictions'){

                                        $filterProps[3][$arItem['ID']] = $arItem;
                                    }
                                }
                                ?>
                                <div class="property step-three">
                                    <h3 class="mb-3 mb-lg-4 text-center text-uppercase font-weight-bolder auto-step2__title"><?=Loc::getMessage('Whatapartment');?></h3>
                                    <? foreach ($filterProps[1] as $filterProp) {?>
                                        <?
                                        $pattern = '/ID(\d+)/';
                                        preg_match_all($pattern, $filterProp['CODE'], $matches);
                                        $id = $matches[1];
                                        $id = array_reverse($id);
                                        ?>
                                        <?if($filterProp['PROPERTY_TYPE'] == 'L'){?>
                                            <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row " data-parent-id="27" style="display: none">
                                                <div class="col-12 col-lg-10">
                                                    <div class="d-flex justify-content-center justify-content-lg-end align-items-center gap-1">
                                                        <?if ($id){foreach ($id as $ids){drawElement($filterProps[1][$ids] , $arLink ,$arProps);}}?>
                                                        <?sort($filterProp['PROP_ENUM_VAL'])?>
                                                        <?foreach($filterProp['PROP_ENUM_VAL']  as $arItem){?>
                                                            <div class="mr-3 form_radio_btn">
                                                                <input id="radio-<?= $arItem['ID'] ?>1"
                                                                    <?=($arProps[$filterProp['CODE']]['VALUE'] == $arItem['VALUE'])? 'checked' : ''?>
                                                                       data-id_prop="<?= $arItem['PROPERTY_ID'] ?>"
                                                                       data-id-self="<?= $arItem['ID'] ?>"
                                                                       type="radio" name="<?=$filterProp['CODE']?>1" >
                                                                <label for="radio-<?= $arItem['ID'] ?>1"><?=$arItem['VALUE']?></label>
                                                            </div>
                                                        <?}?>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-2">
                                                    <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                                        :<?=$filterProp['NAME']?>
                                                    </p>
                                                </div>
                                            </div>
                                        <? }else{?>
                                            <?if($filterProp['ID'] == 174){?>
                                                <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row" data-parent-id="27" style="display: none">

                                                    <div class="col-12 col-lg-10">
                                                        <div class="d-flex flex-wrap justify-content-center justify-content-lg-end">
                                                            <div class="mr-0 mr-lg-3 form-group">
                                                                <input id="1721"  data-id_prop="172" class="form-control" type="text" placeholder="שטח מרפסת" required="" value="<?=$arProps['PROP_AREA_1']['VALUE']?>">
                                                            </div>

                                                            <div class="mr-0 mr-lg-3 form-group">
                                                                <input id="1731"  data-id_prop="173" class="form-control" type="text" placeholder="שטח מגורים" required="" value="<?=$arProps['PROP_AREA_2']['VALUE']?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <input id="1741"  data-id_prop="174" class="form-control" type="text" placeholder=" שטח הכולל" required="" value="<?=$arProps['PROP_AREA_3']['VALUE']?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-2">
                                                        <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                                            :<?=$filterProp['NAME']?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?}else{?>
                                                <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row" data-parent-id="27" style="display: none">
                                                    <div class="col-12 col-lg-10">
                                                        <?if ($id){foreach ($id as $ids){drawElement($filterProps[1][$ids] , $arLink ,$arProps);}}?>
                                                        <div class="d-flex justify-content-center justify-content-lg-end form-group">
                                                            <input id="<?= $filterProp['ID'] ?>1"  data-id_prop="<?= $filterProp['CODE'] ?>" class="form-control" type="number" placeholder="" value="<?=$arProps[$filterProp['CODE']]['VALUE']?>" required="">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-lg-2">
                                                        <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                                            :<?=$filterProp['NAME']?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?}?>
                                        <? }
                                    }?>
                                    <? foreach ($filterProps[2] as $filterProp) {?>
                                        <?
                                        $pattern = '/ID(\d+)/';
                                        preg_match_all($pattern, $filterProp['CODE'], $matches);
                                        $id = $matches[1];
                                        $id = array_reverse($id);
                                        ?>
                                        <?sort($filterProp['PROP_ENUM_VAL'])?>
                                        <?if($filterProp['PROPERTY_TYPE'] == 'L'){?>
                                            <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row" data-parent-id="28" style="display: none">
                                                <div class="col-12 col-lg-10">
                                                    <div class="d-flex justify-content-center justify-content-lg-end align-items-center">
                                                        <?if ($id){foreach ($id as $ids){drawElement($filterProps[2][$ids] , $arLink ,$arProps);}}?>
                                                        <?foreach($filterProp['PROP_ENUM_VAL']  as $arItem){?>

                                                            <div class="mr-3 form_radio_btn">
                                                                <input id="radio-<?= $arItem['ID'] ?>2" type="radio" name="<?=$filterProp['CODE']?>2"
                                                                    <?=($arProps[$filterProp['CODE']]['VALUE'] == $arItem['VALUE'])? 'checked' : ''?>
                                                                       data-id_prop="<?= $arItem['PROPERTY_ID'] ?>"
                                                                       data-id-self="<?= $arItem['ID'] ?>"
                                                                >
                                                                <label for="radio-<?= $arItem['ID'] ?>2"><?=$arItem['VALUE']?></label>
                                                            </div>
                                                        <?}?>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-2">
                                                    <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                                        :<?=$filterProp['NAME']?>
                                                    </p>
                                                </div>
                                            </div>
                                        <? }else{?>
                                            <?if($filterProp['ID'] == 174){?>
                                                <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row" data-parent-id="28" style="display: none">

                                                    <div class="col-12 col-lg-10">
                                                        <div class="d-flex flex-wrap justify-content-center justify-content-lg-end">
                                                            <div class="mr-0 mr-lg-3 form-group">
                                                                <input id="1722"  data-id_prop="172" class="form-control" type="text" placeholder="Kitchen" required="" value="<?=$arProps['PROP_AREA_1']['VALUE']?>">
                                                            </div>

                                                            <div class="mr-0 mr-lg-3 form-group">
                                                                <input id="1732"  data-id_prop="173" class="form-control" type="text" placeholder="Residential" required="" value="<?=$arProps['PROP_AREA_2']['VALUE']?>">
                                                            </div>

                                                            <div class="mr-3 form-group">
                                                                <input id="1742"  data-id_prop="174" class="form-control" type="text" placeholder="General" required="" value="<?=$arProps['PROP_AREA_3']['VALUE']?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-2">
                                                        <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                                            :<?=$filterProp['NAME']?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?}else{?>
                                                <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row" data-parent-id="28" style="display: none">
                                                    <div class="col-12 col-lg-10">
                                                        <?if ($id){foreach ($id as $ids){drawElement($filterProps[2][$ids] , $arLink ,$arProps);}}?>
                                                        <div class="mr-3 d-flex justify-content-center justify-content-lg-end form-group">
                                                            <input id="<?= $filterProp['ID'] ?>2"  data-id_prop="<?= $filterProp['CODE'] ?>" class="form-control" type="number" placeholder="" required="" value="<?=$arProps[$filterProp['CODE']]['VALUE']?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-2">
                                                        <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                                            :<?=$filterProp['NAME']?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?}
                                        }?>
                                    <? }?>
                                    <? foreach ($filterProps[3] as $filterProp) {?>
                                        <?
                                        $pattern = '/ID(\d+)/';
                                        preg_match_all($pattern, $filterProp['CODE'], $matches);
                                        $id = $matches[1];
                                        $id = array_reverse($id);
                                        ?>
                                        <?sort($filterProp['PROP_ENUM_VAL'])?>
                                        <?if($filterProp['PROPERTY_TYPE'] == 'L'){?>
                                            <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row" data-parent-id="29" style="display: none">
                                                <div class="col-12 col-lg-10">
                                                    <div class="d-flex justify-content-center justify-content-lg-end align-items-center">
                                                        <?if ($id){foreach ($id as $ids){drawElement($filterProps[1][$ids] , $arLink ,$arProps);}}?>
                                                        <?foreach($filterProp['PROP_ENUM_VAL']  as $arItem){?>

                                                            <div class="mr-3 form_radio_btn">
                                                                <input id="radio-<?= $arItem['ID'] ?>3" type="radio" name="<?=$filterProp['CODE']?>3"
                                                                    <?=($arProps[$filterProp['CODE']]['VALUE'] == $arItem['VALUE'])? 'checked' : ''?>
                                                                       data-id_prop="<?= $arItem['PROPERTY_ID'] ?>"
                                                                       data-id-self="<?= $arItem['ID'] ?>">
                                                                <label for="radio-<?= $arItem['ID'] ?>3"><?=$arItem['VALUE']?></label>
                                                            </div>
                                                        <?}?>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-2">
                                                    <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                                        :<?=$filterProp['NAME']?>
                                                    </p>
                                                </div>
                                            </div>
                                        <? }else{?>
                                            <?if($filterProp['ID'] == 174){?>
                                                <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row" data-parent-id="29" style="display: none">
                                                    <div class="col-12 col-lg-10">
                                                        <div class="d-flex flex-wrap justify-content-center justify-content-lg-end">
                                                            <div class="mr-0 mr-lg-3 form-group">
                                                                <input id="1723"  data-id_prop="172" class="form-control" type="text" placeholder="Kitchen" required="" value="<?=$arProps['PROP_AREA_1']['VALUE']?>">
                                                            </div>

                                                            <div class="mr-0 mr-lg-3 form-group">
                                                                <input id="1733"  data-id_prop="173" class="form-control" type="text" placeholder="Residential" required="" value="<?=$arProps['PROP_AREA_2']['VALUE']?>">
                                                            </div>

                                                            <div class="mr-3 form-group">
                                                                <input id="1743"  data-id_prop="174" class="form-control" type="text" placeholder="General" required="" value="<?=$arProps['PROP_AREA_3']['VALUE']?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-2">
                                                        <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                                            :<?=$filterProp['NAME']?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?}else{?>
                                                <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row" data-parent-id="29" style="display: none">
                                                    <div class="col-12 col-lg-10">
                                                        <?if ($id){foreach ($id as $ids){drawElement($filterProps[3][$ids] , $arLink ,$arProps);}}?>
                                                        <div class="mr-3 d-flex justify-content-center justify-content-lg-end form-group">
                                                            <input id="<?= $filterProp['ID'] ?>3"  data-id_prop="<?= $filterProp['CODE'] ?>" class="form-control" type="number" placeholder="" required="" value="<?=$arProps[$filterProp['CODE']]['VALUE']?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-2">
                                                        <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                                            :<?=$filterProp['NAME']?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?}?>
                                        <?}?>
                                    <? }?>
                                    <div class="mb-3 mb-lg-4 row flex-column-reverse flex-lg-row">
                                        <div class="d-flex justify-content-center justify-content-lg-end form-group col-12 col-lg-10">
                                            <input id="PROP_Completion" class="form-control"  data-id_prop="113"
                                                   type="date"
                                                   placeholder="<?=$arProps['PROP_Completion']['NAME']?>"
                                                   required>
                                        </div>
                                        <div class="col-12 col-lg-2">
                                            <p class="mb-3 m-lg-0 d-flex justify-content-center justify-content-lg-start font-weight-bold">
                                                :<?=$arProps['PROP_Completion']['NAME']?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-5 d-flex flex-column">
                                        <p class="pt-0 text-right text-before-ta">
                                            <?
                                            $dir = $APPLICATION->GetCurDir();
                                            $dirName = str_replace('/', '', $dir); // PHP код
                                            $APPLICATION->IncludeComponent(
                                                "bitrix:main.include",
                                                "",
                                                Array(
                                                    "AREA_FILE_SHOW" => "file",
                                                    "PATH" => "/include-area/".mb_strtolower($dirName)."-p5-ru.php",
                                                    "EDIT_TEMPLATE" => ""
                                                )
                                            );
                                            // символы для удаления


                                            ?>
                                        </p>

                                        <textarea class="w-100 p-3 pt-2 border rounded" placeholder="תיאור" name="discriptions" id="text-discriptions" rows="4"><?=$arFields['PREVIEW_TEXT']?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-content" data-wizard-content="3">
                                <div class="property-step-price">
                                    <p class="mb-4 h2 text-center text-uppercase font-weight-bolder auto-step2__title"><?=Loc::getMessage('rent-terms');?></p>

                                    <div class="d-flex flex-wrap justify-content-end justify-content-lg-center gap-1">
                                        <?foreach ($restrictions['PROP_ENUM_VAL'] as $arItem){?>
                                            <div class="mr-2 mb-2 mr-md-4 mb-md-4 form_radio_btn">
                                                <input id="checkbox-<?=$arItem['XML_ID']?>" type="checkbox" name="<?=$arItem['VALUE']?>"
                                                       data-id_prop="<?= $arItem['PROPERTY_ID'] ?>"
                                                    <?=(in_array($arItem['VALUE'], $arProps['PROP_restrictions']['VALUE']))? 'checked' : ''?>
                                                       data-id-self="<?= $arItem['ID'] ?>">
                                                <label for="checkbox-<?=$arItem['XML_ID']?>"><?=Loc::getMessage($arItem['XML_ID'])?></label>
                                            </div>
                                        <?}?>
                                    </div>

                                    <p class="mb-4 h2 text-center text-uppercase font-weight-bolder auto-step2__title"><?=Loc::getMessage('rent-price');?></p>

                                    <p class="mb-4 text-center"> <?
                                        $dir = $APPLICATION->GetCurDir();
                                        $dirName = str_replace('/', '', $dir); // PHP код
                                        $APPLICATION->IncludeComponent(
                                            "bitrix:main.include",
                                            "",
                                            Array(
                                                "AREA_FILE_SHOW" => "file",
                                                "PATH" => "/include-area/".mb_strtolower($dirName)."-p4-ru.php",
                                                "EDIT_TEMPLATE" => ""
                                            )
                                        ); ?>
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
                                                       data-id_prop="238"
                                                    <?= ($arProps['UF_SELLER_TYPE']['VALUE'] == "Agency") ? 'checked' : '' ?>
                                                       value="Agency" required>
                                                <label for="forAgency"><?=Loc::getMessage('Agency');?></label>
                                            </div>

                                            <div class="form_radio_btn">
                                                <input data-id-self="Owner" id="forOwner" type="radio"
                                                       data-id_prop="238"
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
                                                <input data-req="Y" data-id-self="phone1" id="phone1" class="form-control" value="<?=$arProps['UF_PHONE_1']['VALUE']?>"
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
                                                    <input  <?= ($arProps["UF_CALL_ANYTIME"]['VALUE'] > 0) ? 'checked' : '' ?> id="anytime" type="checkbox" name="anytime" value="anytime" data-id_prop="UF_CALL_ANYTIME" data-id-self="1">
                                                    <label class="mr-3 mb-0" for="anytime"><?=Loc::getMessage('Anytime');?></label>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-7">
                                                <div class="row">
                                                    <div class="col">
                                                        <select id="callTo" class="selectpicker"
                                                                data-style-base="form-control form-control-select"
                                                                data-style="">
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '00:00') ? 'selected' : '' ?>
                                                                    value="00"><?= Loc::getMessage('to'); ?>
                                                                <span>00:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '01:00') ? 'selected' : '' ?>
                                                                    value="01"><?= Loc::getMessage('to'); ?>
                                                                <span>01:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '02:00') ? 'selected' : '' ?>
                                                                    value="02"><?= Loc::getMessage('to'); ?>
                                                                <span>02:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '03:00') ? 'selected' : '' ?>
                                                                    value="03"><?= Loc::getMessage('to'); ?>
                                                                <span>03:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '04:00') ? 'selected' : '' ?>
                                                                    value="04"><?= Loc::getMessage('to'); ?>
                                                                <span>04:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '05:00') ? 'selected' : '' ?>
                                                                    value="05"><?= Loc::getMessage('to'); ?>
                                                                <span>05:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '06:00') ? 'selected' : '' ?>
                                                                    value="06"><?= Loc::getMessage('to'); ?>
                                                                <span>06:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '07:00') ? 'selected' : '' ?>
                                                                    value="07"><?= Loc::getMessage('to'); ?>
                                                                <span>07:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '08:00') ? 'selected' : '' ?>
                                                                    value="08"><?= Loc::getMessage('to'); ?>
                                                                <span>08:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '09:00') ? 'selected' : '' ?>
                                                                    value="09"><?= Loc::getMessage('to'); ?>
                                                                <span>09:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '10:00') ? 'selected' : '' ?>
                                                                    value="10"><?= Loc::getMessage('to'); ?>
                                                                <span>10:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '11:00') ? 'selected' : '' ?>
                                                                    value="11"><?= Loc::getMessage('to'); ?>
                                                                <span>11:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '12:00') ? 'selected' : '' ?>
                                                                    value="12"><?= Loc::getMessage('to'); ?>
                                                                <span>12:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '13:00') ? 'selected' : '' ?>
                                                                    value="13"><?= Loc::getMessage('to'); ?>
                                                                <span>13:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '14:00') ? 'selected' : '' ?>
                                                                    value="14"><?= Loc::getMessage('to'); ?>
                                                                <span>14:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '15:00') ? 'selected' : '' ?>
                                                                    value="15"><?= Loc::getMessage('to'); ?>
                                                                <span>15:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '16:00') ? 'selected' : '' ?>
                                                                    value="16"><?= Loc::getMessage('to'); ?>
                                                                <span>16:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '17:00') ? 'selected' : '' ?>
                                                                    value="17"><?= Loc::getMessage('to'); ?>
                                                                <span>17:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '18:00') ? 'selected' : '' ?>
                                                                    value="18"><?= Loc::getMessage('to'); ?>
                                                                <span>18:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '19:00') ? 'selected' : '' ?>
                                                                    value="19"><?= Loc::getMessage('to'); ?>
                                                                <span>19:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '20:00') ? 'selected' : '' ?>
                                                                    value="20"><?= Loc::getMessage('to'); ?>
                                                                <span>20:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '21:00') ? 'selected' : '' ?>
                                                                    value="21"><?= Loc::getMessage('to'); ?>
                                                                <span>21:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '22:00') ? 'selected' : '' ?>
                                                                    value="22"><?= Loc::getMessage('to'); ?>
                                                                <span>22:00</span></option>
                                                            <option <?= ($arProps['UF_CALL_TO']['VALUE'] == '23:00') ? 'selected' : '' ?>
                                                                    value="23"><?= Loc::getMessage('to'); ?>
                                                                <span>23:00</span></option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <select id="callFrom" class="selectpicker"
                                                                data-style-base="form-control form-control-select"
                                                                data-style="">
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '00:00') ? 'selected' : '' ?>
                                                                    value="00"><?= Loc::getMessage('from'); ?> <span>00:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '01:00') ? 'selected' : '' ?>
                                                                    value="01"><?= Loc::getMessage('from'); ?> <span>01:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '02:00') ? 'selected' : '' ?>
                                                                    value="02"><?= Loc::getMessage('from'); ?> <span>02:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '03:00') ? 'selected' : '' ?>
                                                                    value="03"><?= Loc::getMessage('from'); ?> <span>03:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '04:00') ? 'selected' : '' ?>
                                                                    value="04"><?= Loc::getMessage('from'); ?> <span>04:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '05:00') ? 'selected' : '' ?>
                                                                    value="05"><?= Loc::getMessage('from'); ?> <span>05:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '06:00') ? 'selected' : '' ?>
                                                                    value="06"><?= Loc::getMessage('from'); ?> <span>06:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '07:00') ? 'selected' : '' ?>
                                                                    value="07"><?= Loc::getMessage('from'); ?> <span>07:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '08:00') ? 'selected' : '' ?>
                                                                    value="08"><?= Loc::getMessage('from'); ?> <span>08:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '09:00') ? 'selected' : '' ?>
                                                                    value="09"><?= Loc::getMessage('from'); ?> <span>09:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '10:00') ? 'selected' : '' ?>
                                                                    value="10"><?= Loc::getMessage('from'); ?> <span>10:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '11:00') ? 'selected' : '' ?>
                                                                    value="11"><?= Loc::getMessage('from'); ?> <span>11:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '12:00') ? 'selected' : '' ?>
                                                                    value="12"><?= Loc::getMessage('from'); ?> <span>12:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '13:00') ? 'selected' : '' ?>
                                                                    value="13"><?= Loc::getMessage('from'); ?> <span>13:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '14:00') ? 'selected' : '' ?>
                                                                    value="14"><?= Loc::getMessage('from'); ?> <span>14:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '15:00') ? 'selected' : '' ?>
                                                                    value="15"><?= Loc::getMessage('from'); ?> <span>15:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '16:00') ? 'selected' : '' ?>
                                                                    value="16"><?= Loc::getMessage('from'); ?> <span>16:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '17:00') ? 'selected' : '' ?>
                                                                    value="17"><?= Loc::getMessage('from'); ?> <span>17:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '18:00') ? 'selected' : '' ?>
                                                                    value="18"><?= Loc::getMessage('from'); ?> <span>18:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '19:00') ? 'selected' : '' ?>
                                                                    value="19"><?= Loc::getMessage('from'); ?> <span>19:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '20:00') ? 'selected' : '' ?>
                                                                    value="20"><?= Loc::getMessage('from'); ?> <span>20:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '21:00') ? 'selected' : '' ?>
                                                                    value="21"><?= Loc::getMessage('from'); ?> <span>21:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '22:00') ? 'selected' : '' ?>
                                                                    value="22"><?= Loc::getMessage('from'); ?> <span>22:00</span>
                                                            </option>
                                                            <option <?= ($arProps['UF_CALL_FROM']['VALUE'] == '23:00') ? 'selected' : '' ?>
                                                                    value="23"><?= Loc::getMessage('from'); ?> <span>23:00</span>
                                                            </option>
                                                        </select>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-2 d-flex justify-content-end align-items-center">
                                                <p class="text-right mb-3 mb-lg-0 font-weight-bold"><?=Loc::getMessage('Call:');?> </p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="propert-sell-main__step-control">
                            <button onclick="submitForm(event)" class="btn btn-primary wizard-control-final active">
                                <span><?=Loc::getMessage('Submit your ad');?></span>
                            </button>

                            <!-- <button class="btn wizard-control-final">
                              <span>Preview</span>
                            </button> -->

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
    </div>

    <script>
        /*$('#Legalname').hide();*/
        $('#forAgency').click(function () {
            $('#Legalname').show();
        })
        $('#forOwner').click(function () {
            $('#Legalname').hide();
        })
        $('.wizard-control-final').removeClass('active');
        $('wizard-control-next').click(function () {
            let currentUrl = window.location.href;
            let isEdit = currentUrl.indexOf("EDIT=Y") !== -1;
            if (!isEdit) {
                setTimeout(() => $('.wizard-control-final').removeClass('active'), 500);
            }
        })
        $('.property-step-contact').click(function () {
            let selectedSellerTypeAgency = $('#forAutohouse').is(':checked')
            let selectedSellerTypeOwner = $('#forOwner').is(':checked')
            if (selectedSellerTypeOwner) {
                $('#Legalname').hide();
                $('#Legalname').attr('data-req', 'N');
            } else {
                $('#Legalname').show();
                $('#Legalname').attr('data-req', 'Y');
            }

            let errors = 0;
            let errorsDiv = 0;
            let skip = false;
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
            $(this).find('select').each(function () {
                let selectData = $(this).data()
                if (selectData.req === 'Y' && $(this).val() == '') {
                    errors++;
                    $(this).css('border-block-color', 'red')
                }
            });


            if (errors < 1) {
                $('.wizard-control-final').addClass('active');
                if (errorsDiv < 1) {
                    $('.wizard-control-final').addClass('active');
                } else {
                    $('.wizard-control-final').removeClass('active');
                }
            } else {
                $('.wizard-control-final').removeClass('active');
            }
        })
        if (window.location.href.indexOf("EDIT") > -1) {

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
                    }

                    checkFinalFields();
                });
            });

            $('.property-step-contact input[data-req="Y"].form-control').each(function () {
                $(this).on("keyup", () => {
                    checkFinalFields();
                });
            });
        });



        let flagPhoto = true;
        function addActivePhoto(item){
            if(item !== undefined){
                let mainText = document.querySelectorAll(".set-main-text");

                mainText.forEach((el)=>{
                    el.innerText = "<?=Loc::getMessage('setPhotoMain')?>";
                    el.closest(".main-photo__item").querySelector(".rotate-img").removeAttribute("data-activePhoto");
                })
                item.closest(".main-photo__item").querySelector(".rotate-img").setAttribute("data-activePhoto", "isActive");

                item.innerText = "<?=Loc::getMessage('photoMain')?>";
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
        function rotateThis(item) {
            let count_rotate = $(item).parents('.main-photo__item').find('img').attr('data-rotate');
            console.log($(item).parents('.main-photo__item').find('img').attr('data-rotate'))
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
            var $data = {};
            $('#mainForm').find('input').each(function () {
                if (this.checked) {
                    var display = $(this).parents('.flex-lg-row');
                    console.log(display.css('display'))
                    if (display.css('display') === 'none'){
                    }else {
                        var object = {}
                        object.val = this.checked;
                        object.data = $(this).data();
                        $data[this.id] = object

                    }

                } else {
                    var display = $(this).parents('.flex-lg-row');
                    console.log(display.css('display'))
                    if (display.css('display') === 'none'){
                    }else {
                        var object = {}
                        object.val = $(this).val();
                        object.data = $(this).data();
                        $data[this.id] = object;

                    }
                }
            });
            $('#mainForm').find('select').each(function () {
                // console.log($(this));
                $data[this.id] = $(this).val();
            });
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
            <?if($_GET['EDIT'] == 'Y'){?>
            $data['EDIT'] = 'Y';
            $data['EDIT_ID'] = '<?=$_GET['ID']?>'
            <?}?>
            $data['itemDescription'] = $('#text-discriptions').val();
            $data['section_id'] = $('.activeSection').data();
            //get marker data from localStorage
            $data['section_id'] = $('.activeSection').data();
            $data['PROP_Completion'] = $('#PROP_Completion').val()
            var map = localStorage.getItem('markerData');
            var locationPosition = localStorage.getItem('locationDataPosition');
            var locationLatLng = localStorage.getItem('locationDataLatLng');
            var dataForAjax = '';
            var dataForAjax2 = '';
            var mapResult = JSON.parse(map);
            mapResult.forEach(function(item, i, mapResult) {
                console.log(item)
                if(item.sourceLayer == "abu_gosh"){
                    dataForAjax = item.properties.MUN_ENG;
                }else{
                    if(item.sourceLayer !="building" && item.sourceLayer !="road"){
                        if(item.properties.MUN_HE != undefined) {
                            dataForAjax2 = item.properties.MUN_HE;
                        }
                    }
                }
            });
            if(dataForAjax == ''){
                alert('empty location')
                return false;
            }
            $data['UF_NAME'] = $('#Legalname').val();
            $data['MAP_LATLNG'] = locationLatLng;
            $data['MAP_POSITION'] = locationPosition;
            $data['MAP_LAYOUT']= dataForAjax;
            $data['MAP_LAYOUT_BIG']= dataForAjax2;
            //!!get marker data from localStorage
            console.log($data)
            var deferred = $.ajax({
                type: "POST",
                url: "/ajax/add_rent.php",
                data: $data,
                dataType: 'json'
            });
            deferred.done(function (data) {
                $('.preloader').css({"z-index": "0", "opacity": "100", "position": "fixed"});
                console.log(data)
                if (data.success == 1) {
                    window.location.href = '/personal/'
                } else {
                    $('.pop-up').addClass('active');
                    $('.pop-up__text').html(data.responseBitrix)
                }
            });
        }
        $('.property-step-contact').click(function () {
            let selectedSellerTypeAgency = $('#forAutohouse').is(':checked')
            let selectedSellerTypeOwner = $('#forOwner').is(':checked')
            if (selectedSellerTypeOwner) {
                $('#Legalname').hide();
                $('#Legalname').attr('data-req', 'N');
            } else {
                $('#Legalname').show();
                $('#Legalname').attr('data-req', 'Y');
            }

            let errors = 0;
            let errorsDiv = 0;
            let skip = false;
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
            $(this).find('select').each(function () {
                let selectData = $(this).data()
                if (selectData.req === 'Y' && $(this).val() == '') {
                    errors++;
                    $(this).css('border-block-color', 'red')
                }
            });


            if (errors < 1) {
                $('.wizard-control-final').addClass('active');
                if (errorsDiv < 1) {
                    $('.wizard-control-final').addClass('active');
                } else {
                    $('.wizard-control-final').removeClass('active');
                }
            } else {
                $('.wizard-control-final').removeClass('active');
            }
        })
        $('.wizard-control-final').removeClass('active');
        $('wizard-control-next').click(function () {
            let currentUrl = window.location.href;
            let isEdit = currentUrl.indexOf("EDIT=Y") !== -1;
            if (!isEdit) {
                setTimeout(() => $('.wizard-control-final').removeClass('active'), 500);
            }
        })

    </script>
    <style>
        .activeSection {
            color: #3fb465 !important;
        }

    </style>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
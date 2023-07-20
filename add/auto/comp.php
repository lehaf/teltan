<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Добавить объявление");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
global $arSetting;

// Если нет номера телефона, то редиректим на форму с его добавлением
$userPhone = getUserInfoByID()['PERSONAL_PHONE'];
if (CModule::IncludeModule("iblock"))
    $IBLOCK_ID = 3;
$properties = CIBlockProperty::GetList(array("sort" => "asc", "name" => "asc"), array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID));
$prop_fields = [];
while ($prop_fiel = $properties->GetNext()) { ?>

    <?php
    $prop_field[$prop_fiel["ID"]] = $prop_fiel;
    $prop_fields[] = $prop_fiel;
}

if (!$userPhone)
    LocalRedirect($GLOBALS['arSetting'][SITE_ID]['href'] . 'personal/edit/');

if ($_GET['EDIT'] == 'Y' && $_GET['ID']) {
    $arSelect = array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_*", "PREVIEW_TEXT", "PREVIEW_PICTURE");
    $arFilter = array("IBLOCK_ID" => $IBLOCK_ID, 'ID' => $_GET['ID'], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        // pr($arFields);
        $arProps = $ob->GetProperties();
        // pr($arProps);
    }
}
$arLink = CIBlockSectionPropertyLink::GetArray($IBLOCK_ID, 80);

?>

<? /*?> <div class="container">
        <h2 class="d-block mb-4 subtitle">
            <?$APPLICATION->ShowTitle();?>
        </h2>

        <div class="p-4 card user-add-item">
            <form name="add_ad">
                <?=bitrix_sessid_post()?>
                <input type="hidden" name="section_id" value="">
                <input type="hidden" name="c_country" value="">
                <input type="hidden" name="c_city" value="">
                <h2 class="mb-4 d-flex justify-content-center align-items-center section-title">Описание</h2>

                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "sections_menu_add",
                    Array(
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
                        "SECTION_FIELDS" => array("", ""),
                        "SECTION_ID" => $_REQUEST["SECTION_ID"],
                        "SECTION_URL" => "",
                        "SECTION_USER_FIELDS" => array("", ""),
                        "SHOW_PARENT_NAME" => "Y",
                        "TOP_DEPTH" => "2",
                        "VIEW_MODE" => "LINE"
                    )
                );?>




                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10">
                        <input type="text" class="form-control" name="itemTitle" placeholder="Enter Title" id="itemTitle">
                    </div>
                    <label for="itemTitle" class="col col-lg-2 label-name">Название</label>
                </div>

                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10">
                        <textarea type="text" placeholder="Enter Description" name="itemDescription" class="form-control" id="itemDescription" rows="4"></textarea>
                    </div>
                    <label for="itemDescription" class="col col-lg-2 label-name">Описание</label>
                </div>

                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10">
                        <input type="text" placeholder="Enter Short Description" name="itemShortDescription" class="form-control" id="itemShortDescription">
                    </div>
                    <label for="itemShortDescription" class="col col-lg-2 label-name">Краткое описание</label>
                </div>

                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10">
                        <input type="text" placeholder="Enter Price" name="itemPrice" class="form-control" id="itemPrice">
                    </div>
                    <label for="itemPrice" class="col col-lg-2 label-name">Цена</label>
                </div>

                <?
                // Получаем список стран и городов

                $countries = getCountriesHL();
                $cities = getCitiesHL();
                $arr_city =array();

                foreach($cities as $city)
                {
                    $arr_city['c_'.$countries[$city['UF_ID_COUNTRY']]['ID']][] = $city['UF_NAME_'.strtoupper($arSetting[SITE_ID]['lang'])];
                }

                //print_r($arr_city);

                ?>
                <script>
                    const placesList = <?=json_encode($arr_city, JSON_UNESCAPED_UNICODE)?>;
                </script>

                <div class="form-group row flex-column-reverse flex-lg-row">
                    <div class="col col-lg-10 d-flex justify-content-end">
                        <div class="dependens-dropdon">
                            <div class="dependens-dropdon-block">
                                <button type="button" class="dep-select first-drop">Страна</button>

                                <ul class="show-country">
                                    <?foreach($countries as $item){?>
                                        <li>
                                            <label>
                                                <input name="country" value="<?='c_'.$item['ID'];?>" type="radio" />
                                                <?=$item['UF_NAME_'.strtoupper($arSetting[SITE_ID]['lang'])]?>
                                            </label>
                                        </li>
                                    <?}?>
                                </ul>
                            </div>

                            <div class="dependens-dropdon-block">
                                <button type="button" class="dep-select second-drop">Город</button>

                                <ul class="show-city">
                                    <li><label for="city"><input name="city" value="" type="radio">Select country</label></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <label for="userSelectSection" class="col col-lg-2 label-name">
                        Sity / <br>
                        Region
                    </label>
                </div>

                <div class="section_props_user">
                    <h2 class="mb-4 d-flex justify-content-center align-items-center section-title">Фото товара</h2>

                    <div class="mb-5 row">
                        <div class="col">
                            <div class="step-photos">
                                <div id="fileUploaderRenderContainer" class="mb-3 mb-lg-5 row row-cols-2 row-cols-lg-4 row-cols-xl-5 flex-row-reverse">
                                    <input id="fileUploaderFiles" class="d-none" type="file" name="files[]" multiple>

                                    <div class="col">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <label for="fileUploaderFiles" class="mb-0 label-add-photo">
                                                <p class="mb-2"><i class="icon-camera-1"></i></p>
                                                <p class="mb-0 label-add-photo__text ">Add photo</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none d-lg-flex  col-2">
                            <p class="label-name">Add Photo</p>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
<?*/ ?>
    <div class="container">
        <div class="preloader">
            <div class="preloader__row">
                <div class="preloader__item"></div>
                <div class="preloader__item"></div>
            </div>
        </div>
        <h2 class="mb-5 d-flex justify-content-end subtitle">
            <?= Loc::getMessage('submit your ad'); ?>
        </h2>

        <div class="card">
            <div class="propert-sell-main">
                <div id="wizard">
                    <div>
                        <div class="d-flex justify-content-between border-bottom propert-sell-main__header">
                            <div class="d-flex step wizard-step" data-wizard-step="6">
                                <div class="pr-2 pr-md-4 d-flex flex-column text-right">
                                    <span class="step__title"><?= Loc::getMessage('Step5'); ?></span>
                                    <span class="step__subtitle"><?= Loc::getMessage('Contacts'); ?></span>
                                </div>

                                <div class="d-flex justify-content-center align-items-center step__icone">
                                    <i class="icon-invitation"></i>
                                </div>
                            </div>

                            <div class="d-flex step wizard-step" data-wizard-step="5">
                                <div class="pr-2 pr-md-4 d-flex flex-column text-right">
                                    <span class="step__title"><?= Loc::getMessage('Step4'); ?></span>
                                    <span class="step__subtitle"><?= Loc::getMessage('Terms of sale'); ?></span>
                                </div>

                                <div class="d-flex justify-content-center align-items-center step__icone">
                                    <i class="icon-information"></i>
                                </div>
                            </div>

                            <div class="d-flex step wizard-step" data-wizard-step="4">
                                <div class="pr-2 pr-md-4 d-flex flex-column text-right">
                                    <span class="step__title"><?= Loc::getMessage('Step3'); ?></span>
                                    <span class="step__subtitle"><?= Loc::getMessage('Detailed description'); ?></span>
                                </div>

                                <div class="d-flex justify-content-center align-items-center step__icone">
                                    <i class="icon-job-seeking"></i>
                                </div>
                            </div>

                            <div class="d-flex step wizard-step" data-wizard-step="1">
                                <div class="pr-2 pr-md-4 d-flex flex-column text-right">
                                    <span class="step__title"><?= Loc::getMessage('Step2'); ?></span>
                                    <span class="step__subtitle"><?= Loc::getMessage('Apartment address'); ?></span>
                                </div>

                                <div class="d-flex justify-content-center align-items-center step__icone">
                                    <i class="icon-placeholder-1"></i>
                                </div>
                            </div>

                            <div class="d-flex step wizard-step" data-wizard-step="0">
                                <div class="pr-2 pr-md-4 d-flex flex-column text-right">
                                    <span class="step__title"><?= Loc::getMessage('Step1'); ?></span>
                                    <span class="step__subtitle"><?= Loc::getMessage('Uploading photos'); ?></span>
                                </div>

                                <div class="d-flex justify-content-center align-items-center step__icone">
                                    <i class="icon-camera-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="mainForm" action="/" onsubmit="submitForm(event)">
                        <div>
                            <!-- Добавление фото -->
                            <div class="wizard-content" data-wizard-content="0">
                                <div class="d-flex flex-column step-one step-photos">
                                    <h2 class="step-one__title"><?= Loc::getMessage('What to photograph?'); ?></h2>

                                    <p class="step-one__text"><?= Loc::getMessage('Add photos - this'); ?></p>

                                    <div class="row row-cols-3 row-cols-lg-5 step-one__icons-line">
                                        <div class="col order-1 order-lg-1">
                                            <span class="icon"><img src="../../img/auto1.png" alt=""></span>
                                            <p class="mb-0"><?= Loc::getMessage('Front'); ?></p>
                                        </div>

                                        <div class="col order-2 order-lg-1">
                                            <span class="icon"><img src="../../img/auto2.png" alt=""></span>
                                            <p class="mb-0"><?= Loc::getMessage('Back'); ?> </p>
                                        </div>

                                        <div class="col-6 col-sm order-4 order-lg-1">
                                            <span class="icon"><img src="../../img/auto3.png" alt=""></span>
                                            <p class="mb-0"><?= Loc::getMessage('Side view'); ?></p>
                                        </div>

                                        <div class="col-6 col-sm order-5 order-lg-1">
                                            <span class="icon"><img src="../../img/auto4.png" alt=""></span>
                                            <p class="mb-0"><?= Loc::getMessage('Side view'); ?></p>
                                        </div>

                                        <div class="col order-3 order-lg-1">
                                            <span class="icon"><i class="icon-steering"></i></span>
                                            <p class="mb-0"><?= Loc::getMessage('Interior'); ?></p>
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
                                                            Main
                                                        </div>
                                                    </label>

                                                    <div class="d-flex justify-content-around">
                                                        <div class="mr-3 d-flex justify-content-center align-items-center element-control"
                                                             data-file-remove-id="<?= $arFields['PREVIEW_PICTURE'] ?>Снимок.PNG">
                                                            <i class="mr-2 icon-clear"></i>
                                                            <span class="d-none d-lg-inline-block">Delete</span>
                                                        </div>

                                                        <div class="d-flex justify-content-center align-items-center element-control rotate-control">
                                                            <input type="hidden"
                                                                   name="rotate[<?= $arFields['PREVIEW_PICTURE'] ?>Снимок.PNG]"
                                                                   value="0">
                                                            <i onclick="rotateThis(this)" class="mr-2 icon-replay"></i>
                                                            <span onclick="rotateThis(this)"
                                                                  class="d-none d-lg-inline-block">Rotate</span>
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
                                                                 class="set-main-text">Set as main
                                                            </div>
                                                        </label>

                                                        <div class="d-flex justify-content-around">
                                                            <div class="mr-3 d-flex justify-content-center align-items-center element-control"
                                                                 data-file-remove-id="<?= $PHOTO ?>.PNG">
                                                                <i class="mr-2 icon-clear"></i>
                                                                <span class="d-none d-lg-inline-block">Delete</span>
                                                            </div>

                                                            <div class="d-flex justify-content-center align-items-center element-control rotate-control">
                                                                <input type="hidden" name="rotate[<?= $PHOTO ?>.PNG]"
                                                                       value="0">
                                                                <i onclick="rotateThis(this)"
                                                                   class="mr-2 icon-replay"></i>
                                                                <span onclick="rotateThis(this)"
                                                                      class="d-none d-lg-inline-block">Rotate</span>
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

                                    <p><?= Loc::getMessage('Ads are published only with photos'); ?></p>
                                </div>
                            </div>
                            <!-- /Добавление фото -->
                            <!-- Brand -->
                            <div class="wizard-content" data-wizard-content="1">
                                <div class="auto-step2">
                                    <h2 class="mb-4 text-center text-uppercase font-weight-bolder auto-step2__title">
                                        <?= Loc::getMessage('Choose a brand'); ?></h2>

                                    <div id="brandFilter">
                                        <div class="mb-4 d-flex justify-content-center align-items-center brand-filter">
                                            <div class="mr-3 form_radio_btn">
                                                <input id="popularCar" type="radio" name="category" value="popular">
                                                <label for="popularCar"><?= Loc::getMessage('Popular'); ?></label>
                                            </div>

                                            <div class="form_radio_btn">
                                                <input id="allCar" type="radio" name="category" value="" checked>
                                                <label for="allCar"><?= Loc::getMessage('All'); ?></label>
                                            </div>
                                        </div>

                                        <div class="mb-4 form-group">
                                            <input name="search" type="text" class="form-control"
                                                   placeholder="חפש מותג. למשל פולקסווגן">
                                        </div>
                                    </div>

                                    <div class="mb-4 mb-lg-5 row row-cols-lg-5 wrapper-brand-items div-req">
                                        <?
                                        $res = CIBlockSection::GetList(
                                            array('sort' => 'asc'),
                                            array('IBLOCK_ID' => '3', 'ACTIVE' => 'Y'),
                                            false,
                                            array('UF_*')
                                        );
                                        while ($row = $res->GetNext()) {
                                            if ($row['IBLOCK_SECTION_ID'] == null) {
                                                $arSections[$row['NAME']] = $row;
                                            }
                                            $rsParentSection = CIBlockSection::GetByID($row['ID']);
                                            if ($arParentSection = $rsParentSection->GetNext()) {
                                                $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'], '>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'], '<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'], '>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
                                                $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'), $arFilter);
                                                while ($arSect = $rsSect->GetNext()) {
                                                    $arSections[$row['NAME']]['SUB_SECTIONS'][$arSect['NAME']] = $arSect;
                                                    $arSubSections[$arSect['NAME'].$arSect['ID']] = $arSect;
                                                    $arSubSections[$arSect['NAME'].$arSect['ID']]['PARENT_SECTION'] = $row;

                                                }
                                            }
                                        }
                                        ps($arSubSections);
                                        ?>
                                        <? foreach ($arSections as $arSection) { ?>
                                            <div class="mb-3 mb-lg-4 col" data-filter-for="#brandFilter"
                                                 data-filter="<?= $arSection['CODE'] ?> <? if ($arSection['UF_POPULAR'] == 1) { ?>popular<? } ?>">
                                                <div class="form_radio_btn">
                                                    <input data-req="Y" type="radio" class="d-none"
                                                        <? if ($arSection['NAME'] == $arProps['PROP_BRAND']['VALUE']) {
                                                            $arToClick[] = $arSection['CODE'];
                                                        } ?>
                                                        <?= ($arSection['CODE'] == $arProps['PROP_BRAND']['VALUE']) ? 'checked' : '' ?>
                                                           data-id_prop="PROP_BRAND"
                                                           data-id-self="<?= $arSection['ID'] ?>"
                                                           value="<?= $arSection['ID'] ?>"
                                                           id="<?= $arSection['CODE'] ?>" name="brandFilter">
                                                    <label for="<?= $arSection['CODE'] ?>"
                                                           onclick="hideModelBrand('<?= $arSection['CODE'] ?>', this)"
                                                           class="m-0 d-flex justify-content-end align-items-center border auto-brand">
                                                        <span class="pl-2 mr-2 text-right"><?= $arSection['NAME'] ?></span>
                                                        <span><img src="<?= CFile::GetPath($arSection['DETAIL_PICTURE']); ?>"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="wizard-content" data-wizard-content="2">
                                <div class="auto-step2">
                                    <h2 class="mb-4 text-center text-uppercase font-weight-bolder auto-step2__title">
                                        <?= Loc::getMessage('Choose a brand'); ?></h2>

                                    <div id="nameFilter">
                                        <div class="mb-4 form-group">
                                            <input type="text" name="name" class="form-control"
                                                   placeholder="חפש מותג. למשל פולקסווגן">
                                        </div>
                                    </div>
                                    <div id="row-cols-lg-6" class="mb-4 additional mb-lg-5 row row-cols-lg-6 div-req">

                                        <? foreach ($arSubSections as $arItem) { ?>
                                            <? if ($arItem['CODE'] != '') { ?>
                                                <div id="<?= $arItem['CODE'] ?>" style="display: none"
                                                     class="mb-3 mb-lg-4 col"
                                                    <? if ($arItem['ID'] == $arFields['IBLOCK_SECTION_ID']) {
                                                        $arToClick[] = 'id' . $arItem['CODE'];
                                                    } ?>

                                                     data-parent-id="<?= $arItem['PARENT_SECTION']['CODE'] ?>"
                                                     data-filter-for="#nameFilter"
                                                     data-filter="<?= $arItem['NAME'] ?>">
                                                    <div class="form_radio_btn">
                                                        <input data-req="Y" data-id_prop="PROP_MODEL"
                                                            <?= ($arItem['ID'] == $arFields['IBLOCK_SECTION_ID']) ? 'checked' : '' ?>
                                                               value="<?= $arItem['ID'] ?>"
                                                               data-id-self="<?= $arItem['ID'] ?>" type="radio"
                                                               data-parent-id="<?= $arItem['PARENT_SECTION']['CODE'] ?>"
                                                               class="d-none" id="id<?= $arItem['CODE'] ?>"
                                                               name="chooseBrand">
                                                        <label for="id<?= $arItem['CODE'] ?>"
                                                               class="m-0 d-flex justify-content-end align-items-center border auto-brand">
                                                            <span class="pl-2 mr-2 text-right"><?= $arItem['NAME'] ?></span>
                                                            <span><img src="@@image" alt=""></span>
                                                        </label>
                                                    </div>

                                                </div>
                                            <? }
                                        } ?>


                                    </div>
                                </div>
                            </div>
                            <script>
                                function hideModelBrand(id, el) {
                                    element = $("#row-cols-lg-6").find(`[data-parent-id]`).hide();
                                    element = $("#row-cols-lg-6").find(`[data-parent-id='${id}']`).show();

                                }
                            </script>
                            <!-- /Brand -->
                            <div class="wizard-content" data-wizard-content="3">
                                <div class="auto-ad-step2-3">
                                    <h2 class="mb-4 text-center text-uppercase font-weight-bolder auto-step2__title">
                                        <?= Loc::getMessage('specifications'); ?></h2>
                                    <?
                                    CModule::IncludeModule('highloadblock');
                                    $entity_data_class = GetEntityDataClass(16);
                                    $rsData = $entity_data_class::getList(array(
                                        'select' => array('*')
                                    ));
                                    while ($elY[] = $rsData->fetch()) {
                                        //print_r($elY);
                                    }
                                    $elY = array_reverse($elY);
                                    ?>
                                    <div class="mb-4 row">
                                        <div class="col-12 col-lg-10">
                                            <div style="flex-direction: row-reverse;" id="dateRadioSelector"
                                                 class=" d-lg-flex justify-content-end align-items-center <?= ($prop_field[119]['IS_REQUIRED'] == 'Y') ? 'div-req' : '' ?>">
                                                <? $count = 0; ?>

                                                <? foreach ($elY

                                                as $item) { ?>
                                                <? if ($item['UF_NAME'] != ''){ ?>
                                                <? if ($count == 7) { ?>
                                                <select data-req="Y" class="mr-3 custom-select" id="dateSelectSelector"
                                                        name="Year of issue">
                                                    <option value="no-value">Older</option>
                                                    <? } ?>
                                                    <? if ($count >= 7) { ?>
                                                        <option <?= ($item['UF_NAME'] == $arProps['PROP_YAERH_Left']['VALUE']) ? 'selected' : '' ?>
                                                                value="<?= $item['UF_NAME'] ?>"><?= $item['UF_NAME'] ?></option>
                                                    <? } else { ?>
                                                        <div class="mr-3 form_radio_btn">
                                                            <input data-cc="dateRadioSelector"
                                                                   id="carYear<?= $item['UF_NAME'] ?>" type="radio"
                                                                <?= ($item['UF_NAME'] == $arProps['PROP_YAERH_Left']['VALUE']) ? 'checked' : '' ?>
                                                                   data-id-self="<?= $item['UF_NAME'] ?>"
                                                                   data-id_prop="PROP_YAERH_Left"
                                                                   name="Year of issue"
                                                            >
                                                            <label for="carYear<?= $item['UF_NAME'] ?>"><?= $item['UF_NAME'] ?></label>
                                                        </div>
                                                    <? } ?>
                                                    <? $count++; ?>
                                                    <? }
                                                    } ?>
                                                </select>

                                            </div>
                                            <!--
                                            <div class="d-flex d-lg-none">
                                                <select data-req="Y" class="selectpicker"
                                                        data-style-base="form-control form-control-select" data-style=""
                                                        name="Year of issue">

                                                    <option value="0"><? /*= Loc::getMessage('Year of issue'); */ ?></option>
                                                    <? /* foreach ($elY as $el) { */ ?>
                                                        <option value="<? /*= $el['UF_NAME'] */ ?>"><? /*= $el['UF_NAME'] */ ?></option>
                                                    <? /* } */ ?>
                                                </select>
                                            </div>-->
                                        </div>

                                        <div class=" d-lg-block col-2">
                                            <p class="m-0 font-weight-bold"><?= Loc::getMessage('Year of issue'); ?>  <?= ($prop_field[119]['IS_REQUIRED'] == 'Y') ? '*' : '' ?></p>
                                        </div>
                                    </div>


                                    <div class="mb-4 row">
                                        <div class="col-12 col-lg-10">
                                            <div class="mb-0 form-group">
                                                <input id="Modification" type="text" data-id_prop="120"
                                                       class="form-control" <?= ($arProps["PROP_MOD"]['VALUE']) ? 'value="' . $arProps["PROP_MOD"]['VALUE'] . '"' : '' ?>
                                                       placeholder="Modification (optional):">
                                            </div>
                                        </div>

                                        <div class=" d-lg-block col-2">
                                            <p class="m-0 font-weight-bold"><?= Loc::getMessage('Modification (optional):'); ?>
                                                </p>
                                        </div>
                                    </div>
                                    <?
                                    $entity_data_class = GetEntityDataClass(1);
                                    $rsData = $entity_data_class::getList(array(
                                        'order' => array('UF_NAME' => 'ASC'),
                                        'select' => array('*'),
                                        'filter' => array('!UF_NAME' => false)
                                    ));
                                    while ($elTipkuzova[] = $rsData->fetch()) {
                                        // print_r($elTipkuzova);
                                    }
                                    require($_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php");
                                    $detect = new Mobile_Detect;
                                    ?>
                                    <div class="mb-4 row">
                                        <div class="col-12 col-lg-10">
                                            <? if (!$detect->isMobile()) { ?>
                                                <div id="bodyTypesCar"
                                                     class="row row-cols-3 d-lg-flex flex-wrap flex-row-reverse justify-content-between body-type-car div-req <?= ($prop_field[3]['IS_REQUIRED'] == 'Y') ? 'div-req' : '' ?> ">
                                                    <? foreach ($elTipkuzova as $key => $arItem) { ?>
                                                        <? if ($arItem['UF_NAME'] != '') { ?>

                                                            <div class="col form_radio_btn mb-4 <?= ($key > ADD_AUTO_BODY_TYPES_SHOW_COUNT) ? 'show-additionally' : '' ?>">
                                                                <input data-id_prop="PROP_BODY_TYPE"
                                                                    <?= ($arProps["PROP_BODY_TYPE"]['VALUE'] == $arItem['UF_XML_ID']) ? 'checked' : '' ?>
                                                                       data-id-self="<?= $arItem['UF_XML_ID'] ?>"
                                                                       id="<?= $arItem['UF_XML_ID'] ?>" type="radio"
                                                                       name="Body type">
                                                                <label class="d-flex flex-column position-relative"
                                                                       for="<?= $arItem['UF_XML_ID'] ?>">
                                                        <span class="body-type-car__icon"><i
                                                                    class="<?= $arItem['UF_DESCRIPTION'] ?>"></i></span>
                                                                    <span class="body-type-car__name"><?= $arItem['UF_NAME'] ?></span>
                                                                </label>
                                                            </div>
                                                            <? if ($key == ADD_AUTO_BODY_TYPES_SHOW_COUNT && count($elTipkuzova) > ADD_AUTO_BODY_TYPES_SHOW_COUNT) { ?>
                                                                <div class="col" id="btnShowMoreBodyTypes">
                                                                    <a type="button"
                                                                       class="rounded border show-more-types">
                                                                        <span class="font-weight-bold">Show all</span>
                                                                    </a>
                                                                </div>
                                                                <?
                                                            } ?>
                                                        <? }
                                                    } ?>
                                                </div>
                                            <? } ?>

                                            <div class="d-flex desc-none">
                                                <select data-req="Y" class="selectpicker"
                                                        data-style-base="form-control form-control-select" data-style=""
                                                        name="Body type">
                                                    <? foreach ($elTipkuzova as $arItem) { ?>
                                                        <option data-id_prop="PROP_BODY_TYPE"
                                                                data-id-self="<?= $arItem['UF_XML_ID'] ?>"
                                                                value="<?= $arItem['UF_XML_ID'] ?>"><?= $arItem['UF_NAME'] ?></option>
                                                    <? } ?>
                                                    <option <?if(!$_GET['EDIT']){?>selected<?}?> value="Nothing selected"></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class=" d-lg-block col-2">
                                            <p class="m-0 font-weight-bold"><?= Loc::getMessage('Body type:'); ?>  <?= ($prop_field[3]['IS_REQUIRED'] == 'Y') ? '*' : '' ?></p>
                                        </div>
                                    </div>

                                    <div class="mb-4 row flex-column-reverse-d flex-lg-row select-w-100">
                                        <div class="col col-lg-10"><?

                                            $arProp = [];
                                            foreach ($prop_fields as $field) {
                                                $needle = 'ROP';
                                                $needle2 = '_S3';
                                                $pos = strripos($field['CODE'], $needle);
                                                $pos2 = strripos($field['CODE'], $needle2);

                                                if ($pos == 1 && $pos2 == null) {
                                                    if ($field['PROPERTY_TYPE'] == 'L') {
                                                        $db_enum_list = CIBlockProperty::GetPropertyEnum($field['ID'], array("sort" => "asc"), array("IBLOCK_ID" => 3, 'PROPERTY_ID' => $field['ID']));
                                                        while ($ar_enum_list[] = $db_enum_list->GetNext()) {
                                                            $field['PROP_ENUM_VAL'] = $ar_enum_list;

                                                        }

                                                        // print_r($ar_enum_list);
                                                    }
                                                    $ar_enum_list = [];
                                                    $arProp[$field['ID']] = $field;
                                                }
                                            }
                                            $entity_data_class = GetEntityDataClass(13);
                                            $rsData = $entity_data_class::getList(array(
                                                'order' => array('UF_NAME' => 'ASC'),
                                                'select' => array('*'),
                                                'filter' => array('!UF_NAME' => false)
                                            ));
                                            while ($elCol[] = $rsData->fetch()) {
                                                //print_r($el);
                                            } ?>
                                            <div class="mr-2 mr-lg-3 d-flex flex-wrap auto-ad-step3__colors div-req"
                                                 style="justify-content: end !important;">
                                                <? foreach ($elCol as $color) {
                                                    if ($color['UF_XML_ID'] != null) {
                                                        ?>
                                                        <input data-req="Y" type="radio" data-id_prop="PROP_COLOR_Left"
                                                            <?= ($arProps["PROP_COLOR_Left"]['VALUE'] == $color['UF_XML_ID']) ? 'checked' : '' ?>
                                                               data-id-self="<?= $color['UF_XML_ID'] ?>" class="d-none"
                                                               name="color" id="<?= $color['UF_NAME'] ?>">
                                                        <label class="colour-element" for="<?= $color['UF_NAME'] ?>"
                                                               style="background: #<?= $color['UF_XML_ID'] ?>;"></label>
                                                    <? }
                                                } ?>
                                            </div>
                                        </div>

                                        <div class="col-2  d-lg-block">
                                            <p class="m-0 font-weight-bold"><?= Loc::getMessage('Colour:'); ?> *</p>
                                        </div>
                                    </div>
                                    <? foreach ($arProp as $arItem) { ?>
                                        <?
                                        $pattern = '/ID(\d+)/';
                                        preg_match_all($pattern, $arItem['CODE'], $matches);
                                         $id = $matches[1];
                                        $id = array_reverse($id);
                                        ?>
                                        <? if ($arItem['PROPERTY_TYPE'] == 'L' && $arItem['ID'] != 31 && $arItem['ID'] != 168) { ?>
                                            <? if ($arItem['MULTIPLE'] == 'Y' && $arItem['ID'] != 32 && $arItem['ID'] != 167) {
                                                ?>
                                                <div class="mb-4 row flex-column-reverse-d flex-lg-row select-w-100">
                                                    <div class="col col-lg-10">
                                                        <div  style="flex-wrap: wrap;" class="fl-right d-lg-flex <?= ($arItem['IS_REQUIRED'] == 'Y') ? 'div-req' : '' ?> justify-content-end">
                                                            <?if ($id){foreach ($id as $ids){drawElement($arProp[$ids] , $arLink ,$arProps);}}?>
                                                            <? foreach ($arItem['PROP_ENUM_VAL'] as $val) { ?>
                                                                <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                                                                    <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                           id="<?= $val['VALUE'] ?>" type="checkbox"
                                                                        <?= ($arProps[$arItem['CODE']]['VALUE'] == $val['VALUE']) ? 'checked' : '' ?>
                                                                        <? if (is_array($arProps[$arItem['CODE']]['VALUE'])) { ?>
                                                                            <?= (in_array($val['VALUE'], $arProps[$arItem['CODE']]['VALUE'])) ? 'checked' : '' ?>
                                                                        <? } ?>
                                                                           name="prop<?= $arItem['CODE'] ?>"
                                                                           data-id_prop="<?= $val['PROPERTY_ID'] ?>"
                                                                           data-id-self="<?= $val['ID'] ?>">
                                                                    <label for="<?= $val['VALUE'] ?>"><?= $val['VALUE'] ?> </label>
                                                                </div>
                                                                <?
                                                            } ?>
                                                            <? if ($arItem['ID'] == 44) { ?>
                                                                <div class=" d-lg-flex mr-2 mr-lg-3 mb-2 mb-lg-3 form-group">
                                                                    <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                           id="millage" class="w-125  form-control"
                                                                           value="<?= (int)$arProps['PROP_PROBEG_Left']['VALUE'] ?>"
                                                                           data-id_prop="43" type="number"
                                                                           placeholder="0"
                                                                           required>
                                                                </div>
                                                                <?
                                                            }
                                                            if ($arItem['ID'] == 123) { ?>
                                                                <div class=" d-lg-flex mr-2 mr-lg-3 mb-2 mb-lg-3 form-group">
                                                                    <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                           id="PROP_ENGIEN_NEW_Left"
                                                                           class="w-125 form-control"
                                                                           value="<?= (int)$arProps['PROP_ENGIEN_NEW_Left']['VALUE'] ?>"
                                                                           data-id_prop="124" type="number"
                                                                           placeholder="0"
                                                                    >
                                                                </div>
                                                            <? } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-2  d-lg-block">
                                                        <p class="m-0 font-weight-bold"><?= $arItem['NAME'] ?>
                                                            : <?= ($arItem['IS_REQUIRED'] == 'Y') ? '*' : '' ?></p>
                                                    </div>
                                                </div>
                                                <?
                                            } elseif ($arLink[$arItem['ID']]['DISPLAY_TYPE'] == 'P') { ?>
                                                <div class="mb-4 row flex-column-reverse flex-lg-row">
                                                    <div class="col col-lg-10">
                                                        <div class="d-flex justify-content-end">
                                                            <?if ($id){foreach ($id as $ids){drawElement($arProp[$ids] , $arLink ,$arProps);}}?>
                                                            <div class="dropdown bootstrap-select"><select
                                                                        class="selectpicker"
                                                                        data-style-base="form-control form-control-select"
                                                                        data-code_prop="<?= $arItem['CODE'] ?>"
                                                                        data-id_prop="<?= $arItem['ID'] ?>"
                                                                        data-style=""
                                                                        data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                        name="<?= $arItem['ID'] ?>"
                                                                        id="<?= $arItem['ID'] ?>"
                                                                        tabindex="-98">
                                                                    <? foreach ($arItem['PROP_ENUM_VAL'] as $enumProp) { ?>
                                                                        <option <?= ($arProps[$arItem['CODE']]['VALUE'] == $enumProp['VALUE'] ? 'selected' : '') ?>
                                                                                value="<?= $enumProp['ID'] ?>"><?= $enumProp['VALUE'] ?></option>
                                                                    <? } ?>
                                                                    <option <? if (!$_GET['EDIT']){ ?>selected<? } ?>
                                                                            value="Nothing selected"></option>
                                                                </select>

                                                                <div class="dropdown-menu ">
                                                                    <div class="inner show" role="listbox"
                                                                         id="bs-select-22" tabindex="-1">
                                                                        <ul class="dropdown-menu inner show"
                                                                            role="presentation">

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-2 d-lg-block">
                                                        <p class="mb-2 mb-lg-0 col col-lg-2 d-flex d-lg-block justify-content-end justify-content-lg-center"><p class="m-0 font-weight-bold"><?= $arItem['NAME'] ?></p> <?= ($arItem['IS_REQUIRED'] == 'Y') ? ' * ' : '' ?></p>
                                                    </div>
                                                </div>
                                            <? } else { ?>
                                                <div class="mb-4 row flex-column-reverse flex-lg-row select-w-100">

                                                    <div class="col col-lg-10">
                                                        <div  style="flex-wrap: wrap;" class="fl-right d-lg-flex  <?= ($arItem['IS_REQUIRED'] == 'Y') ? 'div-req' : '' ?>  justify-content-end">
                                                            <?if ($id){foreach ($id as $ids){drawElement($arProp[$ids] , $arLink ,$arProps);}}?>
                                                            <? foreach ($arItem['PROP_ENUM_VAL'] as $val) { ?>
                                                                <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                                                                    <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                           id="<?= $val['VALUE'] ?>" type="radio"
                                                                           name="<?= $val['PROPERTY_ID'] ?>"
                                                                        <?= ($arProps[$arItem['CODE']]['VALUE'] == $val['VALUE']) ? 'checked' : '' ?>
                                                                        <? if (is_array($arProps[$arItem['CODE']]['VALUE'])) { ?>
                                                                            <?= ($arProps[$arItem['CODE']]['VALUE'][0] == $val['VALUE']) ? 'checked' : '' ?>
                                                                        <? } ?>
                                                                           data-id_prop="<?= $val['PROPERTY_ID'] ?>"
                                                                           data-id-self="<?= $val['ID'] ?>">
                                                                    <label for="<?= $val['VALUE'] ?>"><?= $val['VALUE'] ?> <?= ($arItem['IS_REQUIRED'] == 'Y') ? '' : '' ?></label>
                                                                </div>
                                                                <?
                                                            } ?>
                                                            <? if ($arItem['ID'] == 32) { ?>
                                                                <div class="d-lg-flex mr-2 mr-lg-3 mb-2 mb-lg-3 form-group">
                                                                    <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                           id="PROP_PROBEG_Left" class=" form-control"
                                                                           value="<?= (int)$arProps['PROP_PROBEG_Left']['VALUE'] ?>"
                                                                           data-id_prop="31" type="text" placeholder="0"
                                                                           required>
                                                                </div>
                                                                <?
                                                            }
                                                            if ($arItem['ID'] == 167) { ?>
                                                                <div class="d-lg-flex mr-2 mr-lg-3 mb-2 mb-lg-3 form-group">
                                                                    <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                           id="PROP_ENGIEN_NEW_Left"
                                                                           class=" form-control"
                                                                           value="<?= (int)$arProps['PROP_ENGIEN_NEW_Left']['VALUE'] ?>"
                                                                           data-id_prop="168" type="text"
                                                                           placeholder="0"
                                                                           required="">
                                                                </div>
                                                            <? } ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-2 d-lg-block">
                                                        <p class="m-0 font-weight-bold"><?= $arItem['NAME'] ?>
                                                            : <?= ($arItem['IS_REQUIRED'] == 'Y') ? '*' : '' ?></p>
                                                    </div>

                                                </div>
                                                <?
                                            }
                                        } elseif ($arItem['PROPERTY_TYPE'] == 'N' && $arItem['ID'] != 31 && $arItem['ID'] != 168) { ?>
                                            <div class="mb-4 row">

                                                <div class="col-12 col-lg-10">
                                                    <div class="row d-flex justify-content-end mb-0 form-group">
                                                        <?if ($id){foreach ($id as $ids){drawElement($arProp[$ids] , $arLink ,$arProps);}}?>
                                                        <div class="col-6 d-lg-flex">
                                                            <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                   id="<?= $arItem['CODE'] ?>" class="form-control"
                                                                   data-id_prop="<?= $arItem['ID'] ?>" type="number"
                                                                <?= ($arProps[$arItem['CODE']]['VALUE']) ? 'value="' . $arProps[$arItem['CODE']]['VALUE'] . '"' : '' ?>
                                                                   placeholder="" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-lg-block col-2">
                                                    <p class="m-0 font-weight-bold"><?= $arItem['NAME'] ?>
                                                        : <?= ($arItem['IS_REQUIRED'] == 'Y') ? '*' : '' ?></p>
                                                </div>
                                            </div>
                                            <?
                                        }
                                    }
                                    unset($id)
                                    ?>

                                </div>
                            </div>
                            <div class="wizard-content" data-wizard-content="4">
                                <div class="auto-ad-step3">
                                    <h2 class="mb-4  d-lg-block text-center text-uppercase font-weight-bolder auto-step2__title">
                                        <?= Loc::getMessage('Detailed description'); ?>
                                    </h2>
                                    <h2 class="mb-4 d-block d-lg-none text-center text-uppercase font-weight-bolder auto-step2__title">
                                        <?= Loc::getMessage('Specifications'); ?></h2>
                                    <? foreach ($prop_fields as $field) {
                                        $needle = 'ROP';
                                        $needle2 = '_S3';
                                        $pos = strripos($field['CODE'], $needle);
                                        $pos2 = strripos($field['CODE'], $needle2);
                                        if ($pos == 1 && $pos2 >= 1) {
                                            if ($field['PROPERTY_TYPE'] == 'L') {
                                                $db_enum_list = CIBlockProperty::GetPropertyEnum($field['ID'], array("sort" => "asc"), array("IBLOCK_ID" => 3, 'PROPERTY_ID' => $field['ID']));
                                                while ($ar_enum_list[] = $db_enum_list->GetNext()) {
                                                    $field['PROP_ENUM_VAL'] = $ar_enum_list;
                                                }
                                                // print_r($ar_enum_list);
                                            } else {

                                            }
                                            $ar_enum_list = [];
                                            $arProp3[$field['ID']] = $field;
                                        }
                                    }
                                    ?>
                                    <?

                                    foreach ($arProp3 as $arItem) {
                                        $pattern = '/ID(\d+)/';
                                        preg_match_all($pattern, $arItem['CODE'], $matches);
                                         $id = $matches[1];
                                        $id = array_reverse($id);
                                        if ($arLink[$arItem['ID']]['DISPLAY_TYPE'] == 'P') {
                                            ?>
                                            <div class="mb-4 row flex-column-reverse flex-lg-row">
                                                <div class="col col-lg-10">
                                                    <div class="d-flex justify-content-end">
                                                        <?if ($id){foreach ($id as $ids){drawElement($arProp3[$ids] , $arLink ,$arProps);}}?>
                                                        <div class="dropdown bootstrap-select"><select
                                                                    class="selectpicker"
                                                                    data-style-base="form-control form-control-select"
                                                                    data-code_prop="<?= $arItem['CODE'] ?>"
                                                                    data-id_prop="<?= $arItem['ID'] ?>"
                                                                    data-style=""
                                                                    data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                    name="<?= $arItem['ID'] ?>"
                                                                    id="<?= $arItem['ID'] ?>"
                                                                    tabindex="-98">
                                                                <? foreach ($arItem['PROP_ENUM_VAL'] as $enumProp) { ?>
                                                                    <option value="<?= $enumProp['ID'] ?>"><?= $enumProp['VALUE'] ?></option>
                                                                <? } ?>
                                                                <option <? if (!$_GET['EDIT']){ ?>selected<? } ?>
                                                                        value="Nothing selected"></option>
                                                            </select>

                                                            <div class="dropdown-menu ">
                                                                <div class="inner show" role="listbox"
                                                                     id="bs-select-22" tabindex="-1">
                                                                    <ul class="dropdown-menu inner show"
                                                                        role="presentation">

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-2 mb-lg-0 col col-lg-2 d-flex d-lg-block justify-content-end justify-content-lg-center"><p class="m-0 font-weight-bold"><?= $arItem['NAME'] ?></p> <?= ($arItem['IS_REQUIRED'] == 'Y') ? ' * ' : '' ?></div>

                                            </div>
                                        <? } elseif ($arItem['PROPERTY_TYPE'] == 'L') { ?>
                                            <div class="mb-4 row flex-column-reverse flex-lg-row">
                                                <div class="col col-lg-10 ">

                                                    <div class="d-flex flex-row-reverse justify-content-center justify-content-lg-start flex-wrap <?= ($arItem['IS_REQUIRED'] == 'Y') ? 'div-req' : '' ?>">
                                                        <?if ($id){foreach ($id as $ids){drawElement($arProp3[$ids] , $arLink ,$arProps);}}?>
                                                        <? foreach ($arItem['PROP_ENUM_VAL'] as $prop) { ?>
                                                            <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                                                                <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                       data-id_prop="<?= $prop['PROPERTY_ID'] ?>"
                                                                       data-id-self="<?= $prop['ID'] ?>"
                                                                    <?= (in_array($prop['VALUE'], $arProps[$arItem['CODE']]['VALUE'])) ? 'checked' : '' ?>
                                                                       id="<?= $prop['VALUE'] ?>" type="checkbox"
                                                                       name="Multimedia">
                                                                <label for="<?= $prop['VALUE'] ?>"><?= $prop['VALUE'] ?></label>
                                                            </div>
                                                        <? } ?>
                                                    </div>
                                                </div>

                                                <div class="mb-2 mb-lg-0 col col-lg-2 d-flex d-lg-block justify-content-end justify-content-lg-center">
                                                    <p class="m-0 font-weight-bold"><?= $arItem['NAME'] ?>
                                                        : <?= ($arItem['IS_REQUIRED'] == 'Y') ? '*' : '' ?></p>
                                                </div>
                                            </div>
                                        <? } else { ?>
                                            <div class="mb-4 row">
                                                <div class="col-12 col-lg-10">
                                                    <div class="row d-flex justify-content-end mb-0 form-group">
                                                        <?if ($id){foreach ($id as $ids){drawElement($arProp3[$ids] , $arLink ,$arProps);}}?>
                                                        <div class="col-6  d-lg-flex">
                                                            <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                                                   id="<?= $arItem['CODE'] ?>" class="form-control"
                                                                   data-id_prop="<?= $arItem['ID'] ?>" type="number"
                                                                <?= ($arProps[$arItem['CODE']]['VALUE']) ? 'value="' . $arProps[$arItem['CODE']]['VALUE'] . '"' : '' ?>
                                                                   placeholder="" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class=" d-lg-block col-2">
                                                    <p class="m-0 font-weight-bold"><?= $arItem['NAME'] ?>
                                                        : <?= ($arItem['IS_REQUIRED'] == 'Y') ? '*' : '' ?></p>
                                                </div>
                                            </div>
                                        <? } ?>
                                    <? }
                                    unset($id);
                                    ?>
                                    <div class="mb-4 row flex-column-reverse flex-lg-row">
                                        <div class="col col-lg-10">
                                            <div class="d-flex flex-row-reverse flex-wrap">
                                                <textarea class="p-2 mr-2 mr-lg-3 w-100" name="Comment"
                                                          id="autoStepThreeComment"
                                                          <?= ($arFields['PREVIEW_TEXT']) ? 'value="' . $arFields['PREVIEW_TEXT'] . '"' : '' ?>
                                                          placeholder="תתארו את הרכב שלכם בפרטי פרטים, כולל תוספות, יתרונות וחסרונות"
                                                          rows="4"><?= $arFields['PREVIEW_TEXT'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-2 mb-lg-0 col col-lg-2 d-flex d-lg-block justify-content-end justify-content-lg-center">
                                            <p class="m-0 font-weight-bold"><?= Loc::getMessage('Comment (optional):'); ?></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="wizard-content" data-wizard-content="5">
                                <div class="auto-ad-step4">
                                    <h2 class="mb-4 text-center text-uppercase font-weight-bolder auto-step2__title">
                                        <?= Loc::getMessage('Choose a price'); ?></h2>

                                    <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center">
                                        <div class="d-flex mb-4 mb-lg-0">
                                            <div class="mr-3 d-flex justify-content-center align-items-center">
                                                <span class="mr-2"><?= Loc::getMessage('Price with VAT'); ?></span>

                                                <input data-id-self="PriceWithVAT" class="d-none" id="PriceWithVAT"
                                                       type="checkbox"
                                                       data-id_prop="UF_WITH_VAT"
                                                    <?= ($arProps['UF_WITH_VAT']['VALUE'] != '') ? 'checked' : '' ?>
                                                       name="Price with VATs">
                                                <label class="steps-check-box" for="PriceWithVAT"></label>
                                            </div>

                                            <div class="mr-4 d-flex justify-content-center align-items-center">
                                                <span class="mr-2"><?= Loc::getMessage('Exchange is possible'); ?></span>
                                                <input data-id-self="PriceExchangeIsPossible" class="d-none"
                                                       data-id_prop="UF_WITH_EXCHANGE"
                                                       id="PriceExchangeIsPossible" type="checkbox"
                                                    <?= ($arProps['UF_WITH_EXCHANGE']['VALUE'] != '') ? 'checked' : '' ?>
                                                       name="Exchange is possible">
                                                <label class="steps-check-box" for="PriceExchangeIsPossible"></label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center">


                                            <div class="ml-4 w-50 input-group">
                                                <p class="icon-currency-shek" style="font-size: 33px;
                                                        margin-top: 5px;
                                                        color: #3fb465;
                                                        padding-right: 10px;
                                                        ">
                                                    <?= ICON_CURRENCY; ?>
                                                </p>
                                                <input data-req="Y" data-id-self="userItemPrice" type="text"
                                                       class="form-control"
                                                       value="<?= $arProps['PRICE']['VALUE'] ?>"
                                                       id="userItemPrice"
                                                       name="User item price" placeholder="0" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-content" data-wizard-content="6">
                                <div class="mb-4 property-step-contact">
                                    <h2 class="mb-4 text-center text-uppercase font-weight-bolder">
                                        <?= Loc::getMessage('Contact Information'); ?>
                                    </h2>

                                    <div class="d-flex flex-column contact__main">
                                        <div class="mb-4 d-flex justify-center div-req">

                                            <div class="mr-2 form_radio_btn">
                                                <input data-req="Y" data-id-self="131" id="forAutohouse" type="radio"
                                                       name="thisUserStatus"
                                                       data-id_prop="UF_SELLER_TYPE"
                                                    <?= ($arProps['UF_SELLER_TYPE']['VALUE'] == "Agency") ? 'checked' : '' ?>
                                                       value="Autohouse" required>
                                                <label for="forAutohouse"> <?= Loc::getMessage('Agency'); ?></label>
                                            </div>

                                            <div class="form_radio_btn">
                                                <input data-req="Y" data-id-self="130" id="forOwner"
                                                       type="radio"
                                                       data-id_prop="UF_SELLER_TYPE"
                                                       name="thisUserStatus" value="Owner"
                                                    <?= ($arProps['UF_SELLER_TYPE']['VALUE'] == "Owner") ? 'checked' : '' ?>
                                                       required>
                                                <label for="forOwner"> <?= Loc::getMessage('Owner'); ?></label>
                                            </div>
                                        </div>

                                        <div class="agency">
                                            <div class="form-group">
                                                <input data-req="Y" data-id-self="Legalname" id="Legalname"
                                                       class="form-control"
                                                       value="<?= $arProps['UF_NAME']['VALUE'] ?>"
                                                       type="text" placeholder="<?= Loc::getMessage('Legal name'); ?> *"
                                                       required>
                                            </div>
                                        </div>

                                        <div class="number-section">
                                            <div class="form-group">
                                                <input data-req="Y" data-id-self="phone1" id="phone1"
                                                       class="form-control"
                                                       type="text"
                                                       value="<?= $arProps['UF_PHONE_1']['VALUE'] ?>"
                                                       placeholder="<?= Loc::getMessage('Enter your phone number in international format'); ?> *"
                                                       required>
                                            </div>

                                            <div class="form-group">
                                                <input data-id-self="phone2" id="phone2" class="form-control"
                                                       type="text"
                                                       value="<?= $arProps['UF_PHONE_2']['VALUE'] ?>"
                                                       placeholder="<?= Loc::getMessage('Enter your phone number in international format'); ?>"
                                                       required>
                                            </div>

                                            <div class="form-group">
                                                <input data-id-self="phone3" id="phone3" class="form-control"
                                                       type="text"
                                                       value="<?= $arProps['UF_PHONE_3']['VALUE'] ?>"
                                                       placeholder="<?= Loc::getMessage('Enter your phone number in international format'); ?>"
                                                       required>
                                            </div>
                                        </div>

                                        <? $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "add_city",
                                            array(
                                                "VIEW_MODE" => "TEXT",
                                                "SHOW_PARENT_NAME" => "Y",
                                                "IBLOCK_TYPE" => "settings",
                                                "IBLOCK_ID" => "9",
                                                "SECTION_ID" => $_REQUEST["SECTION_ID"],
                                                "SECTION_CODE" => "",
                                                "SECTION_URL" => "",
                                                "PROPS" => $arProps,
                                                "COUNT_ELEMENTS" => "N",
                                                "TOP_DEPTH" => "2",
                                                "SECTION_FIELDS" => "",
                                                "SECTION_USER_FIELDS" => "",
                                                "ADD_SECTIONS_CHAIN" => "N",
                                                "CACHE_TYPE" => "A",
                                                "CACHE_TIME" => "36000000",
                                                "CACHE_NOTES" => "",
                                                "CACHE_GROUPS" => "Y"
                                            )
                                        );
                                        ps($arProps);
                                        ?>

                                        <div class="mb-4 row flex-column-reverse flex-lg-row property-step-contact__time">
                                            <div class="d-none d-lg-flex col-3">
                                                <div class="form_radio_btn">
                                                    <input <?= ($arProps["UF_CALL_ANYTIME"]['VALUE'] != '' && $arProps["UF_CALL_ANYTIME"]['VALUE'] != '0' ) ? 'checked' : '' ?>
                                                            data-id_prop="UF_CALL_ANYTIME" data-id-self="1" id="anytime"
                                                            type="checkbox" name="anytime" value="anytime">
                                                    <label class="mr-3 mb-0"
                                                           for="anytime"><?= Loc::getMessage('Anytime'); ?></label>
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
                                                <p class="text-right mb-3 mb-lg-0 font-weight-bold"><?= Loc::getMessage('Call:'); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="propert-sell-main__step-control">
                            <button onclick="submitForm(event)"
                                    class="mb-2 btn btn-primary wizard-control-final">
                                <span><?= Loc::getMessage('Submit your ad'); ?> </span>
                            </button>

                            <!-- <button class="mb-2 btn wizard-control-final">
                              <span>Preview</span>
                            </button> -->

                            <button type="button" class="mb-2 btn steps-button wizard-control-next">
                                <span class="btn-icon"><i class="icon-left-arrow"></i></span>
                                <span><?= Loc::getMessage('Next step'); ?></span>
                            </button>

                            <button type="button" class="mb-2 btn wizard-control-prev">
                                <span class="mr-2"><?= Loc::getMessage('Prev step'); ?></span>
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
        $('#forAutohouse').click(function () {
            $('#Legalname').show();
        })
        $('#forOwner').click(function () {
            $('#Legalname').hide();
        })

        if (window.location.href.indexOf("EDIT") > -1) {

        } else {
            $('#forOwner').prop('checked', true);
            $('#Legalname').hide();
        }


        function addActivePhoto(item) {
            if (item !== undefined) {
                let mainText = document.querySelectorAll(".set-main-text");

                mainText.forEach((el) => {
                    el.innerText = "Set as main";
                    el.closest(".main-photo__item").querySelector(".rotate-img").removeAttribute("data-activePhoto");
                })
                item.closest(".main-photo__item").querySelector(".rotate-img").setAttribute("data-activePhoto", "isActive");

                item.innerText = "Main";
            }
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

        function submitForm(event) {
            event.preventDefault();
            var $data = {};

            if (!$('.show-country ').hasClass('selected')) {
                $('.first-drop').addClass('error');
            } else {
                $('.first-drop').removeClass('error');
            }
            if ($('.show-country ').hasClass('selected')) {
                $('.preloader').css({"z-index": "1", "opacity": "100", "position": "fixed"});
                $('#mainForm').find('input').each(function () {
                    if (this.checked) {
                        //alert("checked");
                        var object = {}
                        object.val = this.checked;
                        object.data = $(this).data();
                        $data[this.id] = object

                    } else {
                        var object = {}
                        object.val = $(this).val();
                        object.data = $(this).data();
                        $data[this.id] = object;
                    }
                });
                var $data2 = {};
                $('#mainForm').find('select').each(function () {
                    var data = $(this).data();
                    var dataVal = $(this).val();
                    $data2[this.id] = [data.code_prop, dataVal];
                });
                $data['$data2'] = $data2;
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
                $data['itemDescription'] = $('#autoStepThreeComment').val();
                <?if($_GET['EDIT'] == 'Y'){?>
                $data['EDIT'] = 'Y';
                $data['EDIT_ID'] = '<?=$_GET['ID']?>'
                <?}?>
                $data['section_id'] = $('.activeSection').data();
                $data['LOCATION'] = $('.first-drop').html() + $('.second-drop').html()
                $data['region'] = $('.first-drop').html().trim();
                $data['city'] = $('.second-drop').html().trim();
                var deferred = $.ajax({
                    type: "POST",
                    url: "/ajax/add_auto.php",
                    data: $data,
                    dataType: 'json'
                });
                deferred.done(function (data) {
                    //
                    $('.preloader').css({"z-index": "0", "opacity": "100", "position": "fixed"});
                    if (data.success == 1) {
                        window.location.href = '/personal/'
                    } else {
                        $('.pop-up').addClass('active');
                        $('.pop-up__text').html(data.responseBitrix)
                    }
                });
            } else {
                $('.first-drop').addClass('error');
            }
        }

        let flagPhoto = true;

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
                        if (textItem === "Main") {
                            return flagPhoto = false
                        }
                    })

                    if (flagPhoto) {
                        setTimeout(function () {
                            let photoItems = document.querySelectorAll(".main-photo__item")
                            let mainPhoto = photoItems[photoItems.length - 1]
                            mainPhoto.querySelector("img").setAttribute("data-activePhoto", "isActive");
                            mainPhoto.querySelector(".set-main-text").innerText = "Main"

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
            '#fileUploaderRenderContainer', '#fileUploaderFiles', `<div class="mb-4 col main-photo__item" data-file-id="{{name}}">
      <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="mb-3 d-flex justify-content-center align-items-center photo">
          <img data-rotate="0" src="{{dataUrl}}" class="rotate-img">
        </div>

        <label id="main-selector-photo" class="mb-2 p-0 btn text-center text-primary main-selector-photo">
          <input type="radio" name="fileMain" value="{{name}}" class="d-none main-selector-photo" />
           <div onclick="addActivePhoto(this)" id="213213" class="set-main-text">Set as main</div>
        </label>

        <div class="d-flex justify-content-around">
          <div class="mr-3 d-flex justify-content-center align-items-center element-control" data-file-remove-id="{{name}}">
            <i class="mr-2 icon-clear"></i>
            <span class="d-none d-lg-inline-block">Delete</span>
          </div>

          <div class="d-flex justify-content-center align-items-center element-control rotate-control">
            <input  type="hidden" name="rotate[{{name}}]" value="0" />
            <i onclick="rotateThis(this)" class="mr-2 icon-replay"></i>
            <span onclick="rotateThis(this)" class="d-none d-lg-inline-block">Rotate</span>
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

        $('.wizard-control-next').click(function () {
            $(document).ready(function () {
                let selectedSellerTypeAgency = $('#forAutohouse').is(':checked')
                let selectedSellerTypeOwner = $('#forOwner').is(':checked')
                console.log(selectedSellerTypeAgency)
                console.log(selectedSellerTypeOwner)
                if (selectedSellerTypeOwner) {
                    $('#Legalname').hide();
                    $('#Legalname').attr('data-req', 'N');
                } else {
                    $('#Legalname').show();
                    $('#Legalname').attr('data-req', 'Y');
                }
                let currentUrl = window.location.href;
                let isEdit = currentUrl.indexOf("EDIT=Y") !== -1;
                if (!isEdit) {
                    setTimeout(() => $('.wizard-control-final').removeClass('active'), 500);
                }
                let toClickId = <?=json_encode($arToClick)?>;
                console.log(toClickId);
                toClickId.forEach(function (index) {
                    let selector = '#' + index;
                    console.log($(selector).siblings('label').trigger('click'))
                })

            })
        })


    </script>
    <style>
        .activeSection {
            color: #3fb465 !important;
        }

        @media (max-width: 768px) {

            .mb-4.row {
                justify-content: flex-end;
            }

            .flex-column-reverse-d {
                flex-direction: inherit !important;
            }

            .propert-sell-main .form_radio_btn label {
                font-size: 12px;
                height: 29px;
                min-width: 50px;
                border-radius: 3px;
            }
        }
    </style>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
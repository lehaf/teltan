<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/colors.css',
    'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
);
?>
<?
$checkCoun = 0;
foreach ($arResult["ITEMS"] as $arItem) {

    if ($arItem['CODE'] == 'PROP_BRAND') {
        foreach ($arItem["VALUES"] as $ar) {

            if ($ar['CHECKED'] != null) {
                $checkCoun++;
            }
        }

    }
}
if ($checkCoun > 0) {
    $_SESSION['BRAND_SHOW'] = false;
} else {
    $_SESSION['BRAND_SHOW'] = true;
} ?>
<div class="d-flex nav-category-type">
    <label class="label-type">
        <input id="renCheck" onchange="changeTypeRent(this)" class="category" name="category" value="rent" type="radio">
        <div><?= Loc::getMessage('rent'); ?></div>
    </label>
    <label class="label-type">
        <input id="buyCheck" onchange="changeTypeRent(this)" class="category" name="category" value="buy" type="radio">
        <div><?= Loc::getMessage('buy'); ?></div>
    </label>
</div>
</div>
<!-- menu end -->
<form id="mainFiltersRent" class="main-filters">
    <div class="prop-rent-form">
        <?/*
        <div class="location-select">
           <!-- <input class="search-input" type="text" placeholder="<?= Loc::getMessage('city'); ?>"> -->
            <div class="location-select__item">
                <div class="dropdown custom-btn-property">
                    <i class="icon-arrow-down-sign-to-navigate-3"></i>
                    <div class="select">
                        <span>region</span>
                        <i class="fa fa-chevron-left"></i>
                    </div>
                    <input type="hidden" name="gender">
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-search">
                            <i class="icon-magnifying-glass-1"></i>
                            <input type="text" placeholder="Enter search words" class="dropdown-menu-search__input">
                        </div>
                        <ul>
                            <?foreach ($arResult['ITEMS'][200]['VALUES'] as $arValue){

                                ?>
                                <li class="liParentItem" id="<?=$arValue['VALUE']?>"><?=$arValue['VALUE']?> </li>
                            <?}?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="location-select__place-item">
                <div class="dropdown custom-btn-property">
                    <i class="icon-arrow-down-sign-to-navigate-3"></i>
                    <div class="select">
                        <span>region</span>
                        <i class="fa fa-chevron-left"></i>
                    </div>
                    <input type="hidden" name="gender">

                    <ul class="dropdown-menu" id="liTarget">
                        <?foreach ($arResult['ITEMS'][201]['VALUES'] as $arValue){
                          //  $arValue['VALUE']=iconv("UTF-16", "UTF-8", $arValue['VALUE']);
                            $arState = explode(':',$arValue['VALUE']);
                            ?>
                        <li data-parent-id="<?=base64_decode(ltrim($arState[0]))?>" id="<?=ltrim($arState[0])?>"><?=ltrim($arState[1])?> </li>
                        <?}?>

                    </ul>
                </div>
            </div>
        </div>
*/?>

        <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>"
              method="get">
            <div class="w-30 position-relative dropdown-block">
                <button id="area2toogle" type="button"
                        class="custom-btn-property custom-btn-property--new btn-property-type ">
                    <i class="icon-arrow-down-sign-to-navigate-3"></i>
                    <span class="typeProperty">area</span>
                </button>

                <div class="w-100 justify-content-end dropdown-card dropdown-building-area2">
                    <div class="d-flex flex-column align-items-end dropdown-card-wrapper check-box-prop-filter">
                        <div class="dropdown-menu-search">
                            <i class="icon-magnifying-glass-1"></i>
                            <textarea type="text" placeholder="Enter search words" class="dropdown-menu-search__input"></textarea>
                        </div>
                        <ul class="dropdown-card__content">

                            <? foreach ($arResult['ITEMS'][201]['VALUES'] as $val => $ar) {
                                $arState = explode(':',$ar['VALUE']);
                                ?>
                                <script>console.log(<?=json_encode(base64_decode(ltrim($arState[0])))?>)</script>
                                <li  <? echo $ar["DISABLED"] ? 'style"display:none"' : '' ?> data-filter-for='.dropdown-menu-search' data-filter="<?=ltrim($arState[1])?>">
                                    <label class="cb-wrap">
                                        <span class="text"><?=ltrim($arState[1])?></span>
                                        <input type="checkbox"
                                               data-parent-item-id="<?=base64_decode(ltrim($arState[0]))?>"
                                               id="<? echo $ar["CONTROL_ID"] ?>"
                                               name="<? echo $ar["CONTROL_NAME"] ?>"
                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                            <? echo $ar["DISABLED"] ? 'style"display:none"' : '' ?>
                                               value="<? echo $ar["HTML_VALUE"] ?>" data-valued="<?=ltrim($arState[1])?>"
                                               onclick="smartFilterMain.click(this)"
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <?
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="w-30 position-relative dropdown-block">
                <button id="area1toogle" type="button"
                        class="custom-btn-property custom-btn-property--new btn-property-type ">
                    <i class="icon-arrow-down-sign-to-navigate-3"></i>
                    <span class="typeProperty">region</span>
                </button>

                <div class="w-100 justify-content-end dropdown-card dropdown-building-area1">
                    <div class="d-flex flex-column align-items-end check-box-prop-filter">

                        <ul class="dropdown-card__content">
                            <? foreach ($arResult['ITEMS'][200]['VALUES'] as $val => $ar) { ?>
                                <li  <? echo $ar["DISABLED"] ? 'style"display:none"' : '' ?>><label class="cb-wrap">
                                        <span class="text"><?= $ar['VALUE'] ?></span>
                                        <input
                                                class="data-function"
                                                type="checkbox"
                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                            <? echo $ar["DISABLED"] ? '' : '' ?>
                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                data-valued="<? echo $ar["VALUE"] ?>"
                                                onclick="smartFilterMain.click(this);"
                                        >
                                        <span class="checkmark"></span>
                                    </label></li>
                                <?
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>

         <?
            foreach ($arResult["ITEMS"] as $key => $arItem) {

                $key = $arItem["ENCODED_ID"];
                if (isset($arItem["PRICE"])):
                    if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                        continue;

                    $precision = 2;
                    if (Bitrix\Main\Loader::includeModule("currency")) {
                        $res = CCurrencyLang::GetFormatDescription($arItem["VALUES"]["MIN"]["CURRENCY"]);
                        $precision = $res['DECIMALS'];
                    }
                    ?>
                    <div class="bx_filter_parameters_box active">
                        <span class="bx_filter_container_modef"></span>
                        <div class="bx_filter_parameters_box_title"
                             onclick="smartFilterMain.hideFilterProps(this)"><?= $arItem["NAME"] ?></div>
                        <div class="bx_filter_block">
                            <div class="bx_filter_parameters_box_container">
                                <div class="bx_filter_parameters_box_container_block">
                                    <div class="bx_filter_input_container">
                                        <input
                                                class="min-price"
                                                type="text"
                                                name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>" data-valued="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                                size="5"
                                                onkeyup="smartFilterMain.keyup(this)"
                                        />
                                    </div>
                                </div>
                                <div class="bx_filter_parameters_box_container_block">
                                    <div class="bx_filter_input_container">
                                        <input
                                                class="max-price"
                                                type="text"
                                                name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>" data-valued="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                                size="5"
                                                onkeyup="smartFilterMain.keyup(this)"
                                        />
                                    </div>
                                </div>
                                <div style="clear: both;"></div>

                                <div class="bx_ui_slider_track" id="drag_track_<?= $key ?>">
                                    <?
                                    $precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
                                    $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
                                    $price1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
                                    $price2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
                                    $price3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
                                    $price4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
                                    $price5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                                    ?>
                                    <div class="bx_ui_slider_part p1"><span><?= $price1 ?></span></div>
                                    <div class="bx_ui_slider_part p2"><span><?= $price2 ?></span></div>
                                    <div class="bx_ui_slider_part p3"><span><?= $price3 ?></span></div>
                                    <div class="bx_ui_slider_part p4"><span><?= $price4 ?></span></div>
                                    <div class="bx_ui_slider_part p5"><span><?= $price5 ?></span></div>

                                    <div class="bx_ui_slider_pricebar_VD" style="left: 0;right: 0;"
                                         id="colorUnavailableActive_<?= $key ?>"></div>
                                    <div class="bx_ui_slider_pricebar_VN" style="left: 0;right: 0;"
                                         id="colorAvailableInactive_<?= $key ?>"></div>
                                    <div class="bx_ui_slider_pricebar_V" style="left: 0;right: 0;"
                                         id="colorAvailableActive_<?= $key ?>"></div>
                                    <div class="bx_ui_slider_range" id="drag_tracker_<?= $key ?>"
                                         style="left: 0%; right: 0%;">
                                        <a class="bx_ui_slider_handle left" style="left:0;" href="javascript:void(0)"
                                           id="left_slider_<?= $key ?>"></a>
                                        <a class="bx_ui_slider_handle right" style="right:0;" href="javascript:void(0)"
                                           id="right_slider_<?= $key ?>"></a>
                                    </div>
                                </div>
                                <div style="opacity: 0;height: 1px;"></div>
                            </div>
                        </div>
                    </div>
                <?
                $arJsParams = array(
                    "leftSlider" => 'left_slider_' . $key,
                    "rightSlider" => 'right_slider_' . $key,
                    "tracker" => "drag_tracker_" . $key,
                    "trackerWrap" => "drag_track_" . $key,
                    "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                    "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                    "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                    "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                    "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                    "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                    "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
                    "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                    "precision" => $precision,
                    "colorUnavailableActive" => 'colorUnavailableActive_' . $key,
                    "colorAvailableActive" => 'colorAvailableActive_' . $key,
                    "colorAvailableInactive" => 'colorAvailableInactive_' . $key,
                );
                ?>
                    <script type="text/javascript">
                        BX.ready(function () {
                            window['trackBar<?=$key?>'] = new BX.Iblock.smartFilterMain(<?=CUtil::PhpToJSObject($arJsParams)?>);
                        });
                    </script>
                <?endif;
            }
            $arID = [61, 109, 165, 178, 173, 195, 196];
            //not prices
            foreach ($arResult["ITEMS"] as $key => $arItem) {
                if (!in_array($arItem['ID'], $arID))
                    continue;


                if (
                    $arItem["DISPLAY_TYPE"] == "A"
                    && (
                        $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
                    )
                )
                    continue;
                ?>
              
            <?
            $arCur = current($arItem["VALUES"]);
            switch ($arItem["DISPLAY_TYPE"]) {
            case "A"://NUMBERS_WITH_SLIDER
                ?>

                <?
                break;
            case "B"://NUMBERS
            ?>
            <? if ($arItem['ID'] != 173){
            ?>
                <div class="w-17 position-relative">
                    <button type="button" class="custom-btn-property custom-btn-property--new btn-price buttonShowPropertyFilterPrice">
                        <i class="icon-arrow-down-sign-to-navigate-3"></i>
                        <span class="houseRentUserPrise"><?= Loc::getMessage('price'); ?></span>
                    </button>

                    <div class="dropdown-card dropdown-filter dropdown-prise">
                        <div class="input-decoration mr-3">
                            <input class="priceMax"
                                   type="text"
                                   value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>" 
                                   name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                   placeholder="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                   id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                   onkeyup="smartFilterMain.keyup(this); $(this).data('valued', $(this).val())">
                            <span class="decoration">₪</span>
                        </div>

                        <div class="input-decoration">
                            <input class="priceMin"
                                   type="text"
                                   value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                   name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                   placeholder="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                   id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                   onkeyup="smartFilterMain.keyup(this); $(this).data('valued', $(this).val())">
                            <span class="decoration">₪</span>
                        </div>
                    </div>
                </div>
            <?
            } ?>

                <? if ($arParams['SECTION_ID'] == 28) {
            if ($arItem['ID'] == 173){
                ?>

                <div class="w-17 position-relative">
                    <button type="button" class="custom-btn-property custom-btn-property--new btn-price buttonShowPropertyFilterArea">
                        <i class="icon-arrow-down-sign-to-navigate-3"></i>
                        <span class="rentAreaCommerce">Площадь</span>
                    </button>

                    <div class="dropdown-card dropdown-filter dropdown-area">
                        <div class="input-decoration mr-3">
                            <input class="priceMax"
                                   type="text"
                                   value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>" data-valued="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                   name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                   placeholder="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                   id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                   onkeyup="smartFilterMain.keyup(this)">
                            <span class="decoration">м²</span>
                        </div>

                        <div class="input-decoration">
                            <input class="priceMin"
                                   type="text"
                                   value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>" data-valued="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                   name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                   placeholder="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                   id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                   onkeyup="smartFilterMain.keyup(this)">
                            <span class="decoration">м²</span>
                        </div>
                    </div>
                </div>
            <? } ?>
                <?
            } ?>
                <?
                break;
                case "G"://CHECKBOXES_WITH_PICTURES
                    ?>

                    <?
                    break;
                case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
                    ?>

                    <?
                    break;
                case "P"://DROPDOWN

                    ?>

                    <?
                    break;
                case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
                    ?>

                    <?
                    break;
            case "K"://RADIO_BUTTONS
                ?>

                <?
            if ($arParams['SECTION_ID'] == 27){

                ?>
                <div class="w-17 position-relative">
                    <button type="button"
                            class="custom-btn-property custom-btn-property btn-property-type buttonShowPropertyFilterRoom">
                        <i class="icon-arrow-down-sign-to-navigate-3"></i>
                        <span class="typeProperty"><?= Loc::getMessage('room'); ?></span>
                    </button>
                    <div class="dropdown-card dropdown-room-number ">

                        <div class="mb-4 room-number flex-row-reverse">

                            <? foreach ($arItem["VALUES"] as $val => $ar) { ?>
                                <label  <? echo $ar["DISABLED"] ? 'style"display:none"' : '' ?> class="chackbox-label">

                                    <input type="checkbox"
                                           id="<? echo $ar["CONTROL_ID"] ?>"
                                           name="<? echo $ar["CONTROL_NAME"] ?>"
                                           value="<? echo $ar["HTML_VALUE"] ?>" data-valued="<? echo $ar["VALUE"] ?>"
                                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                        <? //echo $ar["DISABLED"] ? 'disabled' : '' ?>
                                           onclick="smartFilterMain.click(this)"
                                    >
                                    <div><?= $ar['VALUE'] ?></div>
                                </label>
                                <?
                            } ?>
                        </div>
                        <div class="d-flex flex-column align-items-end check-box-prop-filter">
                            <label class="cb-wrap">
                                <span class="text">Студия</span>

                                <input type="checkbox"
                                       id="<? echo $arResult['ITEMS'][195]['VALUES'][172]["CONTROL_ID"] ?>"
                                       name="<? echo $arResult['ITEMS'][195]['VALUES'][172]["CONTROL_NAME"] ?>"
                                       value="<? echo $arResult['ITEMS'][195]['VALUES'][172]["HTML_VALUE"] ?>" data-valued="<? echo  $arResult['ITEMS'][195]['VALUES'][172]["VALUE"] ?>"
                                    <? echo $arResult['ITEMS'][195]['VALUES'][172]["CHECKED"] ? 'checked="checked"' : '' ?>
                                    <? echo $arResult['ITEMS'][195]['VALUES'][172]["DISABLED"] ? '' : '' ?>
                                       onclick="smartFilterMain.click(this)"
                                >
                                <span class="checkmark"></span>
                            </label>

                            <label class="cb-wrap">
                                <span class="text">Свободная планировка</span>

                                <input type="checkbox"
                                       id="<? echo $arResult['ITEMS'][196]['VALUES'][173]["CONTROL_ID"] ?>"
                                       name="<? echo $arResult['ITEMS'][196]['VALUES'][173]["CONTROL_NAME"] ?>"
                                       value="<? echo $arResult['ITEMS'][196]['VALUES'][173]["HTML_VALUE"] ?>" data-valued="<? echo  $arResult['ITEMS'][196]['VALUES'][173]["VALUE"] ?>"
                                    <? echo $arResult['ITEMS'][196]['VALUES'][173]["CHECKED"] ? 'checked="checked"' : '' ?>
                                    <? echo $arResult['ITEMS'][196]['VALUES'][173]["DISABLED"] ? '' : '' ?>
                                       onclick="smartFilterMain.click(this)"
                                >
                                <span class="checkmark"></span>
                            </label>
                        </div>


                    </div>

                </div>

            <? }

                break;
                case "U"://CALENDAR
                    ?>

                    <?
                    break;
            default:
                ?>
                <? if ($arItem['ID'] == 178) {
                ?>
                <? foreach ($arItem["VALUES"] as $val => $ar) { ?>
                <label  <? echo $ar["DISABLED"] ? 'style"display:none"' : '' ?> class="label-type" style="display: none">
                    <input type="checkbox"
                           class="category ttt"
                           id="<? // echo $ar["CONTROL_ID"] ?>"
                           name="<? echo $ar["CONTROL_NAME"] ?>"
                           value="<? echo $ar["HTML_VALUE"] ?>" data-valued="<? echo $ar["VALUE"] ?>"
                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                        <? echo $ar["DISABLED"] ? '' : '' ?>
                           onclick="smartFilterMain.click(this)"
                    >
                    <div><?= $ar['VALUE'] ?></div>
                </label>
                <?
            } ?>
            <? } else {
            if ($arItem['ID'] == 165) {
                ?>
                <div class="w-30 position-relative">
                    <button type="button"
                            class="custom-btn-property custom-btn-property--new btn-property-type buttonShowPropertyFilterType">
                        <i class="icon-arrow-down-sign-to-navigate-3"></i>
                        <span class="typeProperty"><?= Loc::getMessage('type'); ?></span>
                    </button>

                    <div class="w-100 justify-content-end dropdown-card dropdown-building-type">
                        <div class="d-flex flex-column align-items-end check-box-prop-filter">
                            <? foreach ($arItem["VALUES"] as $val => $ar) { ?>
                                <label  <? echo $ar["DISABLED"] ? 'style"display:none"' : '' ?> class="cb-wrap">
                                    <span class="text"><?= $ar['VALUE'] ?></span>
                                    <input type="checkbox"
                                           id="<? echo $ar["CONTROL_ID"] ?>"
                                           name="<? echo $ar["CONTROL_NAME"] ?>"
                                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                        <? echo $ar["DISABLED"] ? '' : '' ?>
                                           value="<? echo $ar["HTML_VALUE"] ?>" data-valued="<? echo $ar["VALUE"] ?>"
                                           onclick="smartFilterMain.click(this)"
                                    >
                                    <span class="checkmark"></span>
                                </label>
                                <?
                            } ?>
                        </div>
                    </div>
                </div>

                <?
            }
            }

            }
            }
            ?>

    </div>

    <div class="d-flex sub-menu-prop">
        <!-- отправляет форму с клоном даты  form="sandRequest"-->
        <div style="z-index: 2; color: white" class="btn btn-primary font-weight-bold submit-btn-search"
             id="modef" <? if (!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"'; ?>
             style="display: inline-block;">
            <span style="display: none" id="modef_num"></span>

            <a id="modefParen" style="z-index: 2; color: white" href="<? echo $arResult["FILTER_URL"] ?>"
               target=""><?= Loc::getMessage('find'); ?></a>
        </div>
        <div style="z-index: 2;color: white" class="btn bg-white text-primary font-weight-bold border-primary btn-show-map"
             id="modef" <? if (!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"'; ?>
             style="display: inline-block;">
            <span style="display: none" id="modef_num"></span>

            <a style="z-index: 2; color: #3fb465 !important" href="<? echo $arResult["FILTER_URL"] ?>&view=maplist"
               target=""><?= Loc::getMessage('find_map'); ?></a>
        </div>

        <div class="list-filter-options">
            <div class="showAllTags" data-toggle="modal" data-target="#moreFilterPropertyRent">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="d-flex justify-content-end align-items-center tags">
                <!-- TAGS PLACE -->
            </div>
        </div>

        <a href="#" type="button" class="btn-more-filters d-flex justify-content-between align-items-center text-white"
           data-toggle="modal" data-target="#moreFilterPropertyRent">
            <i class="icon-arrow-down-sign-to-navigate-3"></i>
            <?= Loc::getMessage('more_params'); ?>
        </a>
        <!-- </ul> -->

</form>

<script>


       /* let customBtnProperty = document.querySelectorAll(".custom-btn-property--new");
        let dropdownCard = document.querySelectorAll(".dropdown-card");

        function removeActive(){
            customBtnProperty.forEach((el)=>{
                el.classList.remove("active");
            })
            dropdownCard.forEach((el)=>{
                el.classList.remove("active");
            })
        }


        let dropdownList = document.querySelectorAll(".dropdown");


        document.addEventListener("click",function(){
            let el = event.target
            if(!el.classList.contains("custom-btn-property--new") && !el.classList.contains("dropdown-card") && !el.closest("input")){
                removeActive()
            }



            if(!el.classList.contains("dropdown-menu-search__input") && !el.closest(".dropdown")){
                dropdownList.forEach(function (el){
                    el.classList.remove('active');
                    $(".dropdown-menu").slideUp(300);

                })

            }

        })

        dropdownList.forEach((el)=>{


            el.addEventListener("click", function(e){
                removeActive()
                if (!e.target.classList.contains("dropdown-menu-search__input")) {
                    console.log('el.classList.contains("active")', el.classList.contains("active"))
                     $(".dropdown-menu").slideUp(300);
                    //$(".dropdown").removeClass('active');
                    if(el.classList.contains("active")){
                        dropdownList.forEach((elem)=>{
                            elem.classList.remove('active');
                            $(".dropdown-menu").slideUp(300);

                        })

                    }else{
                        dropdownList.forEach((elem)=>{
                            elem.classList.remove('active');
                        })
                        el.classList.add("active")
                        $(this).find('.dropdown-menu').slideToggle(300);

                    }

                }

            })

        })*/


        /*$('.dropdown .dropdown-menu li').click(function () {
            $(this).parents('.dropdown').find('span').text($(this).text());
            $(this).parents('.dropdown').find('input').attr('value', $(this).attr('id'));
        });*/

      


    var smartFilterMain = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);

    function changeTypeRent(element) {

        if ($('#buyCheck').is(':checked') == false) {
            var elem = document.getElementById("arrFilter_178_1500340406");
          
            elem.checked = false;

        } else {
            var elem = document.getElementById("arrFilter_178_1500340406");

            elem.click();
            elem.checked = true;

        }
        if ($('#renCheck').is(':checked') == false) {
            var elem = document.getElementById("arrFilter_178_1577100463");

            elem.checked = false;

        } else {
            var elem = document.getElementById("arrFilter_178_1577100463");

            elem.click();
            elem.checked = true;

        }
    }

    $(document).ready(function () {

        var elem1 = document.getElementById("arrFilter_178_1500340406");
        var elem2 = document.getElementById("arrFilter_178_1577100463");
        if (elem1.checked == true) {
            var elem = document.getElementById("buyCheck");
            elem.checked = true
        }
        if (elem2.checked == true) {
            var elem = document.getElementById("renCheck");
            elem.checked = true
        }
    })
</script>
<?php
if($_GET['set_filter'] == 'y'){
    ?>
    <script>
     $(document).ready(function () {
         $('#mainFiltersRent').submit()
     })

    </script>
    <?php
}
?>

<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
    foreach($arItem["VALUES"] as $ar){

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
}?>
<div class="mb-5 card auto-mark-list"  <? if ($_SESSION['BRAND_SHOW'] == false){ ?>style="display: none"<? } ?>>
<form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>"
      method="get">
    <ul class="mb-3 nav text-right">
    <? foreach ($arResult["HIDDEN"] as $arItem): ?>

        <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>"
               value="<? echo $arItem["HTML_VALUE"] ?>"/>
        <?endforeach;
        //prices
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
                         onclick="smartFilter.hideFilterProps(this)"><?= $arItem["NAME"] ?></div>
                    <div class="bx_filter_block">
                        <div class="bx_filter_parameters_box_container">
                            <div class="bx_filter_parameters_box_container_block">
                                <div class="bx_filter_input_container">
                                    <input
                                            class="min-price"
                                            type="text"
                                            name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                            id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                            value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                            size="5"
                                            onkeyup="smartFilter.keyup(this)"
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
                                            value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                            size="5"
                                            onkeyup="smartFilter.keyup(this)"
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
                        window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                    });
                </script>
            <?endif;
        }

        //not prices
        foreach ($arResult["ITEMS"] as $key => $arItem) {
            if (
                empty($arItem["VALUES"])
                || isset($arItem["PRICE"])
            )
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
                    break;
                case "U"://CALENDAR
                    ?>

                    <?
                    break;
                default:
                  static $count = 0;//CHECKBOXES
                    ?>
                    <? if ($arItem['CODE'] == 'PROP_BRAND') { ?>
                    <? foreach ($arItem["VALUES"] as $val => $ar) { ?>
        <?if($count == 12){?>
    </ul>
  
    <ul class="nav collapse text-right" id="moreCars">
        <?}?>
                        <li>
                            <label class="automodellabel">
                                <?= $ar['VALUE'] ?>
                                <input
                                        type="checkbox"
                                        style="display: none;"
                                        value="<? echo $ar["HTML_VALUE"] ?>"
                                        name="<? echo $ar["CONTROL_NAME"] ?>"
                                        id="<? echo $ar["CONTROL_ID"] ?>"
                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                    <? echo $ar["DISABLED"] ? 'disabled' : '' ?>
                                        onclick="
                                        smartFilter.click(this)
                                        $('.submitaitomodeldata').trigger('click')
"

                                />

                            </label>
                        </li>
                    <?
                    $count++;
                    }

                }
            }
        }
        ?>
    </ul>



   <!-- </ul> -->
       <div class="clb"></div>
    <div class="bx_filter_button_box active">
        <div class="bx_filter_block">
            <div class="bx_filter_parameters_box_container" style="display: none;">
                <input
                        class="bx_filter_search_button submitaitomodeldata"
                        type="submit"
                        id="set_filter"
                        name="set_filter"
                        value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>"
                />
                <input
                        class="bx_filter_search_reset"
                        type="submit"
                        id="del_filter"
                        name="del_filter"
                        value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>"
                />
            </div>
        </div>
    </div>
</form>
<div style="clear: both;"></div>

<script>
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
    <a <?echo ($count >=12) ? "" : "style='display:none!important'"; ?> class="d-flex justify-content-end text-right collapsed" data-toggle="collapse" href="#moreCars" role="button" aria-expanded="false" aria-controls="moreCars">
        <i class="mr-2 d-flex justify-content-center align-items-center icon-arrow-down-sign-to-navigate-3"></i> Все марки
    </a>
</div>
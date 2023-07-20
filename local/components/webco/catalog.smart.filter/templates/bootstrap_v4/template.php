<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->SetViewTarget("smart_filter_HTML");
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
    'TEMPLATE_CLASS' => 'bx-' . $arParams['TEMPLATE_THEME']
);
function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

if (isset($templateData['TEMPLATE_THEME'])) {
    $this->addExternalCss($templateData['TEMPLATE_THEME']);
}

?>


    <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>" method="get"
          class="smart-filter-form">

        <? foreach ($arResult["HIDDEN"] as $arItem): ?>
            <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>"
                   value="<? echo $arItem["HTML_VALUE"] ?>"/>
        <? endforeach; ?>


        <? foreach ($arResult["ITEMS"] as $key => $arItem)//prices
        {
            $key = $arItem["ENCODED_ID"];
            if (isset($arItem["PRICE"])):
                if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                    continue;

                $step_num = 4;
                $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                $prices = array();
                if (Bitrix\Main\Loader::includeModule("currency")) {
                    for ($i = 0; $i < $step_num; $i++) {
                        $prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                    }
                    $prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                } else {
                    $precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
                    for ($i = 0; $i < $step_num; $i++) {
                        $prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $precision, ".", "");
                    }
                    $prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                }
                ?>

                <div class="<? if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL"): ?>col-sm-6 col-md-4<? else: ?>col-12<? endif ?> mb-2 smart-filter-parameters-box bx-active">
                    <span class="smart-filter-container-modef"></span>

                    <div class="smart-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)">
                        <span class="smart-filter-parameters-box-title-text"><?= $arItem["NAME"] ?></span>
                        <span data-role="prop_angle" class="smart-filter-angle smart-filter-angle-up">
									<span class="smart-filter-angles"></span>
								</span>
                    </div>

                    <div class="smart-filter-block" data-role="bx_filter_block">
                        <div class="smart-filter-parameters-box-container">
                            <div class="smart-filter-input-group-number">
                                <div class="d-flex justify-content-between">
                                    <div class="form-group" style="width: calc(50% - 10px);">
                                        <div class="smart-filter-input-container">
                                            <input
                                                    class="min-price form-control form-control-sm"
                                                    type="number"
                                                    name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                    id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                    value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                    size="5"
                                                    placeholder="<?= GetMessage("CT_BCSF_FILTER_FROM") ?>"
                                                    onkeyup="smartFilter.keyup(this)"
                                            />
                                        </div>
                                    </div>

                                    <div class="form-group" style="width: calc(50% - 10px);">
                                        <div class="smart-filter-input-container">
                                            <input
                                                    class="max-price form-control form-control-sm"
                                                    type="number"
                                                    name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                    id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                    value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                    size="5"
                                                    placeholder="<?= GetMessage("CT_BCSF_FILTER_TO") ?>"
                                                    onkeyup="smartFilter.keyup(this)"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="smart-filter-slider-track-container">
                                    <div class="smart-filter-slider-track" id="drag_track_<?= $key ?>">
                                        <? for ($i = 0; $i <= $step_num; $i++): ?>
                                            <div class="smart-filter-slider-ruler p<?= $i + 1 ?>">
                                                <span><?= $prices[$i] ?></span></div>
                                        <? endfor; ?>
                                        <div class="smart-filter-slider-price-bar-vd" style="left: 0;right: 0;"
                                             id="colorUnavailableActive_<?= $key ?>"></div>
                                        <div class="smart-filter-slider-price-bar-vn" style="left: 0;right: 0;"
                                             id="colorAvailableInactive_<?= $key ?>"></div>
                                        <div class="smart-filter-slider-price-bar-v" style="left: 0;right: 0;"
                                             id="colorAvailableActive_<?= $key ?>"></div>
                                        <div class="smart-filter-slider-range" id="drag_tracker_<?= $key ?>"
                                             style="left: 0; right: 0;">
                                            <a class="smart-filter-slider-handle left" style="left:0;"
                                               href="javascript:void(0)" id="left_slider_<?= $key ?>"></a>
                                            <a class="smart-filter-slider-handle right" style="right:0;"
                                               href="javascript:void(0)" id="right_slider_<?= $key ?>"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

        $counter2 = 0;
        foreach ($arResult["ITEMS"] as $key => $arItem) {
        if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
            continue;

        if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
            continue;
        ?>
        <? if ($counter2 == 4){ ?>
        <div class="collapse" id="moreFilterSettings">
            <?
            } ?>

            <?
            $arCur = current($arItem["VALUES"]);
            switch ($arItem["DISPLAY_TYPE"]) {
                //region NUMBERS_WITH_SLIDER +
                case "A":
                    ?>
                    <div class="d-block mb-3">
                        <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                           data-toggle="collapse" href="#collapsePrice" role="button" aria-expanded="true"
                           aria-controls="collapsePrice">
                            <span class="d-flex justify-content-between align-items-center"><i
                                        class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i>Price</span>
                        </p>
                        <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"><? echo $arItem['FILTER_HINT'] ?></p>

                        <div id="collapsePrice" class="collapse show">
                            <?if($arItem['CODE'] == 'PRICE'){?>
                            <ul>
                                <li>
                                    <a href="?<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>=250&<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>=1&set_filter=Показать">Under <?= ICON_CURRENCY ?>
                                        250</a>
                                </li>

                                <li>
                                    <a href="?<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>=500&<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>=250&set_filter=Показать"><?= ICON_CURRENCY ?>
                                        250 to <?= ICON_CURRENCY ?>500</a>
                                </li>

                                <li>
                                    <a href="?<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>=1000&<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>=500&set_filter=Показать"><?= ICON_CURRENCY ?>
                                        500 to <?= ICON_CURRENCY ?>1000</a>
                                </li>

                                <li>
                                    <a href="?<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>=2000&<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>=1000&set_filter=Показать"><?= ICON_CURRENCY ?>
                                        1000 to <?= ICON_CURRENCY ?>2000</a>
                                </li>

                                <li>
                                    <a href="?<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>=2000&set_filter=Показать"><?= ICON_CURRENCY ?>
                                        2000 &amp; Above</a>
                                </li>
                            </ul>
                            <?}?>
                            <div class="form-group">
                                <div class="mb-4 form-row">
                                    <div class="col">
                                        <input type="text" onkeyup="smartFilter.keyup(this)"
                                               name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                               value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                               id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                               class="form-control" placeholder="Max"
                                               data-range-max-connected="rangeSlider<?=$arItem['CODE']?>">
                                    </div>

                                    <div class="col">
                                        <input type="text" onkeyup="smartFilter.keyup(this)" class="form-control"
                                               name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                               value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                               id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>" placeholder="Min"
                                               data-range-min-connected="rangeSlider<?=$arItem['CODE']?>">
                                    </div>
                                </div>

                                <div class="mb-3" id="rangeSlider<?=$arItem['CODE']?>"
                                     data-range-min="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                     data-range-max="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>"></div>
                                <script>new RangeSlider('rangeSlider<?=$arItem['CODE']?>');</script>
                                <div class="row px-2 d-flex justify-content-between">
                                    <span><?= $arItem["VALUES"]["MAX"]["VALUE"] ?></span>
                                    <span><?= $arItem["VALUES"]["MIN"]["VALUE"] ?></span>
                                </div>
                                <script>
                                    $('.noUi-handle-upper').mouseup(function () {
                                        smartFilter.keyup(BX('<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>'));
                                    })
                                    $('.noUi-handle-lower').mouseup(function () {
                                        smartFilter.keyup(BX('<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>'))
                                    })
                                </script>
                            </div>

                        </div>
                    </div>
                    <?

                    break;

                //endregion

                //region NUMBERS +
                case "B":
                    ?>
                    <div class="d-block mb-3">
                        <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                           data-toggle="collapse" href="#collapsePrice" role="button" aria-expanded="true"
                           aria-controls="collapsePrice">
                            <span class="d-flex justify-content-between align-items-center"><i
                                        class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i>Price</span>
                        </p>
                        <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"><? echo $arItem['FILTER_HINT'] ?></p>

                        <div id="collapsePrice" class="collapse show">

                            <div class="form-group">
                                <div class="mb-4 form-row">
                                    <div class="col">
                                        <input type="text"
                                               onkeyup="smartFilter.keyup(this)"
                                               name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                               value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                               id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                               class="form-control"
                                               placeholder="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                               data-range-max-connected="rangeSlider">
                                    </div>
                                    <div class="col">
                                        <input type="text"
                                               onkeyup="smartFilter.keyup(this)"
                                               class="form-control"
                                               name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                               value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                               id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                               placeholder="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                               data-range-min-connected="rangeSlider">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?
                    break;
                //endregion

                //region CHECKBOXES_WITH_PICTURES +
                case "G":
                    ?>
                    <div class="mb-4 pb-4 border-bottom">
                        <p class="h5 mb-3 d-block text-uppercase font-weight-bolder">Colour</p>

                        <div class="d-flex flex-wrap palette">
                            <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                <input onclick="smartFilter.keyup(this)" type="radio" class="d-none" name="color"
                                       id="<?= $ar["CONTROL_ID"] ?>" value="<?= $ar["HTML_VALUE"] ?>">
                                <label class="colour-element" for="<?= $ar["CONTROL_ID"] ?>"
                                       style="background: #<?= $val ?>;"></label>
                            <? endforeach ?>
                        </div>
                    </div>
                    <!--<div class="smart-filter-input-group-checkbox-pictures">
                    <?/* foreach ($arItem["VALUES"] as $val => $ar):*/
                    ?>
                        <input
                                style="display: none"
                                type="checkbox"
                                name="<?/*= $ar["CONTROL_NAME"] */
                    ?>"
                                id="<?/*= $ar["CONTROL_ID"] */
                    ?>"
                                value="<?/*= $ar["HTML_VALUE"] */
                    ?>"
                            <?/* echo $ar["CHECKED"] ? 'checked="checked"' : '' */
                    ?>
                        />
                        <?/*
                        $class = "";
                        if ($ar["CHECKED"])
                            $class .= " bx-active";
                        if ($ar["DISABLED"])
                            $class .= " disabled";
                        */
                    ?>
                        <label for="<?/*= $ar["CONTROL_ID"] */
                    ?>"
                               data-role="label_<?/*= $ar["CONTROL_ID"] */
                    ?>"
                               class="smart-filter-checkbox-label<?/*= $class */
                    ?>"
                               onclick="smartFilter.keyup(BX('<?/*= CUtil::JSEscape($ar["CONTROL_ID"]) */
                    ?>')); BX.toggleClass(this, 'bx-active');">
												<span class="smart-filter-checkbox-btn bx-color-sl">
													<?/* if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):*/
                    ?>
                                                        <span class="smart-filter-checkbox-btn-image"
                                                              style="background-image: url('<?/*= $ar["FILE"]["SRC"] */
                    ?>');"></span>
                                                    <?/*endif */
                    ?>
												</span>
                        </label>
                    <?/*endforeach */
                    ?>
                    <div style="clear: both;"></div>
                </div>-->
                    <?
                    break;
                //endregion

                //region CHECKBOXES_WITH_PICTURES_AND_LABELS +
                case "H":
                    ?>

                    <div class="smart-filter-input-group-checkbox-pictures-text">
                        <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                            <input
                                    style="display: none"
                                    type="checkbox"
                                    name="<?= $ar["CONTROL_NAME"] ?>"
                                    id="<?= $ar["CONTROL_ID"] ?>"
                                    value="<?= $ar["HTML_VALUE"] ?>"
                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                            />
                            <?
                            $class = "";
                            if ($ar["CHECKED"])
                                $class .= " bx-active";
                            if ($ar["DISABLED"])
                                $class .= " disabled";
                            ?>
                            <label for="<?= $ar["CONTROL_ID"] ?>"
                                   data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                   class="smart-filter-checkbox-label<?= $class ?>"
                                   onclick="smartFilter.keyup(BX('<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')); BX.toggleClass(this, 'bx-active');">
											<span class="smart-filter-checkbox-btn">
												<? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                    <span class="smart-filter-checkbox-btn-image"
                                                          style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                                <? endif ?>
											</span>
                                <span class="smart-filter-checkbox-text" title="<?= $ar["VALUE"]; ?>">
												<?= $ar["VALUE"];
                                                if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                    ?> (<span
                                                        data-role="count_<?= $ar["CONTROL_ID"] ?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
                                                endif; ?>
											</span>
                            </label>
                        <? endforeach ?>
                    </div>
                    <?
                    break;
                //endregion
                //очень лагает список проверить надо !!!
                //region DROPDOWN +
                case "P":
                    ?>
                    <? $checkedItemExist = false; ?>
                    <div class="border-bottom mb-lg-4">
                        <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                           data-toggle="collapse"
                           href="#collapseBrand" role="button" aria-expanded="true" aria-controls="collapseBrand">
                        <span class="d-flex justify-content-between align-items-center"><i
                                    class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i> Brand</span>
                        </p>
                        <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"><?= $arItem['FILTER_HINT'] ?></p>




                        <div class="collapse show" id="collapseBrand" style="margin-bottom: 20px;">
                            <div class="smart-filter-input-group-dropdown">
                                <div class="smart-filter-dropdown-block"
                                     onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                                    <div class="smart-filter-dropdown-text" data-role="currentOption">
                                        <? foreach ($arItem["VALUES"] as $val => $ar) {
                                            if ($ar["CHECKED"]) {
                                                echo $ar["VALUE"];
                                                $checkedItemExist = true;
                                            }
                                        }
                                        if (!$checkedItemExist) {
                                            echo GetMessage("CT_BCSF_FILTER_ALL");
                                        }
                                        ?>
                                    </div>
                                    <div class="smart-filter-dropdown-arrow"></div>
                                    <input
                                            style="display: none"
                                            type="radio"
                                            name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                                            id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
                                            value=""
                                    />
                                    <? foreach ($arItem["VALUES"] as $val => $ar):?>
                                        <input
                                                style="display: none"
                                                type="radio"
                                                name="<?= $ar["CONTROL_NAME_ALT"] ?>"
                                                id="<?= $ar["CONTROL_ID"] ?>"
                                                value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                        />
                                    <?endforeach ?>

                                    <div class="smart-filter-dropdown-popup" data-role="dropdownContent"
                                         style="display: none;">
                                        <ul>
                                            <li>
                                                <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                       class="smart-filter-dropdown-label smart-filter-choice"
                                                       data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                       data-name="msi"
                                                       onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
                                                    <?= GetMessage("CT_BCSF_FILTER_ALL"); ?>
                                                </label>
                                            </li>
                                            <? foreach ($arItem["VALUES"] as $val => $ar):
                                                $class = "";
                                                if ($ar["CHECKED"])
                                                    $class .= " selected";
                                                if ($ar["DISABLED"])
                                                    $class .= " disabled";
                                                ?>
                                                <li>
                                                    <label for="<?= $ar["CONTROL_ID"] ?>"
                                                           class="smart-filter-dropdown-label<?= $class ?> smart-filter-choice"
                                                           data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                           data-name="msi"
                                                           onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')">
                                                        <?= $ar["VALUE"] ?>
                                                    </label>
                                                </li>
                                            <?endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collapse show" id="collapseBrand1" style="margin-bottom: 20px;">
                            <div class="smart-filter-input-group-dropdown smart-filter-dropdown-next">
                                <div class="smart-filter-dropdown-block">
                                    <div class="smart-filter-dropdown-text filter-dropdown-next-text" data-role="currentOption">All</div>
                                    <div class="smart-filter-dropdown-arrow"></div>
                                    <input
                                            style="display: none"
                                            type="radio"
                                            name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                                            id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
                                            value=""
                                    />


                                    <div class="smart-filter-dropdown-popup-new" data-role="dropdownContent"
                                         style="display: none;">
                                        <ul id="smartFilterChoiceNew">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>

                    <?
                    break;
                //endregion

                //region DROPDOWN_WITH_PICTURES_AND_LABELS
                case "R":
                    ?>
                    <div class="smart-filter-input-group-dropdown">
                        <div class="smart-filter-dropdown-block"
                             onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                            <div class="smart-filter-input-group-dropdown-flex" data-role="currentOption">
                                <?
                                $checkedItemExist = false;
                                foreach ($arItem["VALUES"] as $val => $ar):
                                    if ($ar["CHECKED"]) {
                                        ?>
                                        <? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                            <span class="smart-filter-checkbox-btn-image"
                                                  style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                        <? endif ?>
                                        <span class="smart-filter-dropdown-text"><?= $ar["VALUE"] ?></span>
                                        <?
                                        $checkedItemExist = true;
                                    }
                                endforeach;
                                if (!$checkedItemExist) {
                                    ?>
                                    <span class="smart-filter-checkbox-btn-image all"></span>
                                    <span class="smart-filter-dropdown-text"><?= GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
                                    <?
                                }
                                ?>
                            </div>

                            <div class="smart-filter-dropdown-arrow"></div>

                            <input
                                    style="display: none"
                                    type="radio"
                                    name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                                    id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
                                    value=""
                            />
                            <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                <input
                                        style="display: none"
                                        type="radio"
                                        name="<?= $ar["CONTROL_NAME_ALT"] ?>"
                                        id="<?= $ar["CONTROL_ID"] ?>"
                                        value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                />
                            <? endforeach ?>

                            <div class="smart-filter-dropdown-popup" data-role="dropdownContent" style="display: none">
                                <ul>
                                    <li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
                                        <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                               class="smart-filter-param-label"
                                               data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                               onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
                                            <span class="smart-filter-checkbox-btn-image all"></span>
                                            <span class="smart-filter-dropdown-text"><?= GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
                                        </label>
                                    </li>
                                    <?
                                    foreach ($arItem["VALUES"] as $val => $ar):
                                        $class = "";
                                        if ($ar["CHECKED"])
                                            $class .= " selected";
                                        if ($ar["DISABLED"])
                                            $class .= " disabled";
                                        ?>
                                        <li>
                                            <label for="<?= $ar["CONTROL_ID"] ?>"
                                                   data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                   class="smart-filter-param-label<?= $class ?>"
                                                   onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')">
                                                <? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                    <span class="smart-filter-checkbox-btn-image"
                                                          style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                                <? endif ?>
                                                <span class="smart-filter-dropdown-text"><?= $ar["VALUE"] ?></span>
                                            </label>
                                        </li>
                                    <? endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?
                    break;
                //endregion

                //region RADIO_BUTTONS
                case "K":
                    ?>
                    <div class="col">
                        <div class="radio">
                            <label class="smart-filter-param-label" for="<? echo "all_" . $arCur["CONTROL_ID"] ?>">
												<span class="smart-filter-input-checkbox">
													<input
                                                            type="radio"
                                                            value=""
                                                            name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
                                                            id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
                                                            onclick="smartFilter.click(this)"
                                                    />
													<span class="smart-filter-param-text"><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
												</span>
                            </label>
                        </div>
                        <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                            <div class="radio">
                                <label data-role="label_<?= $ar["CONTROL_ID"] ?>" class="smart-filter-param-label"
                                       for="<? echo $ar["CONTROL_ID"] ?>">
													<span class="smart-filter-input-checkbox  <? echo $ar["DISABLED"] ? 'style="display: none"' : '' ?>">
														<input
                                                                type="radio"
                                                                value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                                name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
                                                                id="<? echo $ar["CONTROL_ID"] ?>"
															<? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
															onclick="smartFilter.click(this)"
                                                        />
														<span class="smart-filter-param-text"
                                                              title="<?= $ar["VALUE"]; ?>"><?= $ar["VALUE"]; ?><?
                                                            if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                                ?>&nbsp;(<span
                                                                    data-role="count_<?= $ar["CONTROL_ID"] ?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
                                                            endif; ?></span>
													</span>
                                </label>
                            </div>
                        <? endforeach; ?>
                    </div>
                    <div class="w-100"></div>
                    <?
                    break;

                //endregion

                //region CALENDAR
                case "U":
                    ?>
                    <div class="col">
                        <div class="">
                            <div class="smart-filter-input-container smart-filter-calendar-container">
                                <? $APPLICATION->IncludeComponent(
                                    'bitrix:main.calendar',
                                    '',
                                    array(
                                        'FORM_NAME' => $arResult["FILTER_NAME"] . "_form",
                                        'SHOW_INPUT' => 'Y',
                                        'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="' . FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]) . '" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
                                        'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
                                        'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                                        'SHOW_TIME' => 'N',
                                        'HIDE_TIMEBAR' => 'Y',
                                    ),
                                    null,
                                    array('HIDE_ICONS' => 'Y')
                                ); ?>
                            </div>
                        </div>
                        <div class="">
                            <div class="smart-filter-input-container smart-filter-calendar-container">
                                <? $APPLICATION->IncludeComponent(
                                    'bitrix:main.calendar',
                                    '',
                                    array(
                                        'FORM_NAME' => $arResult["FILTER_NAME"] . "_form",
                                        'SHOW_INPUT' => 'Y',
                                        'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="' . FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]) . '" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
                                        'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
                                        'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                                        'SHOW_TIME' => 'N',
                                        'HIDE_TIMEBAR' => 'Y',
                                    ),
                                    null,
                                    array('HIDE_ICONS' => 'Y')
                                ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <?
                    break;
                //endregion

                //region CHECKBOXES +
                default:
                    ?>
                <script>console.log(<?=json_encode($arResult)?>)</script>
                    <? if ($arItem['CODE'] == "PROP_5" || $arItem['CODE'] == "PROP_COLOR_Left"|| $arItem['CODE'] == "PROP_COLOR") {
                    ?>
                    <div class="mb-4 pb-4 border-bottom">
                        <p class="h5 mb-3 d-block text-uppercase font-weight-bolder">Colour</p>

                        <div class="d-flex flex-wrap palette">
                            <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                <input onclick="smartFilter.keyup(this)" type="checkbox" class="d-none" name="<?= $ar["CONTROL_NAME"] ?>"
                                       id="<?= $ar["CONTROL_ID"] ?>" value="<?= $ar["HTML_VALUE"] ?>">
                                <label class="colour-element" for="<?= $ar["CONTROL_ID"] ?>"
                                       style="background: #<?= $val ?>;"></label>
                            <? endforeach ?>
                        </div>
                    </div>
                <?
                } else {
                    ?>
                    <div class="border-bottom mb-lg-4">
                        <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                           data-toggle="collapse"
                           href="#collapseBrand" role="button" aria-expanded="true" aria-controls="collapseBrand">
                        <span class="d-flex justify-content-between align-items-center"><i
                                    class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i> Brand</span>
                        </p>
                        <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"><?= $arItem['FILTER_HINT'] ?></p>

                        <div class="collapse show" id="collapseBrand">
                            <ul>


                                <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                    <li class="mb-0 checkbox">
                                        <label>
                                            <input
                                                    type="checkbox"
                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                    onclick="smartFilter.click(this);"
                                            />
                                            <span data-role="label_<?= $ar["CONTROL_ID"] ?>" class="mr-2"
                                                  for="<? echo $ar["CONTROL_ID"] ?>">
                                                        <?= $ar["VALUE"];
                                                        if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                            ?>&nbsp;(<span
                                                                data-role="count_<?= $ar["CONTROL_ID"] ?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
                                                        endif; ?>
                                                    </span>
                                            <span class="cr"></span>
                                        </label>
                                    </li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?
                }
                //endregion
            }

            $counter2++;
            }
            ?>
            <!--//row-->

            <div style="visibility: hidden;" class="row">
                <div class="col smart-filter-button-box">
                    <div class="smart-filter-block">
                        <div class="smart-filter-parameters-box-container">
                            <input
                                    class="btn btn-primary"
                                    type="submit"
                                    id="set_filter"
                                    name="set_filter"
                                    value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>"
                            />
                            <input
                                    class="btn btn-link"
                                    type="submit"
                                    id="del_filter"
                                    name="del_filter"
                                    value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>"
                            />
                            <div class="smart-filter-popup-result <? if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL") echo $arParams["POPUP_POSITION"] ?>"
                                 id="modef" <? if (!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"'; ?>
                                 style="display: inline-block;">
                                <? echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">' . intval($arResult["ELEMENT_COUNT"]) . '</span>')); ?>
                                <span class="arrow"></span>
                                <br/>
                                <a id="target_dom" href="<? echo $arResult["FILTER_URL"] ?>"
                                   target=""><? echo GetMessage("CT_BCSF_FILTER_SHOW") ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
<? if ($counter2 > 4) { ?>
    <button class="btn btn-primary btn-more-filter-settings text-uppercase font-weight-bold collapsed" type="button"
            data-toggle="collapse" data-target="#moreFilterSettings" aria-expanded="false"
            aria-controls="moreFilterSettings">
        extra options
    </button>
<? } ?>
    <script type="text/javascript">
        var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
    </script>
<? $this->EndViewTarget(); ?>
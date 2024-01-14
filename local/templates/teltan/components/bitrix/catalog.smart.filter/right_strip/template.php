<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

$sectionsData = getSectionsForFilter($arParams['IBLOCK_ID'],$arParams['SECTION_ID']);

?>
<?php if (!empty($arResult["ITEMS"])):?>
    <div class="p-3 pt-4 pb-4 card text-right filter-select filter" id="filterModalContent">
        <div class="pb-3 mb-2 mb-lg-4 d-flex d-lg-none justify-content-between border-bottom filter-header">
            <a class="filter-closer filterTogglerMobile" type="button"><i class="mr-1 mr-lg-3 icon-clear"></i> Close</a>
            <p class="m-0 d-inline-block text-uppercase font-weight-bolder filter-title">Filters</p>
        </div>
        <form name="<?=$arParams["FILTER_NAME"] . "_form" ?>" action="<?=$arResult["FORM_ACTION"]?>" method="get" class="smart-filter-form">
            <?php foreach ($arResult["HIDDEN"] as $arItem): ?>
                <input type="hidden" name="<?=$arItem["CONTROL_NAME"]?>" id="<?=$arItem["CONTROL_ID"]?>" value="<?=$arItem["HTML_VALUE"]?>">
            <?php endforeach; ?>
            <?php // Блок с брендами авто/ мото / скутеры?>
            <?php if ($arParams['SHOW_SECTIONS'] === 'Y'):?>
                <?php if (!empty($sectionsData['SECTIONS'])):?>
                    <div class="border-bottom filter-brands-list">
                        <p class="filter-select__collapse-title h5 d-lg-block text-uppercase mb-3">Brands</p>
                        <div class="collapse show" id="collapse<?=$arItem['CODE']?>" style="margin-bottom: 20px;">
                            <div class="smart-filter-input-group-dropdown">
                                <div class="smart-filter-dropdown-block" onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                                    <div class="smart-filter-dropdown-text" data-role="currentOption">
                                        <?=!empty($sectionsData['ACTIVE']['BRAND']) ? $sectionsData['ACTIVE']['BRAND']['NAME'] : Loc::getMessage('SF_ALL') ?>
                                    </div>
                                    <div class="smart-filter-dropdown-arrow"></div>
                                    <div class="smart-filter-dropdown-popup" data-role="dropdownContent" style="display: none;">
                                        <ul>
                                            <?php if (!empty($arParams['ROOT_SECTION_URL'])):?>
                                                <li  <?=empty($sectionsData['ACTIVE']['BRAND']) ? 'class="selected"' : ''?>>
                                                    <label class="smart-filter-dropdown-label smart-filter-choice"
                                                           onclick="window.location.href = '<?=$arParams['ROOT_SECTION_URL']?>'"
                                                    >
                                                        <?=Loc::getMessage('SF_ALL')?>
                                                    </label>
                                                </li>
                                            <?php endif;?>
                                            <?php foreach ($sectionsData['SECTIONS'] as $sect):?>
                                                <li <?=$sectionsData['ACTIVE']['BRAND']['ID'] == $sect['ID'] ? 'class="selected"' : ''?>>
                                                    <label for="<?= "all_" . $arCur["CONTROL_ID"]?>"
                                                           class="smart-filter-dropdown-label smart-filter-choice"
                                                           data-role="label_<?= "all_" . $arCur["CONTROL_ID"]?>"
                                                           data-name="<?=$sect['CODE']?>"
                                                           onclick="window.location.href = '<?=$sect['SECTION_PAGE_URL']?>'">
                                                        <?=$sect['NAME']?>
                                                    </label>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($sectionsData['ACTIVE']['BRAND']) && !empty($sectionsData['SECTIONS'][$sectionsData['ACTIVE']['BRAND']['ID']]['ITEMS'])):?>
                            <p class="filter-select__collapse-title h5  d-lg-block text-uppercase mb-3">Model</p>
                            <div class="collapse show" id="collapse<?=$arItem['CODE']?>1" style="margin-bottom: 20px;">
                                <div class="smart-filter-input-group-dropdown smart-filter-dropdown-next">
                                    <div class="smart-filter-dropdown-block">
                                        <div class="smart-filter-dropdown-text filter-dropdown-next-text" data-role="currentOption">
                                            <?=!empty($sectionsData['ACTIVE']['MODEL']) ? $sectionsData['ACTIVE']['MODEL']['NAME'] : Loc::getMessage('SF_ALL') ?>
                                        </div>
                                        <div class="smart-filter-dropdown-arrow"></div>
                                        <div class="smart-filter-dropdown-popup-new popup-window" data-role="dropdownContent" style="display: none;">
                                            <ul id="smartFilterChoiceNew">
                                                <?php if (!empty($sectionsData['ACTIVE']['BRAND']['SECTION_PAGE_URL'])):?>
                                                    <li <?=empty($sectionsData['ACTIVE']['MODEL']) ? 'class="selected"' : ''?>>
                                                        <label class="smart-filter-dropdown-label smart-filter-choice"
                                                               onclick="window.location.href = '<?=$sectionsData['ACTIVE']['BRAND']['SECTION_PAGE_URL']?>'"
                                                        >
                                                            <?=Loc::getMessage('SF_ALL')?>
                                                        </label>
                                                    </li>
                                                <?php endif;?>
                                                <?php foreach ($sectionsData['SECTIONS'][$sectionsData['ACTIVE']['BRAND']['ID']]['ITEMS'] as $subsection):?>
                                                    <li <?=$sectionsData['ACTIVE']['MODEL']['ID'] == $subsection['ID'] ? 'class="selected"' : ''?>>
                                                        <label for="<?= "all_" . $arCur["CONTROL_ID"]?>2"
                                                               class="smart-filter-dropdown-label smart-filter-choice"
                                                               data-role="label_<?= "all_" . $arCur["CONTROL_ID"]?>2"
                                                               data-name="<?=$subsection['CODE']?>"
                                                               onclick="window.location.href = '<?=$subsection['SECTION_PAGE_URL']?>'">
                                                            <?=$subsection['NAME']?>
                                                        </label>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endif; ?>
            <?php endif;?>
            <?php
            $counter = 0;
            foreach ($arResult["ITEMS"] as $key => $arItem):
                 if ($counter === FILTER_EXTRA_SHOW_COUNT):
                    $extraOptions = true;?>
                    <div class="collapse <?=$counter?>" id="moreFilterSettings">
                <?php endif;
                    $counter++;
                    $arCur = current($arItem["VALUES"]);
                    switch ($arItem["DISPLAY_TYPE"]):
                        case "A":?>
                            <?php if ($arItem['CODE'] == 'PRICE' && $arItem['VALUES']['MIN']['VALUE'] != $arItem['VALUES']['MAX']['VALUE']):?>
                                <div class="d-block mt-4 border-bottom price-block">
                                    <p class="filter-select__collapse-title h5 d-block text-uppercase mb-3"
                                       data-toggle="collapse"
                                       data-collapse-id="<?=$arItem['CODE']?>"
                                       href="#collapse<?=$arItem['CODE']?>"
                                       role="button"
                                       aria-expanded="true"
                                       aria-controls="collapse<?=$arItem['CODE']?>"
                                    >
                                        <span class="d-flex justify-content-between align-items-center">
                                            <i class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i>
                                            PRICE
                                        </span>
                                    </p>
                                    <div id="collapse<?=$arItem['CODE']?>" class="collapse show">
                                        <div class="form-group">
                                            <div class="mb-4 form-row">
                                                <div class="col">
                                                    <input type="text"
                                                           onkeyup="smartFilter.keyup(this)"
                                                           class="form-control"
                                                           name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                           value="<?=!empty($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"]?>"
                                                           id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                                           placeholder="Max"
                                                           data-range-max-connected="rangeSlider<?=$arItem['CODE']?>">
                                                </div>

                                                <div class="col">
                                                    <input type="text"
                                                           onkeyup="smartFilter.keyup(this)"
                                                           class="form-control"
                                                           name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                           value="<?=!empty($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"]?>"
                                                           id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                                           placeholder="Min"
                                                           data-range-min-connected="rangeSlider<?=$arItem['CODE']?>">
                                                </div>
                                            </div>
                                            <?php
                                            // $arItem["VALUES"]["MIN"]["HTML_VALUE"] миниамальное выбранное
                                            // $arItem["VALUES"]["MAX"]["HTML_VALUE"] максимальное выбранное
                                            // $arItem["VALUES"]["MIN"]["VALUE"] минимальное что есть
                                            // $arItem["VALUES"]["MAX"]["VALUE"] максимальное что есть
                                            ?>
                                            <div class="mb-3" id="rangeSlider<?=$arItem['CODE']?>"
                                                 data-range-min="<?=$arItem["VALUES"]["MIN"]["VALUE"]?>"
                                                 data-range-max="<?=$arItem["VALUES"]["MAX"]["VALUE"]?>"
                                            ></div>
                                            <script>
                                                new RangeSlider('rangeSlider<?=$arItem['CODE']?>');
                                            </script>
                                            <div class="row px-2 d-flex justify-content-between">
                                                <span><?=$arItem["VALUES"]["MAX"]["VALUE"]?></span>
                                                <span><?=$arItem["VALUES"]["MIN"]["VALUE"]?></span>
                                            </div>
                                            <script>
                                                $('.noUi-handle-upper').mouseup(function () {
                                                    smartFilter.keyup(BX('<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>'));
                                                })
                                                $('.noUi-handle-lower').mouseup(function () {
                                                    smartFilter.keyup(BX('<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>'))
                                                })

                                                function triggerKeyup() {
                                                    smartFilter.keyup(BX('<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>'))
                                                    smartFilter.keyup(BX('<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>'));
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php break;
                        case "B":?>
                            <div class="d-block mb-3">
                                <p class="filter-select__collapse-title h5 d-block text-uppercase"
                                   data-toggle="collapse"
                                   href="#collapse<?=$arItem['CODE']?>"
                                   data-collapse-id="<?=$arItem['CODE']?>"
                                   role="button"
                                   aria-expanded="true"
                                   aria-controls="collapse<?=$arItem['CODE']?>">
                                <span class="d-flex justify-content-between align-items-center"><i
                                            class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i><?=$arItem['FILTER_HINT']?></span>
                                </p>
                                <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"><?=$arItem['FILTER_HINT']?></p>

                                <div id="collapse<?=$arItem['CODE']?>" class="collapse show">

                                    <div class="form-group">
                                        <div class="mb-4 form-row">
                                            <div class="col">
                                                <input type="text"
                                                       onkeyup="smartFilter.keyup(this)"
                                                       name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                       value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                                       id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                                       class="form-control"
                                                       placeholder="<?=$arItem["VALUES"]["MAX"]["VALUE"]?>"
                                                >
                                            </div>
                                            <div class="col">
                                                <input type="text"
                                                       onkeyup="smartFilter.keyup(this)"
                                                       class="form-control"
                                                       name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                       value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                                       id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                                       placeholder="<?=$arItem["VALUES"]["MIN"]["VALUE"]?>"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php break;
                        case "G":?>
                            <div class="mt-4 border-bottom">
                                <p class="h5 mb-3 d-block text-uppercase font-weight-bolder">Color</p>

                                <div class="d-flex flex-wrap palette">
                                    <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                        <input onclick="smartFilter.keyup(this)"
                                            type="radio" class="d-none"
                                            name="color"
                                            id="<?=$ar["CONTROL_ID"]?>"
                                            value="<?=$ar["HTML_VALUE"]?>"
                                            <?= ($ar['CHECKED']) ? 'checked' : '' ?>
                                        >
                                        <label class="colour-element"
                                               for="<?=$ar["CONTROL_ID"]?>"
                                               style="background: #<?=$val ?>;"
                                        >

                                        </label>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        <?php break;
                        case "H":?>
                            <div class="smart-filter-input-group-checkbox-pictures-text">
                                <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                    <input
                                            style="display: none"
                                            type="checkbox"
                                            name="<?=$ar["CONTROL_NAME"]?>"
                                            id="<?=$ar["CONTROL_ID"]?>"
                                            value="<?=$ar["HTML_VALUE"]?>"
                                        <?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                    />
                                    <?php
                                    $class = "";
                                    if ($ar["CHECKED"])
                                        $class .= " bx-active";
                                    if ($ar["DISABLED"])
                                        $class .= " disabled";
                                    ?>
                                    <label for="<?=$ar["CONTROL_ID"]?>"
                                           data-role="label_<?=$ar["CONTROL_ID"]?>"
                                           class="smart-filter-checkbox-label<?=$class ?>"
                                           onclick="smartFilter.keyup(BX('<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')); BX.toggleClass(this, 'bx-active');">
                                                <span class="smart-filter-checkbox-btn">
                                                    <?php if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                        <span class="smart-filter-checkbox-btn-image"
                                                              style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                                    <?php endif ?>
                                                </span>
                                        <span class="smart-filter-checkbox-text" title="<?=$ar["VALUE"]; ?>">
                                                    <?=$ar["VALUE"];
                                                    if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                        ?> (<span
                                                            data-role="count_<?=$ar["CONTROL_ID"]?>"><?=$ar["ELEMENT_COUNT"]; ?></span>)<?php
                                                    endif; ?>
                                                </span>
                                    </label>
                                <?php endforeach ?>
                            </div>
                        <?php break;
                        // Выпадающие списки select
                        case "P":
                            $checkedItemExist = false; ?>
                            <div class="border-bottom mt-4">
                                <p class="filter-select__collapse-title h5 d-block text-uppercase mb-3"
                                   data-toggle="collapse"
                                   href="#collapse<?=$arItem['CODE']?>"
                                   data-collapse-id="<?=$arItem['CODE']?>"
                                   role="button"
                                   aria-expanded="true"
                                   aria-controls="collapse<?=$arItem['CODE']?>"
                                >
                                    <span class="d-flex justify-content-between align-items-center">
                                        <i class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i>
                                        <?=$arItem['FILTER_HINT']?>
                                    </span>
                                </p>
                                <div class="collapse show" id="collapse<?=$arItem['CODE']?>" style="margin-bottom: 20px;">
                                    <div class="smart-filter-input-group-dropdown">
                                        <div class="smart-filter-dropdown-block" onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                                            <div class="smart-filter-dropdown-text currentOption<?=$arItem['CODE']?>" data-role="currentOption">
                                                <?=!empty($arItem['CHECKED_VALUE']) ? $arItem['CHECKED_VALUE'] :  Loc::getMessage("SF_ALL"); ?>
                                            </div>
                                            <div class="smart-filter-dropdown-arrow"></div>
                                            <input style="display: none"
                                                    type="radio"
                                                    name="<?=$arCur["CONTROL_NAME_ALT"]?>"
                                                    id="<?="all_" . $arCur["CONTROL_ID"]?>"
                                                    value=""
                                            >
                                            <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                                <input style="display: none"
                                                        type="radio"
                                                        name="<?=$ar["CONTROL_NAME_ALT"]?>"
                                                        id="<?=$ar["CONTROL_ID"]?>"
                                                        value="<?=$ar["HTML_VALUE_ALT"]?>"
                                                    <?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                >
                                            <?php endforeach ?>
                                            <div class="smart-filter-dropdown-popup" data-role="dropdownContent" style="display: none;">
                                                <ul>
                                                    <li <?=empty($arItem['CHECKED_VALUE']) ? 'class="selected"' : ''?>>
                                                        <label for="<?= "all_" . $arCur["CONTROL_ID"]?>"
                                                               class="smart-filter-dropdown-label smart-filter-choice"
                                                               data-role="label_<?= "all_" . $arCur["CONTROL_ID"]?>"
                                                               data-name="<?=$arItem['CODE']?>"
                                                               onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>', '.currentOption<?=$arItem['CODE']?>')">
                                                               <?=Loc::getMessage("SF_ALL"); ?>
                                                        </label>
                                                    </li>
                                                    <?php foreach ($arItem["VALUES"] as $code => $value):
                                                        $class = "";
                                                        if ($value["CHECKED"])
                                                            $class .= " selected";
                                                        if ($value["DISABLED"])
                                                            $class .= " disabled";
                                                        ?>
                                                        <li <?=!empty($class) ? 'class="'.$class.'"' : ''?>>
                                                            <label for="<?=$value["CONTROL_ID"]?>"
                                                                   class="smart-filter-dropdown-label<?=$class ?> smart-filter-choice"
                                                                   data-role="label_<?=$value["CONTROL_ID"]?>"
                                                                   data-name="<?=$arItem['CODE']?>"
                                                                   onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($value["CONTROL_ID"]) ?>', '.currentOption<?=$arItem['CODE']?>'); ">
                                                                <?=$value["VALUE"]?>
                                                            </label>
                                                        </li>
                                                    <?php endforeach ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php break;
                        case "R":?>
                            <div class="smart-filter-input-group-dropdown">
                                <div class="smart-filter-dropdown-block"
                                     onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                                    <div class="smart-filter-input-group-dropdown-flex" data-role="currentOption">
                                        <?php
                                        $checkedItemExist = false;
                                        foreach ($arItem["VALUES"] as $val => $ar):
                                            if ($ar["CHECKED"]) {
                                                ?>
                                                <?php if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                    <span class="smart-filter-checkbox-btn-image"
                                                          style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                                <?php endif ?>
                                                <span class="smart-filter-dropdown-text"><?=$ar["VALUE"]?></span>
                                                <?php
                                                $checkedItemExist = true;
                                            }
                                        endforeach;
                                        if (!$checkedItemExist) {
                                            ?>
                                            <span class="smart-filter-checkbox-btn-image all"></span>
                                            <span class="smart-filter-dropdown-text"><?=Loc::getMessage("CT_BCSF_FILTER_ALL"); ?></span>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="smart-filter-dropdown-arrow"></div>
                                    <input
                                            style="display: none"
                                            type="radio"
                                            name="<?=$arCur["CONTROL_NAME_ALT"]?>"
                                            id="<?="all_" . $arCur["CONTROL_ID"]?>"
                                            value=""
                                    />
                                    <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                        <input
                                                style="display: none"
                                                type="radio"
                                                name="<?=$ar["CONTROL_NAME_ALT"]?>"
                                                id="<?=$ar["CONTROL_ID"]?>"
                                                value="<?=$ar["HTML_VALUE_ALT"]?>"
                                            <?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                        />
                                    <?php endforeach ?>

                                    <div class="smart-filter-dropdown-popup" data-role="dropdownContent"
                                         style="display: none">
                                        <ul>
                                            <li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
                                                <label for="<?= "all_" . $arCur["CONTROL_ID"]?>"
                                                       class="smart-filter-param-label"
                                                       data-role="label_<?= "all_" . $arCur["CONTROL_ID"]?>"
                                                       onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
                                                    <span class="smart-filter-checkbox-btn-image all"></span>
                                                    <span class="smart-filter-dropdown-text"><?=Loc::getMessage("CT_BCSF_FILTER_ALL"); ?></span>
                                                </label>
                                            </li>
                                            <?php
                                            foreach ($arItem["VALUES"] as $val => $ar):
                                                $class = "";
                                                if ($ar["CHECKED"])
                                                    $class .= " selected";
                                                if ($ar["DISABLED"])
                                                    $class .= " disabled";
                                                ?>
                                                <li>
                                                    <label for="<?=$ar["CONTROL_ID"]?>"
                                                           data-role="label_<?=$ar["CONTROL_ID"]?>"
                                                           class="smart-filter-param-label<?=$class ?>"
                                                           onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')">
                                                        <?php if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                            <span class="smart-filter-checkbox-btn-image"
                                                                  style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                                        <?php endif ?>
                                                        <span class="smart-filter-dropdown-text"><?=$ar["VALUE"]?></span>
                                                    </label>
                                                </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php break;
                        case "K":?>
                            <div class="col">
                                <div class="radio">
                                    <label class="smart-filter-param-label" for="<?="all_" . $arCur["CONTROL_ID"]?>">
                                                    <span class="smart-filter-input-checkbox">
                                                        <input
                                                                type="radio"
                                                                value=""
                                                                name="<?=$arCur["CONTROL_NAME_ALT"]?>"
                                                                id="<?="all_" . $arCur["CONTROL_ID"]?>"
                                                                onclick="smartFilter.click(this)"
                                                        />
                                                        <span class="smart-filter-param-text"><?=GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
                                                    </span>
                                    </label>
                                </div>
                                <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                    <div class="radio">
                                        <label data-role="label_<?=$ar["CONTROL_ID"]?>" class="smart-filter-param-label"
                                               for="<?=$ar["CONTROL_ID"]?>">
                                                        <span class="smart-filter-input-checkbox  <?=$ar["DISABLED"] ? 'style="display: none"' : '' ?>">
                                                            <input
                                                                    type="radio"
                                                                    value="<?=$ar["HTML_VALUE_ALT"]?>"
                                                                    name="<?=$ar["CONTROL_NAME_ALT"]?>"
                                                                    id="<?=$ar["CONTROL_ID"]?>"
                                                                <?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                onclick="smartFilter.click(this)"
                                                            />
                                                            <span class="smart-filter-param-text"
                                                                  title="<?=$ar["VALUE"]; ?>"><?=$ar["VALUE"]; ?><?php
                                                                if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                                    ?>&nbsp;(<span
                                                                        data-role="count_<?=$ar["CONTROL_ID"]?>"><?=$ar["ELEMENT_COUNT"]; ?></span>)<?php
                                                                endif; ?></span>
                                                        </span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="w-100"></div>
                        <?php break;
                        case "U":?>
                            <div class="col">
                                <div class="">
                                    <div class="smart-filter-input-container smart-filter-calendar-container">
                                        <?php $APPLICATION->IncludeComponent(
                                            'bitrix:main.calendar',
                                            '',
                                            array(
                                                'FORM_NAME' => $arParams["FILTER_NAME"] . "_form",
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
                                        <?php $APPLICATION->IncludeComponent(
                                            'bitrix:main.calendar',
                                            '',
                                            array(
                                                'FORM_NAME' => $arParams["FILTER_NAME"] . "_form",
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
                        <?php break;
                        default:
                            if ($arItem['CODE'] == "PROP_5" || $arItem['CODE'] == "PROP_COLOR_Left" || $arItem['CODE'] == "PROP_COLOR" || $arItem['CODE'] == "PROP_COLOUR"):?>
                                <div class="mt-4 pb-3 border-bottom">
                                    <p class="filter-select__collapse-title h5 d-block text-uppercase mb-3"
                                       data-toggle="collapse"
                                       href="#collapse<?=$arItem['CODE']?>"
                                       data-collapse-id="<?=$arItem['CODE']?>"
                                       role="button"
                                       aria-expanded="true"
                                       aria-controls="collapse<?=$arItem['CODE']?>"
                                    >
                                        <span class="d-flex justify-content-between align-items-center">
                                            <i class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i>
                                            <?=$arItem['FILTER_HINT']?>
                                        </span>
                                    </p>
                                    <div class="collapse show" id="collapse<?=$arItem['CODE']?>">
                                        <div style="flex-direction: row-reverse;" class="d-flex flex-wrap palette">
                                            <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                                <input <?= ($ar['CHECKED']) ? 'checked' : '' ?>
                                                        onclick="smartFilter.keyup(this)" type="checkbox" class="d-none"
                                                        name="<?=$ar["CONTROL_NAME"]?>"
                                                        id="<?=$ar["CONTROL_ID"]?>"
                                                        value="<?=$ar["HTML_VALUE"]?>"
                                                >
                                                <label class="colour-element"
                                                       for="<?=$ar["CONTROL_ID"]?>"
                                                       style="background: #<?=$val ?>;"
                                                >

                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            <?php else:?>
                                <div class="border-bottom mt-4">
                                    <p class="filter-select__collapse-title h5 d-block text-uppercase mb-3"
                                       data-toggle="collapse"
                                       href="#collapse<?=$arItem['CODE']?>"
                                       data-collapse-id="<?=$arItem['CODE']?>"
                                       role="button"
                                       aria-expanded="true"
                                       aria-controls="collapse<?=$arItem['CODE']?>"
                                    >
                                        <span class="d-flex justify-content-between align-items-center">
                                            <i class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i>
                                            <?=$arItem['FILTER_HINT']?>
                                        </span>
                                    </p>
                                    <div class="collapse show" id="collapse<?=$arItem['CODE']?>">
                                        <ul>
                                            <?php foreach ($arItem["VALUES"] as $val => $ar): ?>
                                                <li class="mb-0 checkbox">
                                                    <label>
                                                        <input
                                                            type="checkbox"
                                                            value="<?=$ar["HTML_VALUE"]?>"
                                                            name="<?=$ar["CONTROL_NAME"]?>"
                                                            id="<?=$ar["CONTROL_ID"]?>"
                                                            <?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                            onclick="smartFilter.click(this);"
                                                        />
                                                        <span data-role="label_<?=$ar["CONTROL_ID"]?>" class="mr-2" for="<?=$ar["CONTROL_ID"]?>">
                                                            <?=$ar["VALUE"];?>
                                                        </span>
                                                        <span class="cr"></span>
                                                    </label>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif;?>
                        <?php break;?>
                    <?php endswitch;?>
                <?php // Закрываем "дополнительные фильтры"?>
                <?php if ($key === array_key_last($arResult['ITEMS']) && isset($extraOptions) && $extraOptions === true):?></div><?php endif;?>
            <?php endforeach;?>
        </form>
        <?php if (isset($extraOptions) && $extraOptions === true) :?>
            <button class="btn btn-primary btn-more-filter-settings text-uppercase font-weight-bold collapsed" type="button"
                    data-toggle="collapse" data-target="#moreFilterSettings" aria-expanded="false"
                    aria-controls="moreFilterSettings">
                extra options
            </button>
        <?php endif;?>
    </div>
<?php endif;?>
<script type="text/javascript">
    let smartFilter = new JCSmartFilter('<?=CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
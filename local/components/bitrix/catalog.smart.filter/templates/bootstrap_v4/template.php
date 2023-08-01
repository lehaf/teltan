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
require($_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php");
$detect = new Mobile_Detect;
$templateData = array(
    'TEMPLATE_CLASS' => 'bx-' . $arParams['TEMPLATE_THEME']
);

//$iblockSectionEntity= \Bitrix\Iblock\Model\Section::compileEntityByIblock($arParams['IBLOCK_ID']);
//$sections = $iblockSectionEntity::getList(array(
//    "filter" => array('ACTIVE' => 'Y'),
//    "select" => array("*","UF_*"),
//    "cache" => [
//        'ttl' => 3600000,
//        "cache_joins" => true
//    ]
//))->fetchAll();

$res = CIBlockSection::GetList(
    array(),
    array(
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'ACTIVE' => 'Y',
        "CNT_ACTIVE" => "Y"
    ),
    true,
    array('UF_*')
);
$sectionParent = 'BRAND';
$modelName = 'MODEL';
while ($row = $res->GetNext()) {
    $count = $row['ELEMENT_CNT'];
    if ($count > 0) {
        if (empty($row['IBLOCK_SECTION_ID'])) {
            $arSections[$row['NAME']] = $row;
            if ($row['ID'] == $arParams['SECTION_ID']) {
                $sectonParant = $row['~NAME'];
                $searchId = $row['ID'];
            }
        } else {
            if ($row['ID'] == $arParams['SECTION_ID']) {
                $searchId = $row['IBLOCK_SECTION_ID'];
            }
        }

        $rsParentSection = CIBlockSection::GetByID($searchId);
        if ($arParentSection = $rsParentSection->GetNext()) {
            $arFilter = array(
                'IBLOCK_ID' => $arParentSection['IBLOCK_ID'],
                '>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'], '<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],
                '>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL'],
                "CNT_ACTIVE" => "Y"
            ); // выберет потомков без учета активности
            $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'), $arFilter, true);
            while ($arSect = $rsSect->GetNext()) {
                if ($arSect['ELEMENT_CNT'] > 0) {

                    if (empty($row['IBLOCK_SECTION_ID'])) {
                        $arSections[$row['NAME']]['SUB_SECTIONS'][$arSect['NAME']] = $arSect;
                    }

                    $arSubSections[$arSect['NAME']] = $arSect;
                    if ($arSect['ID'] == $arParams['SECTION_ID']) {
                        $res = CIBlockSection::GetByID($arSect["IBLOCK_SECTION_ID"]);
                        if ($ar_res = $res->GetNext())
                            $sectonParant = $ar_res['NAME'];
                        $modelName = $arSect['NAME'];
                    }
                }
            }
        }
    }
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

        <?php
        if ($arResult['ITEMS'][searchForId('PRICE', $arResult['ITEMS'])]['VALUES']['MAX']['VALUE'] == $arResult['ITEMS'][searchForId('PRICE', $arResult['ITEMS'])]['VALUES']['MIN']['VALUE']) {
            $showBrand = true;
        }
        if ($showBrand && !CSite::InDir('/flea/')) { ?>
            <div class="border-bottom mb-lg-4">
                <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                   data-toggle="collapse"
                   href="#collapse<?= $arItem['CODE'] ?>" role="button" aria-expanded="true"
                   aria-controls="collapse<?= $arItem['CODE'] ?>">
                        <span class="d-flex justify-content-between align-items-center"><i
                                    class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i> <? echo $arItem['FILTER_HINT'] ?></span>
                </p>

                <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase">Brands</p>

                <div class="collapse show" id="collapse<?= $arItem['CODE'] ?>" style="margin-bottom: 20px;">
                    <div class="smart-filter-input-group-dropdown">
                        <div class="smart-filter-dropdown-block"
                             onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                            <div class="smart-filter-dropdown-text"
                                 data-role="currentOption"><?= ($sectonParant) ? $sectonParant : 'All' ?></div>
                            <div class="smart-filter-dropdown-arrow"></div>

                            <div class="smart-filter-dropdown-popup" data-role="dropdownContent"
                                 style="display: none;">
                                <ul>
                                    <? foreach ($arSections as $arSection) { ?>
                                        <li>
                                            <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                   class="smart-filter-dropdown-label smart-filter-choice"
                                                   data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                   data-name="<?= $arSection['CODE'] ?>"
                                                   onclick="window.location.href = '<?= $arSection['SECTION_PAGE_URL'] ?>/'">
                                                <?= $arSection['NAME'] ?>
                                            </label>
                                        </li>
                                        <?
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="collapse<?= $arItem['CODE'] ?>1" style="margin-bottom: 20px;">
                    <div class="smart-filter-input-group-dropdown smart-filter-dropdown-next">
                        <div class="smart-filter-dropdown-block">
                            <div class="smart-filter-dropdown-text filter-dropdown-next-text"
                                 data-role="currentOption"><?= $modelName ?></div>
                            <div class="smart-filter-dropdown-arrow"></div>
                            <input
                                    style="display: none"
                                    type="radio"
                                    name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                                    id="<? echo "all_" . $arCur["CONTROL_ID"] ?>2"
                                    value=""
                            />


                            <div class="smart-filter-dropdown-popup-new" data-role="dropdownContent"
                                 style="display: none;">
                                <ul id="smartFilterChoiceNew">
                                    <?

                                    foreach ($arSubSections as $arrSection) {
                                        ?>
                                        <li>

                                            <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>2"
                                                   class="smart-filter-dropdown-label smart-filter-choice"
                                                   data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>2"
                                                   data-name="<?= $arrSection['CODE'] ?>"
                                                   onclick="window.location.href = '<?= $arrSection['SECTION_PAGE_URL'] ?>/'">
                                                <?= $arrSection['NAME'] ?>
                                            </label>
                                        </li>
                                        <?
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?}
        $counter2 = 0;
        foreach ($arResult["ITEMS"] as $key => $arItem) {
        if ($_SERVER['SCRIPT_URL'] == '/flea/' && $arItem['CODE'] != 'PRICE') {
            continue;
        }
        if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
            continue;

        if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
            continue;


         if ($counter2 == FILTER_EXTRA_SHOW_COUNT && !$bshow && !$detect->isMobile()){ ?>
        <div class="collapse <?= $counter2 ?>" id="moreFilterSettings">
            <?
            $bshow = true;
            }

                $arCur = current($arItem["VALUES"]);
                switch ($arItem["DISPLAY_TYPE"]) {
                    case "A":
                        $counter2++;
                        ?>
                        <div class="d-block mb-3">
                            <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                               data-toggle="collapse" href="#collapse<?= $arItem['CODE'] ?>" role="button"
                               aria-expanded="true"
                               aria-controls="collapse<?= $arItem['CODE'] ?>">
                            <span class="d-flex justify-content-between align-items-center"><i
                                        class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i><? echo $arItem['FILTER_HINT'] ?></span>
                            </p>
                            <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"><? echo $arItem['FILTER_HINT'] ?></p>

                            <div id="collapse<?= $arItem['CODE'] ?>" class="collapse show">
                                <? if ($arItem['CODE'] == 'PRICE' && !CSite::InDir('/flea/')) {
                                    ?>
                                    <ul>

                                        <li>
                                            <span onclick=" triggerKeyup()" data-range-set="0,250"
                                                  data-range-connected="rangeSlider<?= $arItem['CODE'] ?>">Under $250</span>
                                        </li>

                                        <li>
                                            <span onclick=" triggerKeyup()" data-range-set="250,500"
                                                  data-range-connected="rangeSlider<?= $arItem['CODE'] ?>">$250 to $500</span>
                                        </li>

                                        <li>
                                            <span onclick=" triggerKeyup()" data-range-set="500,1000"
                                                  data-range-connected="rangeSlider<?= $arItem['CODE'] ?>">$500 to $1000</span>
                                        </li>

                                        <li>
                                            <span onclick=" triggerKeyup()" data-range-set="1000,2000"
                                                  data-range-connected="rangeSlider<?= $arItem['CODE'] ?>">$1000 to $2000</span>
                                        </li>

                                        <li>
                                            <span onclick=" triggerKeyup()" data-range-set="2000,10000"
                                                  data-range-connected="rangeSlider<?= $arItem['CODE'] ?>">$2000 &amp; Above</span>
                                        </li>

                                    </ul>
                                <?
                                } ?>
                                <div class="form-group">
                                    <div class="mb-4 form-row">
                                        <div class="col">
                                            <input type="text" onkeyup="smartFilter.keyup(this)"
                                                   name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                   value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                   id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                   class="form-control" placeholder="Max"
                                                   data-range-max-connected="rangeSlider<?= $arItem['CODE'] ?>">
                                        </div>

                                        <div class="col">
                                            <input type="text" onkeyup="smartFilter.keyup(this)" class="form-control"
                                                   name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                   value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                   id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                   placeholder="Min"
                                                   data-range-min-connected="rangeSlider<?= $arItem['CODE'] ?>">
                                        </div>
                                    </div>
                                    <?
                                    // $arItem["VALUES"]["MIN"]["HTML_VALUE"] миниамальное выбранное
                                    // $arItem["VALUES"]["MAX"]["HTML_VALUE"] максимальное выбранное
                                    // $arItem["VALUES"]["MIN"]["VALUE"] минимальное что есть
                                    // $arItem["VALUES"]["MAX"]["VALUE"] максимальное что есть
                                    ?>
                                    <div class="mb-3" id="rangeSlider<?= $arItem['CODE'] ?>"
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

                                        function triggerKeyup() {
                                            smartFilter.keyup(BX('<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>'))
                                            smartFilter.keyup(BX('<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>'));
                                        }
                                    </script>
                                </div>

                            </div>
                        </div>

                        <? if ($arItem['CODE'] == 'PRICE'  && !CSite::InDir('/flea/')) {
                        ?>
                        <div class="border-bottom mb-lg-4">
                            <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                               data-toggle="collapse"
                               href="#collapse<?= $arItem['CODE'] ?>" role="button" aria-expanded="true"
                               aria-controls="collapse<?= $arItem['CODE'] ?>">
                        <span class="d-flex justify-content-between align-items-center"><i
                                    class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i> <? echo $arItem['FILTER_HINT'] ?></span>
                            </p>

                            <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase">Brands</p>

                            <div class="collapse show" id="collapse<?= $arItem['CODE'] ?>" style="margin-bottom: 20px;">
                                <div class="smart-filter-input-group-dropdown">
                                    <div class="smart-filter-dropdown-block"
                                         onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                                        <div class="smart-filter-dropdown-text"
                                             data-role="currentOption"><?= ($sectonParant) ? $sectonParant : 'All' ?></div>
                                        <div class="smart-filter-dropdown-arrow"></div>

                                        <div class="smart-filter-dropdown-popup" data-role="dropdownContent"
                                             style="display: none;">
                                            <ul>
                                                <? foreach ($arSections as $arSection) {
                                                    ?>
                                                    <li>
                                                        <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                               class="smart-filter-dropdown-label smart-filter-choice"
                                                               data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                               data-name="<?= $arSection['CODE'] ?>"
                                                               onclick="window.location.href = '<?= $arSection['SECTION_PAGE_URL'] ?>/'">
                                                            <?= $arSection['NAME'] ?>
                                                        </label>
                                                    </li>
                                                <?
                                                } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse show" id="collapse<?= $arItem['CODE'] ?>1"
                                 style="margin-bottom: 20px;">
                                <div class="smart-filter-input-group-dropdown smart-filter-dropdown-next">
                                    <div class="smart-filter-dropdown-block">
                                        <div class="smart-filter-dropdown-text filter-dropdown-next-text"
                                             data-role="currentOption"><?= $modelName ?></div>
                                        <div class="smart-filter-dropdown-arrow"></div>
                                        <input
                                                style="display: none"
                                                type="radio"
                                                name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                                                id="<? echo "all_" . $arCur["CONTROL_ID"] ?>2"
                                                value=""
                                        />


                                        <div class="smart-filter-dropdown-popup-new" data-role="dropdownContent"
                                             style="display: none;">
                                            <ul id="smartFilterChoiceNew">
                                                <?

                                                foreach ($arSubSections as $arrSection) {
                                                    ?>
                                                    <li>

                                                        <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>2"
                                                               class="smart-filter-dropdown-label smart-filter-choice"
                                                               data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>2"
                                                               data-name="<?= $arrSection['CODE'] ?>"
                                                               onclick="window.location.href = '<?= $arrSection['SECTION_PAGE_URL'] ?>/'">
                                                            <?= $arrSection['NAME'] ?>
                                                        </label>
                                                    </li>
                                                <?
                                                } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                        break;

                    //endregion

                    //region NUMBERS +
                    case "B":
                        if (!$arItem["VALUES"]["MAX"]["VALUE"]) {
                            continue;
                        }
                        $counter2++;
                        ?>
                        <div class="d-block mb-3">
                            <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                               data-toggle="collapse" href="#collapse<?= $arItem['CODE'] ?>" role="button"
                               aria-expanded="true"
                               aria-controls="collapse<?= $arItem['CODE'] ?>">
                            <span class="d-flex justify-content-between align-items-center"><i
                                        class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i><? echo $arItem['FILTER_HINT'] ?></span>
                            </p>
                            <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"><? echo $arItem['FILTER_HINT'] ?></p>

                            <div id="collapse<?= $arItem['CODE'] ?>" class="collapse show">

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
                                            >
                                        </div>
                                        <div class="col">
                                            <input type="text"
                                                   onkeyup="smartFilter.keyup(this)"
                                                   class="form-control"
                                                   name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                   value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                   id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                   placeholder="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                            >
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
                        $counter2++;
                        ?>
                        <div class="mb-4 pb-4 border-bottom">
                            <p class="h5 mb-3 d-block text-uppercase font-weight-bolder">Colour</p>

                            <div class="d-flex flex-wrap palette">
                                <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                    <input <?= ($ar['CHECKED']) ? 'checked' : '' ?> onclick="smartFilter.keyup(this)"
                                                                                    type="radio" class="d-none"
                                                                                    name="color"
                                                                                    id="<?= $ar["CONTROL_ID"] ?>"
                                                                                    value="<?= $ar["HTML_VALUE"] ?>">
                                    <label class="colour-element" for="<?= $ar["CONTROL_ID"] ?>"
                                           style="background: #<?= $val ?>;"></label>
                                <? endforeach ?>
                            </div>
                        </div>

                        <?
                        break;
                    //endregion

                    //region CHECKBOXES_WITH_PICTURES_AND_LABELS +
                    case "H":
                        $counter2++;
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
                        $counter2++;
                        ?>
                        <? $checkedItemExist = false; ?>
                        <div class="border-bottom mb-lg-4">
                            <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                               data-toggle="collapse"
                               href="#collapse<?= $arItem['CODE'] ?>" role="button" aria-expanded="true"
                               aria-controls="collapse<?= $arItem['CODE'] ?>">
                        <span class="d-flex justify-content-between align-items-center"><i
                                    class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i><?= $arItem['FILTER_HINT'] ?></span>
                            </p>
                            <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"><?= $arItem['FILTER_HINT'] ?></p>
                            <div class="collapse show" id="collapse<?= $arItem['CODE'] ?>" style="margin-bottom: 20px;">
                                <div class="smart-filter-input-group-dropdown">
                                    <div class="smart-filter-dropdown-block"
                                         onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                                        <div class="smart-filter-dropdown-text currentOption<?= $arItem['CODE'] ?>"
                                             data-role="currentOption">
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
                                        <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                            <input
                                                    style="display: none"
                                                    type="radio"
                                                    name="<?= $ar["CONTROL_NAME_ALT"] ?>"
                                                    id="<?= $ar["CONTROL_ID"] ?>"
                                                    value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                            />
                                        <? endforeach ?>

                                        <div class="smart-filter-dropdown-popup" data-role="dropdownContent"
                                             style="display: none;">
                                            <ul>
                                                <li>
                                                    <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                           class="smart-filter-dropdown-label smart-filter-choice"
                                                           data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                           data-name="<?= $arItem['CODE'] ?>"
                                                           onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>', '.currentOption<?= $arItem['CODE'] ?>')">
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
                                                               data-name="<?= $arItem['CODE'] ?>"
                                                               onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>', '.currentOption<?= $arItem['CODE'] ?>'); ">
                                                            <?= $ar["VALUE"] ?>
                                                        </label>
                                                    </li>
                                                <? endforeach ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?
                        break;
                    //region DROPDOWN_WITH_PICTURES_AND_LABELS
                    case "R":
                        $counter2++;
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

                                <div class="smart-filter-dropdown-popup" data-role="dropdownContent"
                                     style="display: none">
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
                        $counter2++;
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
                        $counter2++;
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
                        $counter2++;
                        ?>

                        <? if ($arItem['CODE'] == "PROP_5" || $arItem['CODE'] == "PROP_COLOR_Left" || $arItem['CODE'] == "PROP_COLOR" || $arItem['CODE'] == "PROP_COLOUR") {
                        ?>
                        <div class="mb-4 pb-4 border-bottom">
                            <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                               data-toggle="collapse"
                               href="#collapse<?= $arItem['CODE'] ?>" role="button" aria-expanded="true"
                               aria-controls="collapse<?= $arItem['CODE'] ?>">
                        <span class="d-flex justify-content-between align-items-center"><i
                                    class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i><?= $arItem['FILTER_HINT'] ?></span>
                            </p>
                            <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"><?= $arItem['FILTER_HINT'] ?></p>
                            <div class="collapse show" id="collapse<?= $arItem['CODE'] ?>">
                                <div style="flex-direction: row-reverse;" class="d-flex flex-wrap palette">
                                    <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                        <input <?= ($ar['CHECKED']) ? 'checked' : '' ?>
                                                onclick="smartFilter.keyup(this)" type="checkbox" class="d-none"
                                                name="<?= $ar["CONTROL_NAME"] ?>"
                                                id="<?= $ar["CONTROL_ID"] ?>" value="<?= $ar["HTML_VALUE"] ?>">
                                        <label class="colour-element" for="<?= $ar["CONTROL_ID"] ?>"
                                               style="background: #<?= $val ?>;"></label>
                                    <? endforeach ?>
                                </div>
                            </div>
                        </div>
                        <?
                    } else {
                        ?>
                        <div class="border-bottom mb-lg-4">
                            <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase"
                               data-toggle="collapse"
                               href="#collapse<?= $arItem['CODE'] ?>" role="button" aria-expanded="true"
                               aria-controls="collapse<?= $arItem['CODE'] ?>">
                        <span class="d-flex justify-content-between align-items-center"><i
                                    class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i><?= $arItem['FILTER_HINT'] ?></span>
                            </p>
                            <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"><?= $arItem['FILTER_HINT'] ?></p>

                            <div class="collapse show" id="collapse<?= $arItem['CODE'] ?>">
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
    <div style="visibility: hidden"><? ps($counter2) ?></div>

    <? if ($counter2 > FILTER_EXTRA_SHOW_COUNT && !$detect->isMobile()) { ?>
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
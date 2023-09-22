<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$this->setFrameMode(true);

?>
<script>console.log(<?=json_encode($arResult)?>)</script>
<div class="d-block d-lg-none mb-5 px-3 property-menu-mobile">
    <div class="d-flex d-lg-none justify-content-end nav-category-type">
        <label class="label-type">
            <input id="renCheck1" onchange="changeTypeRent(this)" class="categoryMobile" name="categoryMobileRent"
                   value="rent" type="radio">
            <div><?= Loc::getMessage('rent'); ?></div>
        </label>

        <label class="label-type">
            <input id="buyCheck1" onchange="changeTypeRent(this)" class="categoryMobile" name="categoryMobileRent"
                   value="buy" type="radio">
            <div><?= Loc::getMessage('buy'); ?></div>
        </label>
    </div>
    <!-- RENT -->
    <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>"
          method="get" class="main-filters">
        <div class="mb-4">
            <?

            foreach ($arResult["ITEMS"] as $key => $arItem) {
                if ($arItem['ID'] == 108 ||$arItem['ID'] == 201 || $arItem['ID'] == 199 ||$arItem['ID'] == 200 ||  $arItem['ID'] == 169 || $arItem['ID'] == 111 || $arItem['ID'] == 113 || $arItem['ID'] == 178 || $arItem['ID'] == 174 || $arItem['NAME'] == 'MAP_LAYOUT_JSON')
                    continue;
                ?>


                <?

                switch ($arItem["DISPLAY_TYPE"]) {
                    case "B"://NUMBERS
                        ?>
                        <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="headingThree">
                            <button type="button" class="w-100 text-right btn btn-link collapsed" data-toggle="collapse"
                                    data-target="#collapse<?= $arItem['CODE'] ?>" aria-expanded="false" aria-controls="collapseThree">
                                <?= $arItem['NAME'] ?>
                            </button>

                            <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                        </div>

                        <div id="collapse<?= $arItem['CODE'] ?>" class="collapse" aria-labelledby="headingThree">
                            <div class="card-body price-input-box bg-white d-flex">
                                <div class="input-decoration">

                                    <input class="w-100 inputAreaMax"
                                           type="text"
                                           value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                           name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                           placeholder="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                           id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                           onkeyup="smartFilter.keyup(this)">
                                    <span class="decoration">₪</span>
                                </div>

                                <div class="input-decoration">

                                    <input class="w-100 inputAreaMin"
                                           type="text"
                                           value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                           name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                           placeholder="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                           id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                           onkeyup="smartFilter.keyup(this)">
                                    <span class="decoration">₪</span>
                                </div>
                            </div>
                        </div>
                        <?
                        break;
                    case "K"://RADIO_BUTTONS
                        if ($arItem['ID'] == 201 || $arItem['ID'] == 200)
                            break;
                        ?>


                        <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="headingThree">
                            <button type="button" class="w-100 text-right btn btn-link collapsed" data-toggle="collapse"
                                    data-target="#collapseTEST" aria-expanded="false" aria-controls="collapseThree">
                                region
                            </button>
                            <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                        </div>
                        <div id="collapseTEST" class="collapse" aria-labelledby="headingThree">


                                <div class="card-body w-100 justify-content-end dropdown-card dropdown-building-area2">
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
                                                <li data-filter-for='.dropdown-menu-search' data-filter="<?=ltrim($arState[1])?>">
                                                    <label class="cb-wrap">
                                                        <span class="text"><?=ltrim($arState[1])?></span>
                                                        <input type="checkbox"
                                                               data-parent-item-id="<?=base64_decode(ltrim($arState[0]))?>"
                                                               id="<? echo $ar["CONTROL_ID"] ?>"
                                                               name="<? echo $ar["CONTROL_NAME"] ?>"
                                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                            <? echo $ar["DISABLED"] ? 'disabled' : '' ?>
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

                        <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="headingThree">
                            <button type="button" class="w-100 text-right btn btn-link collapsed" data-toggle="collapse"
                                    data-target="#collapse<?= $arItem['CODE'] ?>" aria-expanded="false" aria-controls="collapseThree">
                                city
                            </button>
                            <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                        </div>
                        <div id="collapse<?= $arItem['CODE'] ?>" class="collapse" aria-labelledby="headingThree">



                                <div class="w-100 justify-content-end dropdown-card dropdown-building-area1">
                                    <div class="d-flex flex-column align-items-end check-box-prop-filter">

                                        <ul class="dropdown-card__content">
                                            <? foreach ($arResult['ITEMS'][200]['VALUES'] as $val => $ar) { ?>
                                                <li><label class="cb-wrap">
                                                        <span class="text"><?= $ar['VALUE'] ?></span>
                                                        <input
                                                                class="data-function"
                                                                type="checkbox"
                                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                            <? echo $ar["DISABLED"] ? 'disabled' : '' ?>
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



                        <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="headingTwo">
                            <button type="button" class="w-100 text-right btn btn-link collapsed" data-toggle="collapse"
                                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <?= Loc::getMessage('room'); ?>
                            </button>

                            <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo">
                            <div class="card-body bg-white flex-column">
                                <div class="mb-4 room-number flex-row-reverse">
                                    <? foreach ($arItem["VALUES"] as $val => $ar) { ?>

                                        <label class="chackbox-label">
                                            <input
                                                    type="checkbox"
                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                <? echo $ar["DISABLED"] ? 'disabled' : '' ?>
                                                    onclick="smartFilter.click(this)"
                                            />
                                            <div><? echo $ar["VALUE"] ?></div>
                                        </label>
                                        <?
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <?
                        break;
                    case "U"://CALENDAR
                        ?>
                        <div class="row mb-4">
                            <div class="col-10">
                                <div class="d-flex flex-row-reverse align-items-center">

                                    <div class="d-flex input-group-modal">
                                        <div class="input-decoration date-input">
                                            <? $APPLICATION->IncludeComponent(
                                                'bitrix:main.calendar',
                                                '',
                                                array(
                                                    'FORM_NAME' => $arResult["FILTER_NAME"] . "_form",
                                                    'SHOW_INPUT' => 'Y',
                                                    'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="' . FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]) . '" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
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
                            </div>
                            <div class="col-2 text-right">
                                <?= Loc::getMessage('date'); ?>
                            </div>
                        </div>
                        <?
                        break;
                    default:
                        ?>
                        <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="headingOne">
                            <button type="button" class="w-100 text-right btn btn-link" data-toggle="collapse"
                                    data-target="#collapse<?=$arItem['CODE']?>" aria-expanded="false" aria-controls="collapseOne">
                                <?=$arItem['NAME']?>
                            </button>

                            <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                        </div>

                        <div id="collapse<?=$arItem['CODE']?>" class="collapse show" aria-labelledby="headingOne">
                            <div class="card-body bg-white">

                                <? foreach ($arItem["VALUES"] as $val => $ar) { ?>
                                    <div class="d-flex flex-column align-items-end check-box-prop-filter">
                                        <label class="cb-wrap">
                                            <span class="text"><? echo $ar["VALUE"] ?></span>
                                            <input
                                                    type="checkbox"
                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                <? echo $ar["DISABLED"] ? 'disabled' : '' ?>
                                                    onclick="smartFilter.click(this)"
                                            />
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <?
                                } ?>
                            </div>
                        </div>

                    <?
                }
            }/*
            ?>
            <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="headingOne">
                <button type="button" class="w-100 text-right btn btn-link" data-toggle="collapse"
                        data-target="#collapse<?=$arResult['ITEMS'][200]['CODE']?>" aria-expanded="false" aria-controls="collapseOne">
                    <?=$arResult['ITEMS'][200]['NAME']?>
                </button>

                <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
            </div>

            <div id="collapse<?=$arResult['ITEMS'][200]['CODE']?>" class="collapse show" aria-labelledby="headingOne">
                <div class="card-body bg-white">

                    <? foreach ($arResult['ITEMS'][200]["VALUES"] as $val => $ar) { ?>
                        <div class="d-flex flex-column align-items-end check-box-prop-filter">
                            <label class="cb-wrap">
                                <span class="text"><? echo $ar["VALUE"] ?></span>
                                <input
                                        type="checkbox"
                                        value="<? echo $ar["HTML_VALUE"] ?>"
                                        name="<? echo $ar["CONTROL_NAME"] ?>"
                                        id="<? echo $ar["CONTROL_ID"] ?>"
                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                    <? echo $ar["DISABLED"] ? 'disabled' : '' ?>
                                        onclick="smartFilter.click(this)"
                                />
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <?
                    } ?>
                </div>
            </div>
            <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="headingOne">
                <button type="button" class="w-100 text-right btn btn-link" data-toggle="collapse"
                        data-target="#collapse<?=$arResult['ITEMS'][199]['CODE']?>" aria-expanded="false" aria-controls="collapseOne">
                    <?=$arResult['ITEMS'][199]['NAME']?>
                </button>

                <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
            </div>

            <div id="collapse<?=$arResult['ITEMS'][199]['CODE']?>" class="collapse show" aria-labelledby="headingOne">
                <div class="card-body bg-white">

                    <? foreach ($arResult['ITEMS'][199]["VALUES"] as $val => $ar) { ?>
                        <div class="d-flex flex-column align-items-end check-box-prop-filter">
                            <label class="cb-wrap">
                                <span class="text"><? echo $ar["VALUE"] ?></span>
                                <input
                                        type="checkbox"
                                        value="<? echo $ar["HTML_VALUE"] ?>"
                                        name="<? echo $ar["CONTROL_NAME"] ?>"
                                        id="<? echo $ar["CONTROL_ID"] ?>"
                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                    <? echo $ar["DISABLED"] ? 'disabled' : '' ?>
                                        onclick="smartFilter.click(this)"
                                />
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <?
                    } ?>
                </div>
            </div>
            <div class="d-flex">
               <?/* <div class="location-select">
                    <!-- <input class="search-input" type="text" placeholder="<?= Loc::getMessage('city'); ?>"> -->
                    <div class="location-select__item">
                        <div class="dropdown custom-btn-property">

                            <div class="select">
                                <span>Все города</span>
                                <i class="fa fa-chevron-left"></i>
                            </div>
                            <i class="icon-arrow-down-sign-to-navigate-3"></i>
                            <input type="hidden" name="gender">
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-search">
                                    <i class="icon-magnifying-glass-1"></i>
                                    <input type="text" placeholder="Enter search words"
                                           class="dropdown-menu-search__input">
                                </div>
                                <ul>
                                    <li id="Кирьят-Малахи">Кирьят-Малахи</li>
                                    <li id="Кирьят-Гат">Кирьят-Гат</li>
                                    <li id="Сдерот">Сдерот</li>
                                    <li id="Кирьят-Малахи">Кирьят-Малахи</li>
                                    <li id="Кирьят-Гат">Кирьят-Гат</li>
                                    <li id="Кирьят-Малахи">Кирьят-Малахи</li>
                                    <li id="Кирьят-Гат">Кирьят-Гат</li>
                                    <li id="Сдерот">Сдерот</li>
                                    <li id="Кирьят-Малахи">Кирьят-Малахи</li>
                                    <li id="Кирьят-Гат">Кирьят-Гат</li>
                                    <li id="Сдерот">Сдерот</li>
                                    <li id="Кирьят-Малахи">Кирьят-Малахи</li>
                                    <li id="Кирьят-Гат">Кирьят-Гат</li>
                                    <li id="Кирьят-Малахи">Кирьят-Малахи</li>
                                    <li id="Кирьят-Гат">Кирьят-Гат</li>
                                    <li id="Сдерот">Сдерот</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="location-select__place-item">
                        <div class="dropdown custom-btn-property">

                            <div class="select">
                                <span>Печатное СМИ</span>
                                <i class="fa fa-chevron-left"></i>
                            </div>
                            <i class="icon-arrow-down-sign-to-navigate-3"></i>
                            <input type="hidden" name="gender">


                            <ul class="dropdown-menu">

                                <li id="12">Печатное СМИ</li>
                                <li id="13">Печатное СМИ</li>
                                <li id="14">Печатное СМИ</li>
                                <li id="15">Печатное СМИ</li>
                            </ul>
                        </div>
                    </div>
                </div>
*/?>
                <!--<input class="w-100 search-input" type="text"
                       placeholder="<? /*=Loc::getMessage('city');*/ ?>">-->
            </div>
            <div class="mb-4 d-flex flex-column align-items-center" id="extraMObileOptionsProperty">
                <div class="btn-mobile-extra-options collapsed" data-toggle="collapse"
                     data-target="#extraMObileOptionsPropertyMmm" aria-expanded="false"
                     aria-controls="extraMObileOptionsPropertyMmm">
                    <span><?= Loc::getMessage('more_params'); ?></span>
                    <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                </div>
            </div>
        </div>

        <div id="extraMObileOptionsPropertyMmm" class="collapse" aria-labelledby="extraMObileOptionsProperty">
            <div class="card-body modal-filter-header">
                <?

                foreach ($arResult["ITEMS"] as $key => $arItem) {
                    if ($arItem['ID'] == 61 || $arItem['ID'] == 109 || $arItem['ID'] == 165)
                        continue;
                    ?>


                    <?

                    switch ($arItem["DISPLAY_TYPE"]) {
                        case "A"://NUMBERS_WITH_SLIDER
                            ?>

                            <?
                            break;
                        case "B"://NUMBERS
                            ?>
                            <div class="mb-4">
                                <div class="mb-3 d-flex justify-content-end">
                    <span class="rentAreaCommerce"><?= $arItem['NAME'] ?>
</span>
                                </div>

                                <div class="d-flex input-group-modal">
                                    <div class="w-50 mr-3 input-decoration">
                                        <input class="w-100 inputAreaMin"
                                               type="text"
                                               value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                               name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                               placeholder="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                               id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                               onkeyup="smartFilter.keyup(this)">

                                        <span class="decoration">м²</span>
                                    </div>

                                    <div class="w-50 input-decoration">
                                        <input class="w-100 inputAreaMax"
                                               type="text"
                                               value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                               name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                               placeholder="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                               id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                               onkeyup="smartFilter.keyup(this)">
                                        <span class="decoration">м²</span>
                                    </div>
                                </div>
                            </div>
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
                            <div class="row mb-4">
                                <div class="col-10">
                                    <div class="d-flex flex-wrap flex-row-reverse align-items-center">
                                        <? foreach ($arItem["VALUES"] as $val => $ar) { ?>

                                            <label class="parameter">
                                                <input
                                                        type="radio"
                                                        value="<? echo $ar["HTML_VALUE"] ?>"
                                                        name="<? echo $ar["CONTROL_NAME"] ?>"
                                                        id="<? echo $ar["CONTROL_ID"] ?>"
                                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                    <? echo $ar["DISABLED"] ? 'disabled' : '' ?>
                                                        onclick="smartFilter.click(this)"
                                                />
                                                <div><? echo $ar["VALUE"] ?></div>
                                            </label>
                                            <?
                                        } ?>
                                    </div>
                                </div>
                                <div class="col-2 text-right">
                                    <?= $arItem['NAME'] ?>
                                </div>
                            </div>
                            <?
                            break;
                        case "U"://CALENDAR
                            ?>
                            <div class="row mb-4">
                                <div class="col-10">
                                    <div class="d-flex flex-row-reverse align-items-center">

                                        <div class="d-flex input-group-modal">
                                            <div class="input-decoration date-input">
                                                <? $APPLICATION->IncludeComponent(
                                                    'bitrix:main.calendar',
                                                    '',
                                                    array(
                                                        'FORM_NAME' => $arResult["FILTER_NAME"] . "_form",
                                                        'SHOW_INPUT' => 'Y',
                                                        'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="' . FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]) . '" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
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
                                </div>
                                <div class="col-2 text-right">
                                    <?= Loc::getMessage('date'); ?>
                                </div>
                            </div>
                            <?
                            break;
                        default:

                            ?>
                            <div <?if($arItem['ID'] == 200 || $arItem['ID'] == 201 || $arItem['ID'] == 199){?>style="display: none" <?}?> class="row mb-4">
                                <div class="col-10">
                                    <div class="d-flex flex-wrap flex-row-reverse align-items-center">
                                        <? foreach ($arItem["VALUES"] as $val => $ar) { ?>

                                            <label class="parameter">
                                                <input
                                                        type="checkbox"
                                                        value="<? echo $ar["HTML_VALUE"] ?>"
                                                        name="<? echo $ar["CONTROL_NAME"] ?>"
                                                        id="<? echo $ar["CONTROL_ID"] ?>"
                                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                    <? echo $ar["DISABLED"] ? 'disabled' : '' ?>
                                                        onclick="smartFilter.click(this)"
                                                />
                                                <div><? echo $ar["VALUE"] ?></div>
                                            </label>
                                            <?
                                        } ?>
                                    </div>
                                </div>
                                <div class="col-2 text-right">
                                    <?= $arItem['NAME'] ?>
                                </div>
                            </div>
                        <?
                    }
                }
                ?>

                <!-- </ul> -->


            </div>
        </div>

        <div class="d-flex flex-column">
            <input
                    style="
                    color: #ffffff;
    background-color: #3fb465;
    border-color: #3fb465;"
                    class="btn btn-primary font-weight-bold submit-btn-search rounded-0 mb-3"
                    type="submit"
                    id="set_filter"
                    name="set_filter"
                    value="<?= GetMessage("find") ?>"
            />
            <input

                    class="btn bg-white text-primary font-weight-bold border-primary btn-show-map rounded-0"
                    type="submit"
                    id="del_filter"
                    name="del_filter"
                    value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>"
            />
        </div>
</div>
</form>

<script>
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
<script>


   /* let dropdownList = document.querySelectorAll(".dropdown");

    document.addEventListener("click",function(){
        let el = event.target
        if(!el.classList.contains("dropdown-menu-search__input") && !el.closest(".dropdown")){
            dropdownList.forEach(function (el){
                el.classList.remove('active');
                $(".dropdown-menu").slideUp(300);
            })
        }
    })

    dropdownList.forEach((el)=>{

        el.addEventListener("click", function(e){
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

   /* $('.dropdown .dropdown-menu li').click(function () {
        $(this).parents('.dropdown').find('span').text($(this).text());
        $(this).parents('.dropdown').find('input').attr('value', $(this).attr('id'));
    });*/

   /*$('.dropdown-card__content li').click(function () {
       $(this).parents('.dropdown-card').slideToggle(300);
       let data = $(this).find('input').attr('data-valued')
       $(this).parents('.dropdown-card').removeClass("active");
       $(this).parents('.dropdown-block').find('.typeProperty').text(data);

   });*/


    function changeTypeRent(element) {

        if ($('#buyCheck1').is(':checked') == false) {
            var elem = document.getElementById("arrFilter_178_1500340406");
            elem.checked = false;

        } else {
            var elem = document.getElementById("arrFilter_178_1500340406");
            elem.click();
            elem.checked = true;

        }
        if ($('#renCheck1').is(':checked') == false) {
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
            var elem = document.getElementById("buyCheck1");
            elem.checked = true
        }
        if (elem2.checked == true) {
            var elem = document.getElementById("renCheck1");
            elem.checked = true
        }
    })
</script>
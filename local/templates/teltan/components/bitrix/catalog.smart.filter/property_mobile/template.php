<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$this->setFrameMode(true);

$curPage = $APPLICATION->GetCurPage();
$isLiveBuyPage = strpos($curPage,'/property/zhilaya/kupit-j/') !== false;
$isСommercialRentPage = strpos($curPage,'/property/kommercheskaya/snyat-kom/') !== false;
$isСommercialBuyPage = strpos($curPage,'/property/kommercheskaya/kupit-kom/') !== false;
?>
<div class="d-block d-lg-none mb-5 px-3 property-menu-mobile">
    <div class="d-flex d-lg-none justify-content-end nav-category-type">
        <label class="label-type">
            <input id="renCheck1"
                   <?= (in_array($arParams['SECTION_ID'], [RESIDENTIAL_RENT_SECTION_ID, COMMERCIAL_RENT_SECTION_ID, NEW_RENT_SECTION_ID])) ? 'checked' : '' ?>
                   onclick="window.location.href='<?= (in_array($arParams['SECTION_ID'], COMMERCIAL_SECTION_ARRAY)) ? '/property/kommercheskaya/snyat-kom/' : '/property/zhilaya/snyat-j/' ?>'"
                   onchange="changeTypeRent(this)"
                   class="categoryMobile"
                   name="categoryMobileRent"
                   value="rent" type="radio">
            <div><?= Loc::getMessage('rent'); ?></div>
        </label>

        <label class="label-type">
            <input id="buyCheck1"
                <?= (in_array($arParams['SECTION_ID'], [RESIDENTIAL_BUY_SECTION_ID, COMMERCIAL_BUY_SECTION_ID, NEW_BUY_SECTION_ID])) ? 'checked' : '' ?>
                   onclick="window.location.href='<?= (in_array($arParams['SECTION_ID'], COMMERCIAL_SECTION_ARRAY)) ? '/property/kommercheskaya/kupit-kom/' : '/property/zhilaya/kupit-j/' ?>'"
                   onchange="changeTypeRent(this)"
                   class="categoryMobile"
                   name="categoryMobileRent"
                   value="buy"
                   type="radio"
            >
            <div><?= Loc::getMessage('buy'); ?></div>
        </label>
    </div>

    <!-- RENT -->
    <form name="<?=$arResult["FILTER_NAME"] . "_form"?>" action="<?=$arResult["FORM_ACTION"]?>" method="get" class="main-filters">
        <?if (!empty($arResult["MAIN_PROPS"])):?>
            <div class="mb-4">
                <?php foreach ($arResult["MAIN_PROPS"] as $key => $arItem):?>
                    <?php switch ($arItem["CODE"]) :
                        case "MAP_LAYOUT_BIG":?>
                            <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="<?=$arItem['CODE']?>">
                                <button type="button" class="w-100 text-right btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapse<?=$arItem['CODE']?>" aria-expanded="false"
                                        aria-controls="collapseThree">
                                    <?=$arItem['NAME']?>
                                </button>
                                <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                            </div>
                            <div id="collapse<?=$arItem['CODE']?>" class="collapse" aria-labelledby="<?=$arItem['CODE']?>">
                                <div class="w-100 justify-content-end dropdown-card dropdown-building-area1">
                                    <div class="d-flex flex-column align-items-end check-box-prop-filter">
                                        <ul class="dropdown-card__content">
                                            <? foreach ($arItem['VALUES'] as $val => $ar):?>
                                                <li>
                                                    <label class="cb-wrap">
                                                        <span class="text"><?=$ar['VALUE']?></span>
                                                        <input type="checkbox"
                                                               class="data-function"
                                                               id="<?=$ar["CONTROL_ID"] ?>"
                                                               data-control-id="<?=$ar["CONTROL_ID"]?>"
                                                               data-html-value="<?= $ar['HTML_VALUE'] ?>"
                                                               name="<?=$ar["CONTROL_NAME"] ?>"
                                                                <?=$ar["CHECKED"] ? 'checked="checked"' : ''?>
                                                               value="<?=$ar['HTML_VALUE']?>"
                                                               data-valued="<?=$ar['VALUE']?>"
                                                        >
                                                        <span class="checkmark <?=$ar["DISABLED"] ? 'disabled' : ''?>"></span>
                                                    </label>
                                                </li>
                                            <?endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <? break;?>
                        <?case "MAP_LAYOUT":?>
                            <div class="card-header bg-white text-right pr-4 d-flex justify-content-end disabled" id="<?=$arItem['CODE']?>">
                                <button type="button" class="w-100 text-right btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapse<?=$arItem['CODE']?>" aria-expanded="false" aria-controls="collapseThree">
                                    <?=$arItem['NAME']?>
                                </button>
                                <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                            </div>
                            <div id="collapse<?=$arItem['CODE']?>" class="collapse" aria-labelledby="<?=$arItem['CODE']?>">
                                <div class="card-body w-100 justify-content-end dropdown-card dropdown-building-area2">
                                    <div class="d-flex flex-column align-items-end dropdown-card-wrapper check-box-prop-filter">
                                        <div class="dropdown-menu-search">
                                            <i class="icon-magnifying-glass-1"></i>
                                            <textarea type="text" placeholder="Enter search words"
                                                      class="dropdown-menu-search__input"></textarea>
                                        </div>
                                        <ul class="dropdown-card__content">
                                            <? foreach ($arItem['VALUES'] as $val => $ar):
                                                $arState = explode(':', $ar['VALUE']);
                                                ?>
                                                <li data-filter-for='.dropdown-menu-search' data-filter="<?=$ar['VALUE']?>">
                                                    <label class="cb-wrap">
                                                        <span class="text"><?=ltrim($arState[1])?></span>
                                                        <input
                                                                data-parent-item-id="<?=base64_decode(ltrim($arState[0]))?>"
                                                                data-html-value="<?= $ar['HTML_VALUE'] ?>"
                                                                type="checkbox"
                                                                id="<?=$ar["CONTROL_ID"] ?>"
                                                                name="<?=$ar["CONTROL_NAME"] ?>"
                                                                <?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                <?=$ar["DISABLED"] ? 'disabled' : '' ?>
                                                                value="<?=$ar['HTML_VALUE']?>"
                                                                data-valued="<?=ltrim($arState[1])?>"
                                                                onclick="smartFilter.click(this);"
                                                        >
                                                        <span class="checkmark <?=$ar["DISABLED"] ? 'disabled' : ''?>"></span>
                                                    </label>
                                                </li>
                                            <?endforeach;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <? break;?>
                        <?case "PRICE":?>
                            <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="<?=$arItem['CODE']?>">
                                <button type="button" class="w-100 text-right btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapse<?= $arItem['CODE'] ?>" aria-expanded="false" aria-controls="collapseThree">
                                    <?= $arItem['NAME'] ?>
                                </button>
                                <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                            </div>
                            <div id="collapse<?= $arItem['CODE'] ?>" class="collapse" aria-labelledby="<?=$arItem['CODE']?>">
                                <div class="card-body price-input-box bg-white d-flex">
                                    <div class="input-decoration">
                                        <input class="w-100 inputAreaMax"
                                               type="text"
                                               value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                               name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                               placeholder="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                               id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                               onkeyup="smartFilter.keyup(this)">
                                        <span class="decoration">₪</span>
                                    </div>

                                    <div class="input-decoration">
                                        <input class="w-100 inputAreaMin"
                                               type="text"
                                               value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                               name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                               placeholder="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                               id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                               onkeyup="smartFilter.keyup(this)">
                                        <span class="decoration">₪</span>
                                    </div>
                                </div>
                            </div>
                        <? break;?>
                        <?case "PROP_COUNT_ROOMS":?>
                            <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="<?=$arItem['CODE']?>">
                                <button type="button" class="w-100 text-right btn btn-link" data-toggle="collapse"
                                        data-target="#collapse<?=$arItem['CODE']?>" aria-expanded="false" aria-controls="collapseOne">
                                    <?=$arItem['NAME']?>
                                </button>
                                <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                            </div>
                            <div id="collapse<?=$arItem['CODE']?>" class="collapse" aria-labelledby="<?=$arItem['CODE']?>">
                                <div class="card-body bg-white flex-column">
                                    <div class="mb-4 room-number flex-row-reverse">
                                        <? foreach ($arItem["VALUES"] as $val => $ar) :?>
                                            <label class="chackbox-label">
                                                <input
                                                        type="checkbox"
                                                        value="<?=$ar["HTML_VALUE"] ?>"
                                                        name="<?=$ar["CONTROL_NAME"] ?>"
                                                        id="<?=$ar["CONTROL_ID"] ?>"
                                                    <?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                    <?=$ar["DISABLED"] ? 'disabled' : '' ?>
                                                        onclick="smartFilter.click(this)"
                                                />
                                                <div class="box <?=$ar["DISABLED"] ? 'disabled' : ''?>"><?=$ar["VALUE"]?></div>
                                            </label>
                                        <?endforeach;?>
                                    </div>
                                    <div class="d-flex flex-column align-items-end check-box-prop-filter">
                                        <?if (!empty($arResult['ROOMS_ADD_PROP'])):?>
                                            <?foreach ($arResult['ROOMS_ADD_PROP'] as $prop):?>
                                               <?if (!empty($prop['VALUES'])):?>
                                                    <?foreach ($prop['VALUES'] as $val):?>
                                                        <label class="cb-wrap">
                                                            <span class="text"><?=$prop["NAME"] ?></span>
                                                            <input
                                                                    type="checkbox"
                                                                    value="<?=$val["HTML_VALUE"] ?>"
                                                                    name="<?=$val["CONTROL_NAME"] ?>"
                                                                    id="<?=$val["CONTROL_ID"] ?>"
                                                                    <?=$val["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    <?=$val["DISABLED"] ? 'disabled' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            />
                                                            <span class="checkmark <?=$ar["DISABLED"] ? 'disabled' : ''?>"></span>
                                                        </label>
                                                    <?endforeach;?>
                                                <?endif;?>
                                            <?endforeach;?>
                                        <?endif;?>
                                     </div>
                                </div>
                            </div>
                        <? break;?>
                        <? default: ?>
                            <div class="card-header bg-white text-right pr-4 d-flex justify-content-end" id="<?=$arItem['CODE']?>">
                                <button type="button" class="w-100 text-right btn btn-link" data-toggle="collapse"
                                        data-target="#collapse<?=$arItem['CODE']?>" aria-expanded="false" aria-controls="collapseOne">
                                    <?=$arItem['NAME']?>
                                </button>

                                <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                            </div>
                            <div id="collapse<?=$arItem['CODE']?>" class="collapse" aria-labelledby="<?=$arItem['CODE']?>">
                                <div class="card-body bg-white">
                                    <? foreach ($arItem["VALUES"] as $val => $ar) :?>
                                        <div class="d-flex flex-column align-items-end check-box-prop-filter">
                                            <label class="cb-wrap">
                                                <span class="text"><?=$ar["VALUE"] ?></span>
                                                <input
                                                    type="checkbox"
                                                    value="<?=$ar["HTML_VALUE"] ?>"
                                                    name="<?=$ar["CONTROL_NAME"] ?>"
                                                    id="<?=$ar["CONTROL_ID"] ?>"
                                                    <?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                    <?=$ar["DISABLED"] ? 'disabled' : '' ?>
                                                    onclick="smartFilter.click(this)"
                                                >
                                                <span class="checkmark <?=$ar["DISABLED"] ? 'disabled' : ''?>"></span>
                                            </label>
                                        </div>
                                    <?endforeach;?>
                                </div>
                            </div>
                        <? break;?>
                    <? endswitch;?>
                <?endforeach;?>
                </div>
                <div class="mb-4 d-flex flex-column align-items-center" id="extraMObileOptionsProperty">
                    <div class="btn-mobile-extra-options collapsed" data-toggle="collapse"
                         data-target="#extraMObileOptionsPropertyMmm" aria-expanded="false"
                         aria-controls="extraMObileOptionsPropertyMmm">
                        <span><?= Loc::getMessage('more_params'); ?></span>
                        <i class="icon-arrow-down-sign-to-navigate-3 d-flex justify-content-center align-items-center"></i>
                    </div>
                </div>
        <?php endif;?>
        <?// Дополнительные свойства?>
        <div id="extraMObileOptionsPropertyMmm" class="collapse" aria-labelledby="extraMObileOptionsProperty">
            <div class="card-body modal-filter-header">
                <?php foreach ($arResult["ITEMS"] as $key => $arItem):?>
                    <?if (($arItem["CODE"] === "PROP_AREA_2" && !$isСommercialRentPage && !$isСommercialBuyPage) || $arItem["CODE"] === "PROP_FLOOR"):?>
                        <div class="mb-4">
                            <div class="mb-3 d-flex justify-content-end">
                                <span class="rentAreaCommerce"><?= $arItem['NAME'] ?></span>
                            </div>
                            <div class="d-flex input-group-modal">
                                <div class="w-50 mr-3 input-decoration">
                                    <input class="w-100 inputAreaMin"
                                           type="text"
                                           value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                           name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                           placeholder="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                           id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                           onkeyup="smartFilter.keyup(this)"
                                    >
                                    <?if ($arItem['CODE'] !== 'PROP_FLOOR'):?><span class="decoration">м²</span><?endif;?>
                                </div>

                                <div class="w-50 input-decoration">
                                    <input class="w-100 inputAreaMax"
                                           type="text"
                                           value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                           name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                           placeholder="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                           id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                           onkeyup="smartFilter.keyup(this)"
                                    >
                                    <?if ($arItem['CODE'] !== 'PROP_FLOOR'):?><span class="decoration">м²</span><?endif;?>
                                </div>
                            </div>
                        </div>
                    <?elseif ($arItem["CODE"] === "NOT_LAST" || $arItem["CODE"] === "NOT_FIRST"):?>
                        <div class="d-flex flex-column check-box-prop-filter">
                            <?php foreach ($arItem["VALUES"] as $val => $ar):?>
                                 <label class="mb-3 cb-wrap">
                                      <span class="text"><?=$arItem['NAME']?></span>
                                      <input
                                            type="checkbox"
                                            value="<?=$ar["HTML_VALUE"] ?>"
                                            name="<?=$ar["CONTROL_NAME"] ?>"
                                            id="<?=$ar["CONTROL_ID"] ?>"
                                            <?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                            <?=$ar["DISABLED"] ? 'disabled' : '' ?>
                                            onclick="smartFilter.click(this)"
                                      />
                                      <span class="checkmark <?=$ar["DISABLED"] ? 'disabled' : ''?>"></span>
                                  </label>
                            <?endforeach;?>
                        </div>
                    <?endif;?>
                <?php endforeach?>
                <?if (!empty($arResult['ADDITIONAL_PROPS'])):?>
                    <?foreach ($arResult['ADDITIONAL_PROPS'] as $addProp):?>
                        <div class="mb-3 d-flex justify-content-end text-right additional-prop-label"><?=$addProp['NAME']?></div>
                        <div class="d-flex flex-wrap align-items-end justify-content-end">
                            <?if (!empty($addProp['VALUES'])):?>
                                <?foreach ($addProp['VALUES'] as $val):?>
                                    <label class="parameter">
                                        <input
                                                type="checkbox"
                                                value="<?=$val["HTML_VALUE"] ?>"
                                                name="<?=$val["CONTROL_NAME"] ?>"
                                                id="<?=$val["CONTROL_ID"] ?>"
                                                <?=$val["CHECKED"] ? 'checked="checked"' : '' ?>
                                                <?=$val["DISABLED"] ? 'disabled' : '' ?>
                                                onclick="smartFilter.click(this)"
                                        />
                                        <div class="box <?=$val["DISABLED"] ? 'disabled' : ''?>"><?=$val['VALUE']?></div>
                                    </label>
                                <?php endforeach;?>
                            <?endif;?>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                <?// Немедленный въезд?>
                <?php if (!empty($arResult["ITEMS"][PROP_IMMEDIATELY_ENTRY_ID]['VALUES']) && !$isLiveBuyPage && !$isСommercialBuyPage):?>
                    <?php foreach ($arResult['ITEMS'][PROP_IMMEDIATELY_ENTRY_ID]['VALUES'] as $key => $prop):?>
                        <div class="d-flex flex-column check-box-prop-filter immediately-entry-box">
                            <label class="mb-3 cb-wrap">
                                <span class="text"><?=$arResult["ITEMS"][PROP_IMMEDIATELY_ENTRY_ID]['NAME']?></span>
                                <input
                                        type="checkbox"
                                        value="<?=$prop["HTML_VALUE"] ?>"
                                        name="<?=$prop["CONTROL_NAME"] ?>"
                                        id="<?=$prop["CONTROL_ID"] ?>"
                                    <?=(!empty($_GET[$prop['CONTROL_ID']]))? 'checked' : ''?>
                                        data-html-value="<?=$prop['HTML_VALUE']?>"
                                        data-control-id="<?=$prop['CONTROL_ID']?>"
                                />
                                <span class="checkmark <?=$prop["DISABLED"] ? 'disabled' : ''?>"></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php endif;?>
                <?// Дата въезда?>
                <?php if (!empty($arResult["ITEMS"][PROP_COMPLETION_ID]['VALUES']) && !$isLiveBuyPage && !$isСommercialBuyPage):?>
                    <?php foreach ($arResult['ITEMS'][PROP_COMPLETION_ID]['VALUES'] as $key => $propDate):?>
                        <?php if ($key === 'MIN'):
                            if (!empty($_GET[$propDate['CONTROL_ID']])) {
                                $dateString = $_GET[$propDate['CONTROL_ID']];
                                $date = DateTime::createFromFormat('d/m/Y', $dateString);
                                $formattedDate = $date->format('Y-m-d');
                            }
                        ?>
                            <div class="mb-4 date-input">
                                <div class="mb-3 d-flex justify-content-end">
                                    <span class="rentAreaCommerce"><?=$arResult["ITEMS"][PROP_COMPLETION_ID]["NAME"]?></span>
                                </div>
                                <div class="d-flex input-group-modal date-container-mobile">
                                    <div class="input-decoration">
                                        <input value="<?=!empty($formattedDate) ? $formattedDate : ''?>"
                                               data-control-id="<?=$propDate['CONTROL_ID']?>"
                                               class="check-in-date"
                                               name="check-in-date"
                                               type="date"
                                               placeholder="Дата въезда"
                                        >
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        </div>

        <div class="d-flex flex-column">
            <input
                style="color: #ffffff; background-color: #3fb465; border-color: #3fb465;"
                class="btn btn-primary font-weight-bold submit-btn-search rounded-0 mb-3"
                type="submit"
                id="set_filter"
                name="set_filter"
                value="<?= GetMessage("find") ?>"
            >
            <input
                class="btn bg-white text-primary font-weight-bold border-primary btn-show-map rounded-0"
                type="submit"
                id="del_filter"
                name="del_filter"
                value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>"
            >

        </div>
    </form>
</div>
<button id="btnToTheTop" class="btn-to-top">
    <img src="<?=SITE_TEMPLATE_PATH?>/assets/settings.svg" alt="filter">
</button>
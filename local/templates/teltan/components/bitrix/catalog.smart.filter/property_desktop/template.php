<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arResult
 * @var array $arParams
 * created by Alexander.L
 */

Loc::loadMessages(__FILE__);
$this->setFrameMode(false);
$arSection = [];
$curPage = $APPLICATION->GetCurPage();
$isLiveBuyPage = strpos($curPage,'/property/zhilaya/kupit-j/') !== false;
$isСommercialRentPage = strpos($curPage,'/property/kommercheskaya/snyat-kom/') !== false;
$isСommercialBuyPage = strpos($curPage,'/property/kommercheskaya/kupit-kom/') !== false;
?>
<div class="header-property-type-menu">
    <div class="bg-header-filter">
        <img src="/local/templates/teltan/assets/property-header-bg-progressive.jpeg" alt="">
    </div>
    <?// mobile menu?>
    <div class="d-flex d-lg-none justify-content-center container p-0">
        <ul class="w-100 mb-0 header-property__category-list">
            <li>
                <a href="/property/zhilaya/snyat-j/" <?= (in_array($arParams['SECTION_ID'], RESIDENTAL_SECTION_ARRAY)) ? ' class="active" ' : '' ?>>Жилая</a>
            </li>
            <span class="text-white mx-3">/</span>
            <li>
                <a href="/property/kommercheskaya/snyat-kom/" <?= (in_array($arParams['SECTION_ID'], COMMERCIAL_SECTION_ARRAY)) ? ' class="active" ' : '' ?>>Коммерческая</a>
            </li>
        </ul>
    </div>
    <?// desktop menu?>
    <div class="d-none d-lg-block container">
        <div class="d-flex align-items-center justify-content-end">
            <ul class="mb-0 header-property__category-list">
                <li>
                    <a href="/property/zhilaya/snyat-j/" <?= (in_array($arParams['SECTION_ID'], RESIDENTAL_SECTION_ARRAY)) ? ' class="active" ' : '' ?> >Жилая</a>
                </li>
                <span class="text-white mx-3">/</span>
                <li>
                    <a href="/property/kommercheskaya/snyat-kom/" <?= (in_array($arParams['SECTION_ID'], COMMERCIAL_SECTION_ARRAY)) ? ' class="active" ' : '' ?>>Коммерческая</a>
                </li>
            </ul>

            <div class="d-flex nav-category-type">
                <label class="label-type">
                    <input <?= (in_array($arParams['SECTION_ID'], [RESIDENTIAL_RENT_SECTION_ID, COMMERCIAL_RENT_SECTION_ID, NEW_RENT_SECTION_ID])) ? 'checked' : '' ?>
                            onclick="window.location.href='<?= (in_array($arParams['SECTION_ID'], COMMERCIAL_SECTION_ARRAY)) ? '/property/kommercheskaya/snyat-kom/' : '/property/zhilaya/snyat-j/' ?>'"   id="categoryRentInput" class="category" name="category" value="rent" type="radio">
                    <div>Снять</div>
                </label>

                <label class="label-type">
                    <input <?= (in_array($arParams['SECTION_ID'], [RESIDENTIAL_BUY_SECTION_ID, COMMERCIAL_BUY_SECTION_ID, NEW_BUY_SECTION_ID])) ? 'checked' : '' ?>
                           onclick="window.location.href='<?= (in_array($arParams['SECTION_ID'], COMMERCIAL_SECTION_ARRAY)) ? '/property/kommercheskaya/kupit-kom/' : '/property/zhilaya/kupit-j/' ?>'" id="categoryBuyInput" class="category" name="category" value="buy" type="radio">
                    <div>Купить</div>
                </label>
            </div>
        </div>

        <form id="mainFiltersRent" class="main-filters">
            <div class="prop-rent-form">
                <div class="w-30 position-relative dropdown-block">
                    <button id="area2toogle" type="button"
                            class="custom-btn-property custom-btn-property--new btn-property-type ">
                        <i class="icon-arrow-down-sign-to-navigate-3"></i>
                        <span class="typeArea type">Area</span>
                    </button>

                    <div class="w-100 justify-content-end dropdown-card dropdown-building-area2">
                        <div class="d-flex flex-column align-items-end dropdown-card-wrapper check-box-prop-filter">
                            <div class="dropdown-menu-search">
                                <i class="icon-magnifying-glass-1"></i>
                                <textarea type="text" placeholder="Enter search words"
                                          class="dropdown-menu-search__input"></textarea>
                            </div>
                            <ul class="dropdown-card__content">
                                <?php foreach ($arResult['ITEMS'][IBLOCK_PROPERTY_MAP_LAYOUT_JSON_PROP_ID]['VALUES'] as $val => $ar) {
                                    $arState = explode(':', $ar['VALUE']);
                                    ?>
                                    <li <?php echo $ar["DISABLED"] ? 'style"display:none"' : '' ?>
                                            data-filter-for='.dropdown-menu-search'
                                            data-filter="<?= ltrim($arState[1]) ?>">
                                        <label class="cb-wrap">
                                            <span class="text"><?= ltrim($arState[1]) ?></span>
                                            <input type="checkbox"
                                                   data-parent-item-id="<?= base64_decode(ltrim($arState[0])) ?>"
                                                   id="<?php echo $ar["CONTROL_ID"] ?>"
                                                   data-control-id="<?php echo $ar["CONTROL_ID"] ?>"
                                                   data-html-value="<?= $ar['HTML_VALUE'] ?>"
                                                   name="<?php echo $ar["CONTROL_NAME"] ?>"
                                                <?php echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                <?php echo $ar["DISABLED"] ? 'style"display:none"' : '' ?>
                                                   value="<?= ltrim($arState[1]) ?>"
                                                   data-valued="<?= ltrim($arState[1]) ?>"
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <?php
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-30 position-relative dropdown-block">
                    <button id="area1toogle" type="button"
                            class="custom-btn-property custom-btn-property--new btn-property-type ">
                        <i class="icon-arrow-down-sign-to-navigate-3"></i>
                        <span class="typeRegion type">Region</span>
                    </button>

                    <div class="w-100 justify-content-end dropdown-card dropdown-building-area1">
                        <div class="d-flex flex-column align-items-end check-box-prop-filter">

                            <ul class="dropdown-card__content">
                                <?php foreach ($arResult['ITEMS'][IBLOCK_PROPERTY_MAP_LAYOUT_BIG_PROP_ID]['VALUES'] as $val => $ar) { ?>
                                    <li <?php echo $ar["DISABLED"] ? 'style"display:none"' : '' ?>><label
                                                class="cb-wrap">
                                            <span class="text"><?= $ar['VALUE'] ?></span>
                                            <input
                                                    class="data-function"
                                                    type="checkbox"
                                                    data-control-id="<?php echo $ar["CONTROL_ID"] ?>"
                                                    data-html-value="<?= $ar['HTML_VALUE'] ?>"
                                                    id="<?php echo $ar["CONTROL_ID"] ?>"
                                                    name="<?php echo $ar["CONTROL_NAME"] ?>"
                                                <?php echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                <?php echo $ar["DISABLED"] ? '' : '' ?>
                                                    value="<?php echo $ar["VALUE"] ?>"
                                                    data-valued="<?php echo $ar["VALUE"] ?>"
                                            >
                                            <span class="checkmark"></span>
                                        </label></li>
                                    <?php
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="w-17 position-relative">
                    <button type="button" class="custom-btn-property btn-price buttonShowPropertyFilterPrice">
                        <i class="icon-arrow-down-sign-to-navigate-3"></i>
                        <span class="houseRentUserPrise"><?=(!empty($_GET['arrFilter_61_MAX']))? $_GET['arrFilter_61_MAX']  . ' - ' . $_GET['arrFilter_61_MIN'] : 'Цена'?></span>
                    </button>

                    <div class="dropdown-card dropdown-filter dropdown-prise">
                        <div class="input-decoration mr-3">
                            <input value="<?= $_GET['arrFilter_61_MAX'] ?>" data-control-id="arrFilter_61_MAX"
                                   class="priceMax" type="text" name="price" placeholder="До">
                            <span class="decoration">₪</span>
                        </div>

                        <div class="input-decoration">
                            <input value="<?= $_GET['arrFilter_61_MIN'] ?>" data-control-id="arrFilter_61_MIN" data
                                   class="priceMin" type="text" name="price" placeholder="От">
                            <span class="decoration">₪</span>
                        </div>
                    </div>
                </div>
                <?php if (in_array($arParams['SECTION_ID'], COMMERCIAL_SECTION_ARRAY)) { ?>
                    <div class="w-17 position-relative">
                        <button type="button" class="custom-btn-property btn-price buttonShowPropertyFilterArea active">
                            <i class="icon-arrow-down-sign-to-navigate-3"></i>
                            <span class="rentAreaCommerce">Площадь общая</span>
                        </button>

                        <div class="dropdown-card dropdown-filter dropdown-area">
                            <div class="input-decoration mr-3">
                                <input value="<?= $_GET['arrFilter_173_MAX'] ?>" data-control-id="arrFilter_173_MAX"
                                       class="inputAreaMax" name="rentAreaCommerce" type="text" placeholder="До">
                                <span class="decoration">м²</span>
                            </div>

                            <div class="input-decoration">
                                <input value="<?= $_GET['arrFilter_173_MIN'] ?>" data-control-id="arrFilter_173_MIN"
                                       class="inputAreaMin" name="rentAreaCommerce" type="text" placeholder="От">
                                <span class="decoration">м²</span>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="w-17 position-relative">
                        <button type="button" class="custom-btn-property btn-room-number buttonShowPropertyFilterRoom">
                            <i class="icon-arrow-down-sign-to-navigate-3"></i>
                            <span class="countRoomNumberFilter">Число комнат</span>
                        </button>

                        <div class="dropdown-card dropdown-room-number">
                            <div class="mb-4 room-number flex-row-reverse">
                                <?php foreach ($arResult['ITEMS'][IBLOCK_PROPERTY_PROP_COUNT_ROOMS_PROP_ID]['VALUES'] as $VALUE) { ?>
                                    <label class="chackbox-label">
                                        <input <?= ($VALUE['CHECKED']) ? 'checked' : '' ?>
                                                data-control-id="<?= $VALUE['CONTROL_ID'] ?>"
                                                data-html-value="<?= $VALUE['HTML_VALUE'] ?>"
                                                type="checkbox" name="area" value="<?= $VALUE['VALUE'] ?>">
                                        <div><?= $VALUE['VALUE'] ?></div>
                                    </label>
                                <?php } ?>

                            </div>

                            <div class="d-flex flex-column align-items-end check-box-prop-filter">
                                <label class="cb-wrap">
                                    <span class="text">Студия</span>
                                    <input <?=($_GET['arr_rlfr'])? 'checked' : ''?> data-control-id="arr_rlfr" data-html-value='Y' type="checkbox" name="input-studio-rent" value="Студия">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="cb-wrap">
                                    <span class="text">Свободная планировка</span>
                                    <input <?=($_GET['arr_rlfrf'])? 'checked' : ''?> data-control-id="arr_rlfrf" data-html-value='Y' type="checkbox" name="input-free-layout-rent" value="Свободная планировка">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="w-30 position-relative">
                    <button type="button" class="custom-btn-property btn-property-type buttonShowPropertyFilterType">
                        <i class="icon-arrow-down-sign-to-navigate-3"></i>
                        <span class="typeProperty">Тип недвижимости</span>
                    </button>

                    <div class="w-100 justify-content-end dropdown-card dropdown-building-type">
                        <div class="d-flex flex-column align-items-end check-box-prop-filter">
                            <?php foreach ($arResult['ITEMS'][IBLOCK_PROPERTY_PROP_TYPE_APART_PROP_ID]['VALUES'] as $VALUE) { ?>
                                <label class="cb-wrap">
                                    <span class="text"><?= $VALUE['VALUE'] ?></span>
                                    <input <?= ($VALUE['CHECKED']) ? 'checked' : '' ?>
                                            data-control-id="<?= $VALUE['CONTROL_ID'] ?>"
                                            data-html-value="<?= $VALUE['HTML_VALUE'] ?>"
                                            type="checkbox" name="areaTypeBuilduing" value="<?= $VALUE['VALUE'] ?>">
                                    <span class="checkmark"></span>
                                </label>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex sub-menu-prop">
                <!-- отправляет форму с клоном даты  form="sandRequest"-->
                <button type="#" class="btn btn-primary font-weight-bold submit-btn-search">Найти</button>
                <button type="#" class="btn bg-white text-primary font-weight-bold border-primary <?=($_GET['view'] != 'maplist')? 'btn-show-map': 'btn-show-catalog'?>"><?=($_GET['view'] != 'maplist')? 'Показать на карте': 'Показать в каталоге'?></button>

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

                <a href="#" type="button"
                   class="btn-more-filters d-flex justify-content-between align-items-center text-white"
                   data-toggle="modal" data-target="#moreFilterPropertyRent">
                    <i class="icon-arrow-down-sign-to-navigate-3"></i>
                    Еще параметры
                </a>

                <div class="modal-filter-header modal fade" id="moreFilterPropertyRent">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header flex-row-reverse align-items-center justify-content-between">
                                <h5 class="modal-title">Еще фильтры</h5>
                                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <?// Дополнительные фильтры?>
                            <div class="modal-body">
                                <?// Площадь общая?>
                                <?php if (!empty($arResult['ITEMS'][PROP_AREA_2_ID]['VALUES']) && !$isСommercialRentPage && !$isСommercialBuyPage):?>
                                    <div class="row mb-4">
                                        <div class="col-10">
                                            <div class="input-group-modal">
                                                <div class="d-flex flex-row-reverse align-items-center">
                                                    <?php $firstKey = array_key_first($arResult['ITEMS'][PROP_AREA_2_ID]['VALUES'])?>
                                                    <?php foreach ($arResult['ITEMS'][PROP_AREA_2_ID]['VALUES'] as $key => $filterVal):?>
                                                        <div class="input-decoration <?=$firstKey !== $key ? 'mr-3' : ''?>">
                                                            <input value="<?=!empty($_GET[$filterVal['CONTROL_ID']]) ? $_GET[$filterVal['CONTROL_ID']] : ''?>"
                                                                   type="text"
                                                                   data-control-id="<?=$filterVal['CONTROL_ID']?>"
                                                                   name="fullAreaRent"
                                                                   placeholder="<?=Loc::getMessage($key)?>"
                                                            >
                                                            <span class="decoration">м²</span>
                                                        </div>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 text-right"><?=$arResult['ITEMS'][PROP_AREA_2_ID]['NAME']?></div>
                                    </div>
                                <?php endif?>
                                <?// Этаж / Не первый / Не последний?>
                                <?php if (!empty($arResult['ITEMS'][PROP_FLOOR_ID]['VALUES']) &&
                                    !empty($arResult['ITEMS'][PROP_NOT_LAST_ID]['VALUES']) &&
                                    !empty($arResult['ITEMS'][PROP_NOT_FIRST_ID]['VALUES'])):?>
                                    <div class="row mb-4 ">
                                        <div class="col-10">
                                            <div class="d-flex flex-row-reverse align-items-center">
                                                <?php $firstKey = array_key_first($arResult['ITEMS'][PROP_FLOOR_ID]['VALUES'])?>
                                                <?php foreach ($arResult['ITEMS'][PROP_FLOOR_ID]['VALUES'] as $key => $filterVal):?>
                                                    <div class="d-flex input-group-modal">
                                                        <div class="input-decoration <?=$firstKey !== $key ? 'mr-3' : ''?>">
                                                            <input value="<?=!empty($_GET[$filterVal['CONTROL_ID']]) ? $_GET[$filterVal['CONTROL_ID']] : ''?>"
                                                                   data-control-id="<?=$filterVal['CONTROL_ID']?>"
                                                                   name="fleatRent"
                                                                   type="text"
                                                                   placeholder="<?=Loc::getMessage($key)?>"
                                                            >
                                                        </div>
                                                    </div>
                                                <?php endforeach;?>
                                                <div class="mr-5 d-flex check-box-prop-filter">
                                                    <?php foreach ($arResult['ITEMS'][PROP_NOT_FIRST_ID]['VALUES'] as $key => $notFirstVal):?>
                                                        <div class="mr-5">
                                                            <label class="cb-wrap">
                                                                <span class="text"><?=$arResult['ITEMS'][PROP_NOT_FIRST_ID]['NAME']?></span>
                                                                <input  <?=$_GET[$notFirstVal['CONTROL_ID']] === 'Y'? 'checked' : ''?>
                                                                        data-control-id="<?=$notFirstVal['CONTROL_ID']?>"
                                                                        data-html-value="Y"
                                                                        type="checkbox"
                                                                        name="noFirstFloreRent"
                                                                        value="Не первый"
                                                                >
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    <?php endforeach;?>
                                                    <?php foreach ($arResult['ITEMS'][PROP_NOT_LAST_ID]['VALUES'] as $key => $notLastVal):?>
                                                        <label class="cb-wrap">
                                                            <span class="text"><?=$arResult['ITEMS'][PROP_NOT_LAST_ID]['NAME']?></span>
                                                            <input   <?=$_GET[$notLastVal['CONTROL_ID']] === 'Y'? 'checked' : ''?>
                                                                    data-control-id="<?=$notLastVal['CONTROL_ID']?>"
                                                                    data-html-value="Y"
                                                                    type="checkbox"
                                                                    name="noLastFloreRent"
                                                                    value="Не последний"
                                                            >
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 text-right"><?=$arResult['ITEMS'][PROP_FLOOR_ID]['NAME']?></div>
                                    </div>
                                <?php endif?>
                                <?// Дополнительные свойства фильтра?>
                                <?php if (!empty($arResult['ADDITIONAL_PROPS'])):?>
                                    <?php foreach ($arResult['ADDITIONAL_PROPS'] as $propCode => $propInfo) :?>
                                        <div class="row mb-4 ">
                                            <div class="col-10">
                                                <div class="d-flex flex-wrap flex-row-reverse align-items-center">
                                                    <?foreach ($propInfo['VALUES'] as $val){?>
                                                        <label class="parameter">
                                                            <input  <?=(!empty($_GET[$val['CONTROL_ID']]))? 'checked' : ''?>
                                                                    data-html-value="<?= $val['HTML_VALUE'] ?>"
                                                                    data-control-id="<?= $val['CONTROL_ID'] ?>"
                                                                    name="<?=$propInfo['CODE']?>"
                                                                    value="<?=$propInfo['NAME']?> : <?=$val['VALUE']?>"
                                                                    type="checkbox"
                                                            >
                                                            <div><?=$val['VALUE']?></div>
                                                        </label>
                                                    <?}?>
                                                </div>
                                            </div>
                                            <div data-code="<?=$propInfo['CODE']?>" class="col-2 text-right">
                                                <?=$propInfo['NAME']?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?endif;?>
                                <?// Дата въезда / Немедленный въезд?>
                                <?php if (!$isLiveBuyPage && !$isСommercialBuyPage):?>
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="d-flex flex-row-reverse align-items-center">
                                                <?php foreach ($arResult['ITEMS'][PROP_COMPLETION_ID]['VALUES'] as $key => $propDate):?>
                                                    <?php if ($key === 'MIN'):?>
                                                        <div class="d-flex input-group-modal">
                                                            <div class="input-decoration date-input">
                                                                <?
                                                                if (!empty($_GET[$propDate['CONTROL_ID']])) {
                                                                    $dateString = $_GET[$propDate['CONTROL_ID']];
                                                                    $date = DateTime::createFromFormat('d/m/Y', $dateString);
                                                                    $formattedDate = $date->format('Y-m-d');
                                                                }
                                                                ?>
                                                                <input value="<?=!empty($formattedDate) ? $formattedDate : ''?>"
                                                                       data-control-id="<?=$propDate['CONTROL_ID']?>"
                                                                       class="check-in-date"
                                                                       name="check-in-date"
                                                                       type="date"
                                                                       placeholder="Дата въезда"
                                                                >
                                                            </div>
                                                        </div>
                                                    <?php endif?>
                                                <?php endforeach; ?>
                                                <?php foreach ($arResult['ITEMS'][PROP_IMMEDIATELY_ENTRY_ID]['VALUES'] as $key => $prop):?>
                                                    <div class="d-flex check-box-prop-filter">
                                                        <div class="mr-5">
                                                            <label class="cb-wrap">
                                                                <span class="text">
                                                                    <?=$arResult['ITEMS'][PROP_IMMEDIATELY_ENTRY_ID]['NAME']?>
                                                                </span>
                                                                <input  <?=(!empty($_GET[$prop['CONTROL_ID']]))? 'checked' : ''?>
                                                                        data-html-value="<?=$prop['HTML_VALUE']?>"
                                                                        data-control-id="<?=$prop['CONTROL_ID']?>"
                                                                        type="checkbox"
                                                                        name="check-in-now"
                                                                        value="<?=$prop['HTML_VALUE']?>"
                                                                >
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="col-2 text-right"><?=$arResult['ITEMS'][PROP_COMPLETION_ID]['NAME']?></div>
                                    </div>
                                <?php endif;?>
                            </div>
                            <div class="modal-footer flex-row-reverse border-top-0">
                                <button type="button" class="btn text-primary ressetFilterAll">Сбросить фильтры</button>
                                <button type="button" class="btn btn-primary submitFilterAll" data-dismiss="modal">
                                    Применить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Скрытая форма только собирает дату для отправки -->
        <form action="" class="d-none" id="sandRequest">
            <input id="allFilters" type="text" name="filters">
        </form>
    </div>
</div>
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__); ?>

<?
if (CSite::InDir('/property/')) {
$rsParentSection = CIBlockSection::GetByID($arResult["VARIABLES"]["SECTION_ID"]);
$arSections = [];
if ($arParentSection = $rsParentSection->GetNext()) {
    $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'], '>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'], '<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'], '>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'), $arFilter);
    while ($arSect = $rsSect->GetNext()) {
        $arSections[] = $arSect;
    }

}
if (empty($arSections)) {
    $rsParentSection = CIBlockSection::GetByID($arParentSection["IBLOCK_SECTION_ID"]);
    $arSections = [];
    if ($arParentSection = $rsParentSection->GetNext()) {
        $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'], '>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'], '<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'], '>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
        $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'), $arFilter);
        while ($arSect = $rsSect->GetNext()) {
            $arSections[] = $arSect;
        }

    }
}
//костыль для сортировки
$idIblock = $arParams["IBLOCK_ID"];
$arSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_VIP_DATE");
$arFilter = array("IBLOCK_ID" => (int)$idIblock);
$res = CIblockElement::GetList(array("DATE_CREATE" => "DESC"), $arFilter, false, false, $arSelect);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    if ($arFields['PROPERTY_VIP_DATE_VALUE'] != null && strtotime($arFields['PROPERTY_VIP_DATE_VALUE']) < time()) {
        $el = new CIBlockElement;
        $PROP = array();
        $PROP['VIP_DATE'] = "";
        $arLoadProductArray = array(
            "IBLOCK_SECTION" => false,
            "PROPERTY_VALUES" => $PROP,
        );
        $PRODUCT_ID = $arFields['ID'];
        CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_FLAG", 0);
        // $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
        CIBlockElement::SetPropertyValues($PRODUCT_ID, $arParams["IBLOCK_ID"], '', 'VIP_DATE');
    }
}
require($_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php");
$detect = new Mobile_Detect;

?>
    <main class="mb-5 wrapper flex-grow-1">
        <div class="header-property-type-menu">
            <div class="bg-header-filter">
                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/property-header-bg-progressive.jpeg" alt="">
            </div>
            <!-- мобильный список -->
            <div class="d-flex d-lg-none justify-content-center container p-0">
                <ul class="w-100 mb-0 header-property__category-list">
                    <li>
                        <a onclick="routeProperty(event)"
                           href="/property/zhilaya/" <? echo (CSite::InDir('/property/zhilaya/')) ? 'class="active"' : ""; ?>><?= Loc::getMessage('zhilaya'); ?></a>
                    </li>
                    <span class="text-white mx-3">/</span>
                    <li>
                        <a onclick="routeProperty(event)"
                           href="/property/kommercheskaya/" <? echo (CSite::InDir('/property/zhilaya/')) ? 'class="active"' : ""; ?>><?= Loc::getMessage('kommercheskaya'); ?></a>
                    </li>
                </ul>
            </div>
            <!-- end  мобильный список -->
            <div class="d-none d-lg-block container">
                <!--  menu start -->
                <div class="d-flex align-items-center justify-content-end">
                    <ul class="mb-0 header-property__category-list">
                        <li>
                            <a onclick="routeProperty(event)"
                               href="/property/zhilaya/"<? echo (CSite::InDir('/property/zhilaya/')) ? 'class="active"' : ""; ?>><?= Loc::getMessage('zhilaya'); ?></a>
                        </li>

                        <span class="text-white mx-3">/</span>

                        <li>
                            <a onclick="routeProperty(event)"
                               href="/property/kommercheskaya/" <? echo (CSite::InDir('/property/zhilaya/')) ? 'class="active"' : ""; ?>><?= Loc::getMessage('kommercheskaya'); ?></a>
                        </li>
                    </ul>

                    <? if (!$detect->isMobile()) { ?>
                    <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.smart.filter",
                        "bootstrap_v4",
                        array(
                            "COMPONENT_TEMPLATE" => "PropertyMainFilterDesktop",
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                            "FILTER_NAME" => "arrFilter",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "TEMPLATE_THEME" => "blue",
                            "FILTER_VIEW_MODE" => "horizontal",
                            "DISPLAY_ELEMENT_COUNT" => "Y",
                            "SEF_MODE" => "N",
                            "CACHE_TYPE" => "N",
                            "CACHE_TIME" => "36000000",
                            "CACHE_GROUPS" => "N",
                            "SAVE_IN_SESSION" => "N",
                            "INSTANT_RELOAD" => "Y",
                            "PAGER_PARAMS_NAME" => "arrPager",
                            "PRICE_CODE" => array(
                                0 => "BASE",
                            ),
                            "CONVERT_CURRENCY" => "Y",
                            "XML_EXPORT" => "N",
                            "SECTION_TITLE" => "-",
                            "SECTION_DESCRIPTION" => "-",
                            "POPUP_POSITION" => "left",
                            "SEF_RULE" => "/flea/#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
                            "SECTION_CODE_PATH" => "",
                            "SMART_FILTER_PATH" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
                            "CURRENCY_ID" => "RUB",
                            "PREFILTER_NAME" => "smartPreFilter"
                        ),
                        false
                    ); ?>


                    <div class="modal-filter-header modal fade" id="moreFilterPropertyRent">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header flex-row-reverse align-items-center justify-content-between">
                                    <h5 class="modal-title"><?= Loc::getMessage('more'); ?></h5>

                                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.smart.filter",
                                    "PropertyMainFilterModal",
                                    array(
                                        "COMPONENT_TEMPLATE" => "PropertyMainFilterModal",
                                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                                        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                                        "FILTER_NAME" => "arrFilter",
                                        "HIDE_NOT_AVAILABLE" => "N",
                                        "TEMPLATE_THEME" => "blue",
                                        "FILTER_VIEW_MODE" => "horizontal",
                                        "DISPLAY_ELEMENT_COUNT" => "Y",
                                        "SEF_MODE" => "N",
                                        "CACHE_TYPE" => "N",
                                        "CACHE_TIME" => "36000000",
                                        "CACHE_GROUPS" => "Y",
                                        "SAVE_IN_SESSION" => "Y",
                                        "INSTANT_RELOAD" => "Y",

                                        "PAGER_PARAMS_NAME" => "arrPager",
                                        "PRICE_CODE" => array(
                                            0 => "BASE",
                                        ),
                                        "CONVERT_CURRENCY" => "Y",
                                        "XML_EXPORT" => "N",
                                        "SECTION_TITLE" => "-",
                                        "SECTION_DESCRIPTION" => "-",
                                        "POPUP_POSITION" => "left",
                                        "SEF_RULE" => "/flea/#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
                                        "SECTION_CODE_PATH" => "",
                                        "SMART_FILTER_PATH" => '#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/',
                                        "CURRENCY_ID" => "RUB"
                                    ),
                                    false
                                );
                                } ?>

                            </div>
                        </div>
                    </div>
                </div>
                </form>

            </div>
        </div>

        <?
        } else {
            ?>

        <? }
        if (!CSite::InDir('/index.php')) {
            $APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "template_breadcrumbs",
                array(
                    "PATH" => "",
                    "SITE_ID" => SITE_ID,
                    "START_FROM" => "0"
                )
            );
        }
        ?>
        <? if ($detect->isMobile()) { ?>
            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.smart.filter",
                "PropertyFilter",
                array(
                    "COMPONENT_TEMPLATE" => "PropertyFilter",
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "FILTER_VIEW_MODE" => "horizontal",
                    "DISPLAY_ELEMENT_COUNT" => "Y",
                    "SEF_MODE" => "N",
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "Y",
                    "SAVE_IN_SESSION" => "Y",

                    "PAGER_PARAMS_NAME" => "arrPager",
                    "PRICE_CODE" => array(
                        0 => "BASE",
                    ),
                    "CONVERT_CURRENCY" => "Y",
                    "XML_EXPORT" => "N",
                    "SECTION_TITLE" => "-",
                    "SECTION_DESCRIPTION" => "-",
                    "POPUP_POSITION" => "left",
                    "SEF_RULE" => "/flea/#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
                    "SECTION_CODE_PATH" => "",
                    "SMART_FILTER_PATH" => '#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/',
                    "CURRENCY_ID" => "RUB"
                ),
                false
            );
        } ?>
        <?
        $dir = $APPLICATION->GetCurDir();
        $dirName = str_replace('/', '', $dir); // PHP код
        if ($_GET['view'] == 'maplist') {
            ?>
            <?

            $template1 = 'templatePropertyListMap';
             if ($detect->isMobile()){$template1 = 'templatePropertyBlockMap';}
            if ($_SESSION['view'] == 'block') {
                $template1 = 'templatePropertyBlockMap';
            }
            $APPLICATION->IncludeComponent("bitrix:catalog.section", $template1, array(
                "ACTION_VARIABLE" => "action",    // Название переменной, в которой передается действие
                "ADD_PROPERTIES_TO_BASKET" => "Y",    // Добавлять в корзину свойства товаров и предложений
                "ADD_SECTIONS_CHAIN" => "Y",    // Включать раздел в цепочку навигации
                "AJAX_MODE" => "N",
                "INSTANT_RELOAD" => "N",// Включить режим AJAX
                "AJAX_OPTION_ADDITIONAL" => "",    // Дополнительный идентификатор
                "AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
                "AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
                "AJAX_OPTION_STYLE" => "Y",    // Включить подгрузку стилей
                "BACKGROUND_IMAGE" => "-",    // Установить фоновую картинку для шаблона из свойства
                "BASKET_URL" => "/personal/basket.php",    // URL, ведущий на страницу с корзиной покупателя
                "BROWSER_TITLE" => "-",    // Установить заголовок окна браузера из свойства
                "CACHE_FILTER" => "N",    // Кешировать при установленном фильтре
                "CACHE_GROUPS" => "Y",    // Учитывать права доступа
                "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
                "CACHE_TYPE" => "N",    // Тип кеширования
                "COMPATIBLE_MODE" => "Y",    // Включить режим совместимости
                "DETAIL_URL" => "",    // URL, ведущий на страницу с содержимым элемента раздела
                "DISABLE_INIT_JS_IN_COMPONENT" => "N",    // Не подключать js-библиотеки в компоненте
                "DISPLAY_BOTTOM_PAGER" => "Y",    // Выводить под списком
                "DISPLAY_COMPARE" => "N",    // Разрешить сравнение товаров
                "DISPLAY_TOP_PAGER" => "N",    // Выводить над списком
                "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                "ENLARGE_PRODUCT" => "STRICT",    // Выделять товары в списке
                "FILTER_NAME" => "arrFilter",    // Имя массива со значениями фильтра для фильтрации элементов
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],    // Инфоблок
                "IBLOCK_TYPE" => "announcements",    // Тип инфоблока
                "INCLUDE_SUBSECTIONS" => "Y",    // Показывать элементы подразделов раздела
                "LAZY_LOAD" => "N",    // Показать кнопку ленивой загрузки Lazy Load
                "LINE_ELEMENT_COUNT" => "3",    // Количество элементов выводимых в одной строке таблицы
                "LOAD_ON_SCROLL" => "N",    // Подгружать товары при прокрутке до конца
                "MESSAGE_404" => "",    // Сообщение для показа (по умолчанию из компонента)
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",    // Текст кнопки "Добавить в корзину"
                "MESS_BTN_BUY" => "Купить",    // Текст кнопки "Купить"
                "MESS_BTN_DETAIL" => "Подробнее",    // Текст кнопки "Подробнее"
                "MESS_BTN_LAZY_LOAD" => "Показать ещё",    // Текст кнопки "Показать ещё"
                "MESS_BTN_SUBSCRIBE" => "Подписаться",    // Текст кнопки "Уведомить о поступлении"
                "MESS_NOT_AVAILABLE" => "Нет в наличии",    // Сообщение об отсутствии товара
                "META_DESCRIPTION" => "-",    // Установить описание страницы из свойства
                "META_KEYWORDS" => "-",    // Установить ключевые слова страницы из свойства
                "OFFERS_LIMIT" => "5",    // Максимальное количество предложений для показа (0 - все)
                "PAGER_BASE_LINK_ENABLE" => "N",    // Включить обработку ссылок
                "PAGER_DESC_NUMBERING" => "N",    // Использовать обратную навигацию
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",    // Время кеширования страниц для обратной навигации
                "PAGER_SHOW_ALL" => "N",    // Показывать ссылку "Все"
                "PAGER_SHOW_ALWAYS" => "N",    // Выводить всегда
                "PAGER_TEMPLATE" => ".default",    // Шаблон постраничной навигации
                "PAGER_TITLE" => "Товары",    // Название категорий
                "PAGE_ELEMENT_COUNT" => "12",    // Количество элементов на странице
                "PARTIAL_PRODUCT_PROPERTIES" => "N",    // Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
                "PRICE_CODE" => "",    // Тип цены
                "PRICE_VAT_INCLUDE" => "Y",    // Включать НДС в цену
                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",    // Порядок отображения блоков товара
                "PRODUCT_ID_VARIABLE" => "id",    // Название переменной, в которой передается код товара для покупки
                "PRODUCT_PROPS_VARIABLE" => "prop",    // Название переменной, в которой передаются характеристики товара
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",    // Название переменной, в которой передается количество товара
                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",    // Вариант отображения товаров
                "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],    // Параметр ID продукта (для товарных рекомендаций)
                "RCM_TYPE" => "personal",    // Тип рекомендации
                "SECTION_CODE" => $_REQUEST["SECTION_CODE"],    // Код раздела
                "SECTION_ID" => $_REQUEST["SECTION_ID"],    // ID раздела
                "SECTION_ID_VARIABLE" => "SECTION_ID",    // Название переменной, в которой передается код группы
                "SECTION_URL" => "",    // URL, ведущий на страницу с содержимым раздела
                "SECTION_USER_FIELDS" => array(    // Свойства раздела
                    0 => "",
                    1 => "",
                ),
                "SEF_MODE" => "N",    // Включить поддержку ЧПУ
                "SET_BROWSER_TITLE" => "Y",    // Устанавливать заголовок окна браузера
                "SET_LAST_MODIFIED" => "N",    // Устанавливать в заголовках ответа время модификации страницы
                "SET_META_DESCRIPTION" => "Y",    // Устанавливать описание страницы
                "SET_META_KEYWORDS" => "Y",    // Устанавливать ключевые слова страницы
                "SET_STATUS_404" => "N",    // Устанавливать статус 404
                "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
                "SHOW_404" => "N",    // Показ специальной страницы
                "SHOW_ALL_WO_SECTION" => "N",    // Показывать все элементы, если не указан раздел
                "SHOW_FROM_SECTION" => "N",    // Показывать товары из раздела
                "SHOW_PRICE_COUNT" => "1",    // Выводить цены для количества
                "SHOW_SLIDER" => "Y",    // Показывать слайдер для товаров
                "SLIDER_INTERVAL" => "3000",    // Интервал смены слайдов, мс
                "SLIDER_PROGRESS" => "N",    // Показывать полосу прогресса
                "TEMPLATE_THEME" => "blue",    // Цветовая тема
                "USE_ENHANCED_ECOMMERCE" => "N",    // Отправлять данные электронной торговли в Google и Яндекс
                "USE_MAIN_ELEMENT_SECTION" => "N",    // Использовать основной раздел для показа элемента
                "USE_PRICE_COUNT" => "N",    // Использовать вывод цен с диапазонами
                "USE_PRODUCT_QUANTITY" => "N",    // Разрешить указание количества товара
                "COMPONENT_TEMPLATE" => ".default",
                "PROPERTY_CODE_MOBILE" => "",    // Свойства товаров, отображаемые на мобильных устройствах
                "ADD_PICT_PROP" => "-",    // Дополнительная картинка основного товара
                "LABEL_PROP" => "",    // Свойства меток товара
            ),
                false
            ); ?>

        <? } else {

            ?>
            <div class="container ">

                <? $APPLICATION->IncludeComponent("bitrix:catalog.section", "templatePropSliderList", array(
                    "ACTION_VARIABLE" => "action",    // Название переменной, в которой передается действие
                    "ADD_PROPERTIES_TO_BASKET" => "Y",    // Добавлять в корзину свойства товаров и предложений
                    "ADD_SECTIONS_CHAIN" => "N",    // Включать раздел в цепочку навигации
                    "AJAX_MODE" => "N",    // Включить режим AJAX
                    "AJAX_OPTION_ADDITIONAL" => "",    // Дополнительный идентификатор
                    "AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
                    "AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
                    "AJAX_OPTION_STYLE" => "Y",    // Включить подгрузку стилей
                    "BACKGROUND_IMAGE" => "-",    // Установить фоновую картинку для шаблона из свойства
                    "BASKET_URL" => "/personal/basket.php",    // URL, ведущий на страницу с корзиной покупателя
                    "BROWSER_TITLE" => "-",    // Установить заголовок окна браузера из свойства
                    "CACHE_FILTER" => "N",    // Кешировать при установленном фильтре
                    "CACHE_GROUPS" => "Y",    // Учитывать права доступа
                    "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
                    "CACHE_TYPE" => "N",    // Тип кеширования
                    "COMPATIBLE_MODE" => "Y",    // Включить режим совместимости
                    "DETAIL_URL" => "",    // URL, ведущий на страницу с содержимым элемента раздела
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",    // Не подключать js-библиотеки в компоненте
                    "DISPLAY_BOTTOM_PAGER" => "Y",    // Выводить под списком
                    "DISPLAY_COMPARE" => "N",    // Разрешить сравнение товаров
                    "DISPLAY_TOP_PAGER" => "N",    // Выводить над списком
                    "ELEMENT_SORT_FIELD" => "sort",    // По какому полю сортируем элементы
                    "ELEMENT_SORT_FIELD2" => "id",    // Поле для второй сортировки элементов
                    "ELEMENT_SORT_ORDER" => "asc",    // Порядок сортировки элементов
                    "ELEMENT_SORT_ORDER2" => "desc",    // Порядок второй сортировки элементов
                    "ENLARGE_PRODUCT" => "STRICT",    // Выделять товары в списке
                    "FILTER_NAME" => "arrFilter",    // Имя массива со значениями фильтра для фильтрации элементов
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],    // Инфоблок
                    "IBLOCK_TYPE" => "announcements",    // Тип инфоблока
                    "INCLUDE_SUBSECTIONS" => "Y",    // Показывать элементы подразделов раздела
                    "LAZY_LOAD" => "N",    // Показать кнопку ленивой загрузки Lazy Load
                    "LINE_ELEMENT_COUNT" => "3",    // Количество элементов выводимых в одной строке таблицы
                    "LOAD_ON_SCROLL" => "N",    // Подгружать товары при прокрутке до конца
                    "MESSAGE_404" => "",    // Сообщение для показа (по умолчанию из компонента)
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",    // Текст кнопки "Добавить в корзину"
                    "MESS_BTN_BUY" => "Купить",    // Текст кнопки "Купить"
                    "MESS_BTN_DETAIL" => "Подробнее",    // Текст кнопки "Подробнее"
                    "MESS_BTN_LAZY_LOAD" => "Показать ещё",    // Текст кнопки "Показать ещё"
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",    // Текст кнопки "Уведомить о поступлении"
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",    // Сообщение об отсутствии товара
                    "META_DESCRIPTION" => "-",    // Установить описание страницы из свойства
                    "META_KEYWORDS" => "-",    // Установить ключевые слова страницы из свойства
                    "OFFERS_LIMIT" => "5",    // Максимальное количество предложений для показа (0 - все)
                    "PAGER_BASE_LINK_ENABLE" => "N",    // Включить обработку ссылок
                    "PAGER_DESC_NUMBERING" => "N",    // Использовать обратную навигацию
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",    // Время кеширования страниц для обратной навигации
                    "PAGER_SHOW_ALL" => "N",    // Показывать ссылку "Все"
                    "PAGER_SHOW_ALWAYS" => "N",    // Выводить всегда
                    "PAGER_TEMPLATE" => ".default",    // Шаблон постраничной навигации
                    "PAGER_TITLE" => "Товары",    // Название категорий
                    "PAGE_ELEMENT_COUNT" => "100000",    // Количество элементов на странице
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",    // Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
                    "PRICE_CODE" => "",    // Тип цены
                    "PRICE_VAT_INCLUDE" => "Y",    // Включать НДС в цену
                    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",    // Порядок отображения блоков товара
                    "PRODUCT_ID_VARIABLE" => "id",    // Название переменной, в которой передается код товара для покупки
                    "PRODUCT_PROPS_VARIABLE" => "prop",    // Название переменной, в которой передаются характеристики товара
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",    // Название переменной, в которой передается количество товара
                    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",    // Вариант отображения товаров
                    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],    // Параметр ID продукта (для товарных рекомендаций)
                    "RCM_TYPE" => "personal",    // Тип рекомендации
                    "SECTION_CODE" => "",    // Код раздела
                    "SECTION_ID" => $_REQUEST["SECTION_ID"],    // ID раздела
                    "SECTION_ID_VARIABLE" => "SECTION_ID",    // Название переменной, в которой передается код группы
                    "SECTION_URL" => "",    // URL, ведущий на страницу с содержимым раздела
                    "SECTION_USER_FIELDS" => array(    // Свойства раздела
                        0 => "",
                        1 => "",
                    ),
                    "SEF_MODE" => "Y",    // Включить поддержку ЧПУ
                    "SET_BROWSER_TITLE" => "Y",    // Устанавливать заголовок окна браузера
                    "SET_LAST_MODIFIED" => "N",    // Устанавливать в заголовках ответа время модификации страницы
                    "SET_META_DESCRIPTION" => "Y",    // Устанавливать описание страницы
                    "SET_META_KEYWORDS" => "Y",    // Устанавливать ключевые слова страницы
                    "SET_STATUS_404" => "N",    // Устанавливать статус 404
                    "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
                    "SHOW_404" => "N",    // Показ специальной страницы
                    "SHOW_ALL_WO_SECTION" => "N",    // Показывать все элементы, если не указан раздел
                    "SHOW_FROM_SECTION" => "N",    // Показывать товары из раздела
                    "SHOW_PRICE_COUNT" => "1",    // Выводить цены для количества
                    "SHOW_SLIDER" => "Y",    // Показывать слайдер для товаров
                    "SLIDER_INTERVAL" => "3000",    // Интервал смены слайдов, мс
                    "SLIDER_PROGRESS" => "N",    // Показывать полосу прогресса
                    "TEMPLATE_THEME" => "blue",    // Цветовая тема
                    "USE_ENHANCED_ECOMMERCE" => "N",    // Отправлять данные электронной торговли в Google и Яндекс
                    "USE_MAIN_ELEMENT_SECTION" => "N",    // Использовать основной раздел для показа элемента
                    "USE_PRICE_COUNT" => "N",    // Использовать вывод цен с диапазонами
                    "USE_PRODUCT_QUANTITY" => "N",    // Разрешить указание количества товара
                    "COMPONENT_TEMPLATE" => ".default",
                    "PROPERTY_CODE_MOBILE" => "",    // Свойства товаров, отображаемые на мобильных устройствах
                    "ADD_PICT_PROP" => "-",    // Дополнительная картинка основного товара
                    "LABEL_PROP" => "",    // Свойства меток товара
                ),
                    false
                );
                //костыль для сортировки
                $idIblock = $arParams["IBLOCK_ID"];
                $arSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_VIP_DATE");
                $arFilter = array("IBLOCK_ID" => (int)$idIblock);
                $res = CIblockElement::GetList(array("DATE_CREATE" => "DESC"), $arFilter, false, false, $arSelect);
                while ($ob = $res->GetNextElement()) {
                    $arFields = $ob->GetFields();
                    if ($arFields['PROPERTY_VIP_DATE_VALUE'] != null && strtotime($arFields['PROPERTY_VIP_DATE_VALUE']) < time()) {
                        $el = new CIBlockElement;
                        $PROP = array();
                        $PROP['VIP_DATE'] = "";
                        $arLoadProductArray = array(
                            "IBLOCK_SECTION" => false,
                            "PROPERTY_VALUES" => $PROP,
                        );
                        $PRODUCT_ID = $arFields['ID'];
                        // $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
                        CIBlockElement::SetPropertyValues($PRODUCT_ID, $arParams["IBLOCK_ID"], '', 'VIP_DATE');
                    }
                }

                ?>


                <h1 class="h2 mb-4 subtitle">
                    <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include-area/" . mb_strtolower($dirName) . "-h1-ru.php",
                            "EDIT_TEMPLATE" => ""
                        )
                    );
                    // символы для удаления


                    ?>
                </h1>

                <div class="row">
                    <div class="col d-flex flex-column ">

                        <?
                        $template = 'templatePropertyList';


                        if ($_SESSION['view'] == 'block') {
                            $template = 'templatePropertyBlock';
                        }
                        $APPLICATION->IncludeComponent("bitrix:catalog.section", $template, array(
                            "ACTION_VARIABLE" => "action",    // Название переменной, в которой передается действие
                            "ADD_PROPERTIES_TO_BASKET" => "Y",    // Добавлять в корзину свойства товаров и предложений
                            "ADD_SECTIONS_CHAIN" => "Y",    // Включать раздел в цепочку навигации
                            "AJAX_MODE" => "N",    // Включить режим AJAX
                            "AJAX_OPTION_ADDITIONAL" => "",    // Дополнительный идентификатор
                            "AJAX_OPTION_HISTORY" => "Y",    // Включить эмуляцию навигации браузера
                            "AJAX_OPTION_JUMP" => "Y",    // Включить прокрутку к началу компонента
                            "AJAX_OPTION_STYLE" => "Y",    // Включить подгрузку стилей
                            "BACKGROUND_IMAGE" => "-",    // Установить фоновую картинку для шаблона из свойства
                            "BASKET_URL" => "/personal/basket.php",    // URL, ведущий на страницу с корзиной покупателя
                            "BROWSER_TITLE" => "-",    // Установить заголовок окна браузера из свойства
                            "CACHE_FILTER" => "N",    // Кешировать при установленном фильтре
                            "CACHE_GROUPS" => "Y",    // Учитывать права доступа
                            "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
                            "CACHE_TYPE" => "N",    // Тип кеширования
                            "COMPATIBLE_MODE" => "Y",    // Включить режим совместимости
                            "DETAIL_URL" => "",    // URL, ведущий на страницу с содержимым элемента раздела
                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",    // Не подключать js-библиотеки в компоненте
                            "DISPLAY_BOTTOM_PAGER" => "Y",    // Выводить под списком
                            "DISPLAY_COMPARE" => "N",    // Разрешить сравнение товаров
                            "DISPLAY_TOP_PAGER" => "N",    // Выводить над списком
                            "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                            "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                            "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                            "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                            "ENLARGE_PRODUCT" => "STRICT",    // Выделять товары в списке
                            "FILTER_NAME" => "arrFilter",    // Имя массива со значениями фильтра для фильтрации элементов
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],    // Инфоблок
                            "IBLOCK_TYPE" => "announcements",    // Тип инфоблока
                            "INCLUDE_SUBSECTIONS" => "Y",    // Показывать элементы подразделов раздела
                            "LAZY_LOAD" => "N",    // Показать кнопку ленивой загрузки Lazy Load
                            "LINE_ELEMENT_COUNT" => "3",    // Количество элементов выводимых в одной строке таблицы
                            "LOAD_ON_SCROLL" => "N",    // Подгружать товары при прокрутке до конца
                            "MESSAGE_404" => "",    // Сообщение для показа (по умолчанию из компонента)
                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",    // Текст кнопки "Добавить в корзину"
                            "MESS_BTN_BUY" => "Купить",    // Текст кнопки "Купить"
                            "MESS_BTN_DETAIL" => "Подробнее",    // Текст кнопки "Подробнее"
                            "MESS_BTN_LAZY_LOAD" => "Показать ещё",    // Текст кнопки "Показать ещё"
                            "MESS_BTN_SUBSCRIBE" => "Подписаться",    // Текст кнопки "Уведомить о поступлении"
                            "MESS_NOT_AVAILABLE" => "Нет в наличии",    // Сообщение об отсутствии товара
                            "META_DESCRIPTION" => "-",    // Установить описание страницы из свойства
                            "META_KEYWORDS" => "-",    // Установить ключевые слова страницы из свойства
                            "OFFERS_LIMIT" => "5",    // Максимальное количество предложений для показа (0 - все)
                            "PAGER_BASE_LINK_ENABLE" => "N",    // Включить обработку ссылок
                            "PAGER_DESC_NUMBERING" => "N",    // Использовать обратную навигацию
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",    // Время кеширования страниц для обратной навигации
                            "PAGER_SHOW_ALL" => "N",    // Показывать ссылку "Все"
                            "PAGER_SHOW_ALWAYS" => "N",    // Выводить всегда
                            "PAGER_TEMPLATE" => ".default",    // Шаблон постраничной навигации
                            "PAGER_TITLE" => "Товары",    // Название категорий
                            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],   // Количество элементов на странице
                            "PARTIAL_PRODUCT_PROPERTIES" => "N",    // Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
                            "PRICE_CODE" => "",    // Тип цены
                            "PRICE_VAT_INCLUDE" => "Y",    // Включать НДС в цену
                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",    // Порядок отображения блоков товара
                            "PRODUCT_ID_VARIABLE" => "id",    // Название переменной, в которой передается код товара для покупки
                            "PRODUCT_PROPS_VARIABLE" => "prop",    // Название переменной, в которой передаются характеристики товара
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",    // Название переменной, в которой передается количество товара
                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",    // Вариант отображения товаров
                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],    // Параметр ID продукта (для товарных рекомендаций)
                            "RCM_TYPE" => "personal",    // Тип рекомендации
                            "SECTION_CODE" => $_REQUEST["SECTION_CODE"],    // Код раздела
                            "SECTION_ID" => $_REQUEST["SECTION_ID"],    // ID раздела
                            "SECTION_ID_VARIABLE" => "SECTION_ID",    // Название переменной, в которой передается код группы
                            "SECTION_URL" => "",    // URL, ведущий на страницу с содержимым раздела
                            "SECTION_USER_FIELDS" => array(    // Свойства раздела
                                0 => "",
                                1 => "",
                            ),
                            "SEF_MODE" => "N",    // Включить поддержку ЧПУ
                            "SET_BROWSER_TITLE" => "Y",    // Устанавливать заголовок окна браузера
                            "SET_LAST_MODIFIED" => "N",    // Устанавливать в заголовках ответа время модификации страницы
                            "SET_META_DESCRIPTION" => "Y",    // Устанавливать описание страницы
                            "SET_META_KEYWORDS" => "Y",    // Устанавливать ключевые слова страницы
                            "SET_STATUS_404" => "N",    // Устанавливать статус 404
                            "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
                            "SHOW_404" => "N",    // Показ специальной страницы
                            "SHOW_ALL_WO_SECTION" => "N",    // Показывать все элементы, если не указан раздел
                            "SHOW_FROM_SECTION" => "N",    // Показывать товары из раздела
                            "SHOW_PRICE_COUNT" => "1",    // Выводить цены для количества
                            "SHOW_SLIDER" => "Y",    // Показывать слайдер для товаров
                            "SLIDER_INTERVAL" => "3000",    // Интервал смены слайдов, мс
                            "SLIDER_PROGRESS" => "N",    // Показывать полосу прогресса
                            "TEMPLATE_THEME" => "blue",    // Цветовая тема
                            "USE_ENHANCED_ECOMMERCE" => "N",    // Отправлять данные электронной торговли в Google и Яндекс
                            "USE_MAIN_ELEMENT_SECTION" => "N",    // Использовать основной раздел для показа элемента
                            "USE_PRICE_COUNT" => "N",    // Использовать вывод цен с диапазонами
                            "USE_PRODUCT_QUANTITY" => "N",    // Разрешить указание количества товара
                            "COMPONENT_TEMPLATE" => ".default",
                            "PROPERTY_CODE_MOBILE" => "",    // Свойства товаров, отображаемые на мобильных устройствах
                            "ADD_PICT_PROP" => "-",    // Дополнительная картинка основного товара
                            "LABEL_PROP" => "",    // Свойства меток товара
                        ),
                            false
                        ); ?>
                        <?php
                        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        $needle   = 'PAGEN';
                        $pos      = strripos($url, $needle);
                        
                        if ($pos === false) {?>
                        <div class="flex-column">
                            <?

                            $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include-area/" . mb_strtolower($dirName) . "-h1-sub-ru.php",
                                    "EDIT_TEMPLATE" => ""
                                )
                            ); ?>
                            <?
                            $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include-area/" . mb_strtolower($dirName) . "-text-ru.php",
                                    "EDIT_TEMPLATE" => ""
                                )
                            ); ?>
                        </div>
                        <?}?>
                    </div>
                    <script>
                        $(document).on("click", '.catalogajax .numbers a', function (e) {
                            e.preventDefault();
                            //  alert(2);
                            var href = $(this).attr('href');
                            history.pushState(null, null, href);
                            $.get(
                                href,
                                function (data) {
                                    $('.catalogajax').html($(data).find('.catalogajax').html());
                                }
                            );

                        });
                    </script>
                </div>
            </div>

            </div>
        <? } ?>

        <script>
            function routeProperty(event) {
                event.preventDefault();
                let href = $('#modef').find('a').attr('href');
                let href2 = $(event.target).attr('href')
                window.location.href = href.replace('/property/', href2);
            }
        </script>

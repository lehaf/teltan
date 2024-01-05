<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString('<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>');
Asset::getInstance()->addString('<script src="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js"></script>');
Asset::getInstance()->addCss('https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css');

/** @global object $APPLICATION */
/** @var array $arResult */
/** @var array $arParams */

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

switch ($arParams['SECTION_ID']) {
    case RESIDENTIAL_SECTION_ID:
        LocalRedirect('/property/zhilaya/snyat-j/');
        break;
    case COMMERCIAL_SECTION_ID:
        LocalRedirect('/property/kommercheskaya/snyat-kom/');
        break;
    case NEW_SECTION_ID:
        LocalRedirect('/property/novostroyki/snyat/');
        break;
}

require_once($_SERVER["DOCUMENT_ROOT"]."/vendor/autoload.php");
$detect = new Mobile_Detect;
$dir = $APPLICATION->GetCurDir();
$dirName = str_replace('/', '', $dir); // PHP код
if (!empty($arResult["VARIABLES"]["SECTION_ID"]))
    $curSection = getSectionData($arResult["VARIABLES"]["SECTION_ID"], $arParams["IBLOCK_ID"]);

switch (LANGUAGE_ID) {
    case 'he':
        $langId = 'HEB';
        break;
    case 'en':
        $langId = 'EN';
        break;
    default:
        $langId = false;
}

$sectionName = $langId === false ? $curSection['NAME'] : $curSection['UF_NAME_'.$langId];
?>
<main class="mb-5 wrapper flex-grow-1">
    <div class="preloader">
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>
    <?php
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.smart.filter",
        "property_desktop",
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
            "CACHE_TYPE" => "A",
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


    if(!CSite::InDir('/index.php')) {
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

    if ($detect->isMobile()) {
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            "property_mobile",
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
                "CACHE_TYPE" => "A",
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
                "SMART_FILTER_PATH" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
                "CURRENCY_ID" => "RUB",
                "PREFILTER_NAME" => "smartPreFilter"
            ),
            false
        );
    }

    if ($_GET['view'] == 'maplist') {
        $adsMapTemplate = 'templatePropertyListMap';
        if ($detect->isMobile()) $adsMapTemplate = 'templatePropertyBlockMap';
        if ($_SESSION['view'] == 'tile') $adsMapTemplate = 'templatePropertyBlockMap';

        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            $adsMapTemplate,
            array(
                "SECTION_NAME" => $sectionName,
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
                "CACHE_TYPE" => "A",    // Тип кеширования
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
                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],    // ID раздела
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
        );

    } else { ?>
        <div class="container">
            <?php
            global $vipSliderFilter;
            $vipSliderFilter = [
                '!=PROPERTY_VIP_FLAG' => false,
                '!=PROPERTY_VIP_DATE' => false,
                ">PROPERTY_VIP_DATE" => date('Y-m-d H:i:s')
            ];

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "vip_slider",
                array(
                    'SECTION_NAME' => $sectionName,
                    'SECTION_PAGE_URL' => $curSection['SECTION_PAGE_URL'],
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
                    "CACHE_FILTER" => "Y",    // Кешировать при установленном фильтре
                    "CACHE_GROUPS" => "Y",    // Учитывать права доступа
                    "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
                    "CACHE_TYPE" => "A",    // Тип кеширования
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
                    "FILTER_NAME" => "vipSliderFilter",    // Имя массива со значениями фильтра для фильтрации элементов
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
                    "PAGE_ELEMENT_COUNT" => "100000000",    // Количество элементов на странице
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
                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
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
            ); ?>
            <h1 class="h2 mb-4 subtitle"><?=$sectionName?></h1>
            <div class="row">
                <?php if ($request->get('isAjax') === 'y') $APPLICATION->RestartBuffer()?>
                <div id="target_container" class="col d-flex flex-column">
                    <?php $APPLICATION->ShowViewContent('map_points');?>
                    <div class="mb-5 row d-flex align-items-center">
                        <?php $APPLICATION->ShowViewContent('upper_nav');?>
                        <?php $APPLICATION->IncludeComponent(
                            "webco:sort.panel",
                            "",
                            array(
                                'SORTS' => [
                                    [
                                        'NAME' => 'Price: Low to High',
                                        'SORT' => 'property_PRICE',
                                        'ORDER' => 'ASC'
                                    ],
                                    [
                                        'NAME' => 'Price: High to Low',
                                        'SORT' => 'property_PRICE',
                                        'ORDER' => 'DESC'
                                    ],
                                    [
                                        'NAME' => 'Date: Low to High',
                                        'SORT' => 'property_TIME_RAISE',
                                        'ORDER' => 'ASC'
                                    ],
                                    [
                                        'NAME' => 'Date: High to Low',
                                        'SORT' => 'property_TIME_RAISE',
                                        'ORDER' => 'DESC'
                                    ]
                                ],
                                'VIEWS' => [
                                    'list' => [
                                        'CLASS' => 'icon-sirting_line'
                                    ],
                                    'tile' => [
                                        'CLASS' => 'icon-sirting_block'
                                    ],
                                ]
                            )
                        );?>
                    </div>
                    <?php
                    $session = \Bitrix\Main\Application::getInstance()->getSession();
                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        $session->get('view'),
                        array(
                            "CATEGORY" => PROPERTY_ADS_TYPE_CODE,
                            "SECTION_NAME" => $sectionName,
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                            "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                            "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                            "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                            "PROPERTY_CODE" => ['SHOW_COUNTER'],
                            "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                            "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                            "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                            "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                            "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                            "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                            "BASKET_URL" => $arParams["BASKET_URL"],
                            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                            "FILTER_NAME" => 'adsListFilter',
                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                            "SET_TITLE" => $arParams["SET_TITLE"],
                            "MESSAGE_404" => $arParams["~MESSAGE_404"],
                            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                            "SHOW_404" => $arParams["SHOW_404"],
                            "FILE_404" => $arParams["FILE_404"],
                            "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                            "PRICE_CODE" => $arParams["~PRICE_CODE"],
                            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                            "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                            "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                            "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                            "PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),
                            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                            "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                            "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                            "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                            "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                            "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
                            "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],
                            "OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
                            "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                            "OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
                            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                            "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                            "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                            "OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),
                            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                            "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                            "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                            'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                            'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
                            'LABEL_PROP' => $arParams['LABEL_PROP'],
                            'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                            'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                            'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                            'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                            'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                            'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
                            'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                            'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                            'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                            'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                            'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',
                            'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                            'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
                            'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                            'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                            'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                            'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                            'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                            'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                            'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                            'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                            'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                            'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                            'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                            'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),
                            'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                            'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                            'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),
                            'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                            "ADD_SECTIONS_CHAIN" => "N",
                            'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                            'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
                            'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                            'USE_COMPARE_LIST' => 'Y',
                            'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                            'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
                            'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
                        ),
                        false
                    );?>
                </div>
                <?php if ($request->get('isAjax') === 'y') die()?>
            </div>
        </div>
    <?php }?>
</main>

<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arResult */
/** @var array $arParams */
/** @global object $APPLICATION */


$dir = $APPLICATION->GetCurDir();
$dirName = str_replace('/', '', $dir); // PHP код
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$sectionHasAds = isExistActiveElements($arParams['IBLOCK_ID'], $arResult["VARIABLES"]["SECTION_ID"]);

if (!empty($arResult["VARIABLES"]["SECTION_ID"])) {
    $sectionData = getSectionData($arResult["VARIABLES"]["SECTION_ID"], $arParams['IBLOCK_ID']);
    switch (LANGUAGE_ID) {
        case 'he':
            $sectionName = $sectionData['UF_NAME_HEB'];
            break;
        case 'en':
            $sectionName = $sectionData['UF_NAME_EN'];
            break;
        default:
            $sectionName = $sectionData['NAME'];
    }
}
?>
<div class="container">
    <div class="preloader">
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>
    <?php
    global $arVipSliderFilter;
    $arVipSliderFilter = [
        ">=PROPERTY_VIP_DATE" => date('Y-m-d H:i:s')
    ];

    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "vip_slider",
        array(
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
            "ELEMENT_SORT_FIELD" => "sort",    // По какому полю сортируем элементы
            "ELEMENT_SORT_FIELD2" => "id",    // Поле для второй сортировки элементов
            "ELEMENT_SORT_ORDER" => "asc",    // Порядок сортировки элементов
            "ELEMENT_SORT_ORDER2" => "desc",    // Порядок второй сортировки элементов
            "ENLARGE_PRODUCT" => "STRICT",    // Выделять товары в списке
            "FILTER_NAME" => "arVipSliderFilter",    // Имя массива со значениями фильтра для фильтрации элементов
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
            "PAGE_ELEMENT_COUNT" => "1000000",    // Количество элементов на странице
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
            "SECTION_ID" => $arResult['VARIABLES']['SECTION_ID'],    // ID раздела
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
    ?>
    <?php if (!empty($sectionName)):?>
        <h1 class="h2 mb-4 subtitle"><?=$sectionName?></h1>
    <?php endif;?>
    <div class="row row-cols-1 row-cols-lg-2">
        <?php if ($request->get('isAjax') === 'y') $APPLICATION->RestartBuffer()?>
        <div id="target_container"  class="col col-lg-9">
            <?php if ($sectionHasAds):?>
                <div class="mb-5 row d-flex align-items-center">
                    <?php $APPLICATION->ShowViewContent('upper_nav');?>
                    <?php $APPLICATION->IncludeComponent(
                        "webco:sort.panel",
                        "",
                        array(
                            'FILTER_BUTTON' => 'Y',
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
            <?php endif;?>
            <?php
            $session = \Bitrix\Main\Application::getInstance()->getSession();
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                $session->get('view'),
                    array(
                "CATEGORY" => AUTO_ADS_TYPE_CODE,
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
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],    // Тип инфоблока
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
                "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],    // Количество элементов на странице
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
                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
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
        </div>
        <?php if ($request->get('isAjax') === 'y') die()?>
        <div class="col col-lg-3">
            <?php $APPLICATION->IncludeComponent(
                "bitrix:catalog.smart.filter",
                "right_strip",
                array(
                    "ROOT_SECTION_URL" => $arParams['SEF_FOLDER'],
                    "SHOW_SECTIONS" => 'Y',
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "DISPLAY_ELEMENT_COUNT" => "Y",
                    "SEF_MODE" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "N",
                    "SAVE_IN_SESSION" => "Y",
                    "INSTANT_RELOAD" => "Y",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "PRICE_CODE" => array(
                        0 => "BASE",
                    ),
                    "SECTION_TITLE" => "-",
                    "SECTION_DESCRIPTION" => "-",
                    "POPUP_POSITION" => "left",
                    "SEF_RULE" => "/flea/#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
                    "SECTION_CODE_PATH" => "",
                    "SMART_FILTER_PATH" => '#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/',
                    "CURRENCY_ID" => "RUB",
                ),
                false
            );?>
        </div>
    </div>
</div>

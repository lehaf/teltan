<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="container">
    <div class="preloader">
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>
    <script>
        class RangeSlider {
            constructor(elementId) {
                this.elementId = elementId;

                const element = document.getElementById(this.elementId);


                this.element = element;

                this.init();

            }

            init() {
                const { rangeMin = 0, rangeMax = 100 } = this.element.dataset;

                this.slider = noUiSlider.create(this.element, {
                    start: [Number(rangeMin), Number(rangeMax)],
                    connect: true,
                    step: 1,
                    direction: 'rtl',
                    range: {
                        min: Number(rangeMin),
                        max: Number(rangeMax),
                    },
                    format: {
                        to: (value) => Math.round(value),
                        from: (value) => Number(value) || 0,
                    },
                });

                const minInput = document.querySelector(`[data-range-min-connected="${this.elementId}"]`);
                const maxInput = document.querySelector(`[data-range-max-connected="${this.elementId}"]`);

                if (minInput && maxInput) {
                    this.slider.on('update', () => {
                        const [minValue, maxValue] = this.slider.get();
                        minInput.value = minValue;
                        maxInput.value = maxValue;
                    })

                    minInput.addEventListener('change', (e) => {
                        this.slider.set([e.target.value, null])
                    })

                    maxInput.addEventListener('change', (e) => {
                        this.slider.set([null, e.target.value])
                    })
                }

                const setters = document.querySelectorAll(`[data-range-connected="${this.elementId}"]`);

                if (setters.length) {
                    setters.forEach((node) => {
                        node.addEventListener('click', (e) => {
                            this.slider.set(e.target.dataset.rangeSet.split(','))
                        })
                    })
                }
            }
        }
    </script>
    <?$APPLICATION->IncludeComponent("bitrix:catalog.section", "templateFleaSliderList", Array(
        "ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
        "ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
        "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
        "AJAX_MODE" => "N",	// Включить режим AJAX
        "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
        "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
        "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
        "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
        "BACKGROUND_IMAGE" => "-",	// Установить фоновую картинку для шаблона из свойства
        "BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
        "BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
        "CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
        "CACHE_GROUPS" => "Y",	// Учитывать права доступа
        "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
        "CACHE_TYPE" => "A",	// Тип кеширования
        "COMPATIBLE_MODE" => "Y",	// Включить режим совместимости
        "DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
        "DISABLE_INIT_JS_IN_COMPONENT" => "N",	// Не подключать js-библиотеки в компоненте
        "DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
        "DISPLAY_COMPARE" => "N",	// Разрешить сравнение товаров
        "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
        "ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем элементы
        "ELEMENT_SORT_FIELD2" => "id",	// Поле для второй сортировки элементов
        "ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки элементов
        "ELEMENT_SORT_ORDER2" => "desc",	// Порядок второй сортировки элементов
        "ENLARGE_PRODUCT" => "STRICT",	// Выделять товары в списке
        "FILTER_NAME" => "arrFilter",	// Имя массива со значениями фильтра для фильтрации элементов
        "IBLOCK_ID" => "1",	// Инфоблок
        "IBLOCK_TYPE" => "announcements",	// Тип инфоблока
        "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
        "LAZY_LOAD" => "N",	// Показать кнопку ленивой загрузки Lazy Load
        "LINE_ELEMENT_COUNT" => "3",	// Количество элементов выводимых в одной строке таблицы
        "LOAD_ON_SCROLL" => "N",	// Подгружать товары при прокрутке до конца
        "MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
        "MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
        "MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
        "MESS_BTN_LAZY_LOAD" => "Показать ещё",	// Текст кнопки "Показать ещё"
        "MESS_BTN_SUBSCRIBE" => "Подписаться",	// Текст кнопки "Уведомить о поступлении"
        "MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
        "META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
        "META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
        "OFFERS_LIMIT" => "5",	// Максимальное количество предложений для показа (0 - все)
        "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
        "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
        "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
        "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
        "PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
        "PAGER_TITLE" => "Товары",	// Название категорий
        "PAGE_ELEMENT_COUNT" => "100000000",	// Количество элементов на странице
        "PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
        "PRICE_CODE" => "",	// Тип цены
        "PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
        "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",	// Порядок отображения блоков товара
        "PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
        "PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",	// Вариант отображения товаров
        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],	// Параметр ID продукта (для товарных рекомендаций)
        "RCM_TYPE" => "personal",	// Тип рекомендации
        "SECTION_CODE" => $_REQUEST["SECTION_CODE"],	// Код раздела
        "SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID раздела
        "SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
        "SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
        "SECTION_USER_FIELDS" => array(	// Свойства раздела
            0 => "",
            1 => "",
        ),
        "SEF_MODE" => "N",	// Включить поддержку ЧПУ
        "SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
        "SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
        "SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
        "SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
        "SET_STATUS_404" => "N",	// Устанавливать статус 404
        "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
        "SHOW_404" => "N",	// Показ специальной страницы
        "SHOW_ALL_WO_SECTION" => "N",	// Показывать все элементы, если не указан раздел
        "SHOW_FROM_SECTION" => "N",	// Показывать товары из раздела
        "SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
        "SHOW_SLIDER" => "Y",	// Показывать слайдер для товаров
        "SLIDER_INTERVAL" => "3000",	// Интервал смены слайдов, мс
        "SLIDER_PROGRESS" => "N",	// Показывать полосу прогресса
        "TEMPLATE_THEME" => "blue",	// Цветовая тема
        "USE_ENHANCED_ECOMMERCE" => "N",	// Отправлять данные электронной торговли в Google и Яндекс
        "USE_MAIN_ELEMENT_SECTION" => "N",	// Использовать основной раздел для показа элемента
        "USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
        "USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
        "COMPONENT_TEMPLATE" => ".default",
        "PROPERTY_CODE_MOBILE" => "",	// Свойства товаров, отображаемые на мобильных устройствах
        "ADD_PICT_PROP" => "-",	// Дополнительная картинка основного товара
        "LABEL_PROP" => "",	// Свойства меток товара
    ),
        false
    );?>




    <h1 class="h2 mb-4 subtitle">
        <?
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
        if ($langId) {
            $arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult["VARIABLES"]["SECTION_ID"], 'GLOBAL_ACTIVE' => 'Y');

            $db_list = CIBlockSection::GetList(array("timestamp_x" => "DESC"), $arFilter, false, array("UF_NAME_$langId"));

            if ($uf_value = $db_list->GetNext()) {
                $ar_res['NAME'] = $uf_value["UF_NAME_$langId"];
            }

        }else{
            $res = CIBlockSection::GetByID($arResult["VARIABLES"]["SECTION_ID"]);
            $ar_res = $res->GetNext();
        }


        echo $ar_res['NAME'];
        ?>
    </h1>

    <div class="row row-cols-1 row-cols-lg-2">
        <div id="target_container" class="col col-lg-9">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.smart.filter",
                "right_strip",
                array(
                    "COMPONENT_TEMPLATE" => "bootstrap_v5",
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
            $template = 'templateFleaList';
            if ($_SESSION['view'] == 'block'){
                $template = 'templateFleaBlock';
            }
            //костыль для сортировки
            $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_VIP_DATE");
            $arFilter = Array("IBLOCK_ID"=>1);
            $res = CIblockElement::GetList(Array("DATE_CREATE" => "DESC"), $arFilter, false, false, $arSelect);
            while($ob = $res->GetNextElement()){
                $arFields = $ob->GetFields();
                if($arFields['PROPERTY_VIP_DATE_VALUE'] != null && strtotime($arFields['PROPERTY_VIP_DATE_VALUE']) < time() ){
                    $el = new CIBlockElement;
                    $PROP = array();
                    $PROP['VIP_DATE'] = "";
                    $arLoadProductArray = Array(
                        "IBLOCK_SECTION" => false,
                        "PROPERTY_VALUES"=> $PROP,
                    );
                    $PRODUCT_ID = $arFields['ID'];
                   // $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
                    CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_FLAG", 0);
                    CIBlockElement::SetPropertyValues($PRODUCT_ID, $arParams["IBLOCK_ID"], '', 'VIP_DATE');
                }
            }

            $APPLICATION->IncludeComponent("bitrix:catalog.section", $template, Array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                "PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
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
                "FILTER_NAME" => $arParams["FILTER_NAME"],
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
                "SEF_URL_TEMPLATES" => $arParams["SEF_URL_TEMPLATES"],
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
                'ADD_TO_BASKET_ACTION' => $basketAction,
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
        <?php
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $needle   = 'PAGEN';
        $pos      = strripos($url, $needle);

        if ($pos === false) {?>
            <div class="flex-column">
                <p class="h1 mb-4 subtitle">
                    <?=$ar_res['NAME']?>
                </p>

                <p class="text-right">
                    <?=$ar_res['DESCRIPTION']?>
                </p>
            </div>
        <? } else {?>

        <?  }
        ?>

    </div>

    <div class="col col-lg-3">
        <div class="p-3 pt-4 pb-4 card text-right filter-select filter" id="filterModalContent">
            <div class="pb-3 mb-2 mb-lg-4 d-flex d-lg-none justify-content-between border-bottom filter-header">
                <a class="filter-closer filterTogglerMobile" type="button"><i class="mr-1 mr-lg-3 icon-clear"></i> Close</a>
                <p class="m-0 d-inline-block text-uppercase font-weight-bolder filter-title">Filters</p>
            </div>

            <div class="border-bottom mb-lg-4">
                <p class="filter-select__collapse-title h5 d-block d-lg-none text-uppercase" data-toggle="collapse" href="#collapseDepartment" role="button" aria-expanded="true" aria-controls="collapseDepartment">
                    <span class="d-flex justify-content-between align-items-center"><i class="icone-filter-title icon-arrow-down-sign-to-navigate-3"></i></span>
                </p>
                <p class="filter-select__collapse-title h5 d-none d-lg-block text-uppercase"></p>

            </div>
            <?=$APPLICATION->ShowViewContent("smart_filter_HTML");?>

        </div>
    </div>
</div>
</div>
<script>


    new RangeSlider('rangeSlider');
    new RangeSlider('rangeSliderMainFilterMobile');
</script>
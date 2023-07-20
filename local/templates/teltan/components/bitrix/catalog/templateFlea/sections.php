<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$dir = $APPLICATION->GetCurDir();
$dirName = str_replace('/', '', $dir); // PHP код
?>
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
                    start: [Number(rangeMin), localStorage.getItem('FilterMax') ?? Number(rangeMax)],
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
                        localStorage.setItem('FilterMax', maxValue);
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

        $(document).ready(function() {
            const maxInput = document.querySelector("#arrFilter_15_MAX");

            function setDataRange(){
                let FilterMax = $("#arrFilter_15_MAX").val();
                localStorage.setItem('FilterMax', FilterMax);
            }

            maxInput.addEventListener('input', (e) => {

                setDataRange();
            })
            localStorage.getItem('FilterMax')

        });
    </script>
    <? $APPLICATION->IncludeComponent("bitrix:catalog.section", "templateFleaSliderList", array(
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
    );
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
          //  $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "VIP_FLAG", 0);
            CIBlockElement::SetPropertyValues($PRODUCT_ID, $arParams["IBLOCK_ID"], '', 'VIP_DATE');

        }
    }

    ?>


    <h1 class="h2 mb-4 subtitle">
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => "/include-area/".mb_strtolower($dirName)."-h1-ru.php",
                "EDIT_TEMPLATE" => ""
            )
        );
        // символы для удаления


        ?>
    </h1>

    <div class="row row-cols-1 row-cols-lg-2">
        <div id="target_container" class="col col-lg-9">


            <?

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.smart.filter",
                "bootstrap_v4",
                array(
                    "COMPONENT_TEMPLATE" => "bootstrap_v4",
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "Y",
                    "TEMPLATE_THEME" => "blue",
                    "FILTER_VIEW_MODE" => "horizontal",
                    "DISPLAY_ELEMENT_COUNT" => "Y",
                    "AJAX_MODE" => "Y",
                    "INSTANT_RELOAD" => "Y",
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
                $component,
                array('HIDE_ICONS' => 'Y')
            );
            $template = 'templateFleaList';
            if ($_SESSION['view'] == 'block') {
                $template = 'templateFleaBlock';
            }
            $APPLICATION->IncludeComponent("bitrix:catalog.section", $template,
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
                "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                "ENLARGE_PRODUCT" => "STRICT",    // Выделять товары в списке
                "FILTER_NAME" => "arrFilter",    // Имя массива со значениями фильтра для фильтрации элементов
                "IBLOCK_ID" => "1",    // Инфоблок
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
                "SECTION_CODE" => $_REQUEST["SECTION_CODE"],    // Код раздела
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
                $component
            ); ?>


        </div>
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
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include-area/".mb_strtolower($dirName)."-h1-sub-ru.php",
                        "EDIT_TEMPLATE" => ""
                    )
                );?>
                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include-area/".mb_strtolower($dirName)."-text-ru.php",
                        "EDIT_TEMPLATE" => ""
                    )
                );?>
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
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */

$APPLICATION->SetTitle("חיפוש");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$searchRes = $APPLICATION->IncludeComponent(
	"bitrix:search.page", 
	"search",
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COLOR_NEW" => "000000",
		"COLOR_OLD" => "C8C8C8",
		"COLOR_TYPE" => "Y",
		"DEFAULT_SORT" => "rank",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"FILTER_NAME" => "",
		"FONT_MAX" => "50",
		"FONT_MIN" => "10",
		"NO_WORD_LOGIC" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGE_RESULT_COUNT" => "30",
		"PATH_TO_USER_PROFILE" => "#SITE_DIR#people/user/#USER_ID#/",
		"PERIOD_NEW_TAGS" => "",
		"RATING_TYPE" => "",
		"RESTART" => "Y",
		"SHOW_CHAIN" => "Y",
		"SHOW_ITEM_DATE_CHANGE" => "Y",
		"SHOW_ITEM_TAGS" => "Y",
		"SHOW_ORDER_BY" => "Y",
		"SHOW_RATING" => "Y",
		"SHOW_TAGS_CLOUD" => "N",
		"SHOW_WHEN" => "N",
		"SHOW_WHERE" => "N",
		"TAGS_INHERIT" => "Y",
		"TAGS_PAGE_ELEMENTS" => "20",
		"TAGS_PERIOD" => "",
		"TAGS_SORT" => "NAME",
		"TAGS_URL_SEARCH" => "",
		"USE_LANGUAGE_GUESS" => "N",
		"USE_SUGGEST" => "Y",
		"USE_TITLE_RANK" => "Y",
		"WIDTH" => "100%",
		"arrFILTER" => array(
			0 => "iblock_announcements",
		),
		"arrFILTER_iblock_announcements" => array(
			0 => "all",
		),
		"arrWHERE" => array(
			0 => "iblock_announcements",
		),
		"COMPONENT_TEMPLATE" => "search"
	),
	false
);
?>
<div class="preloader">
    <div class="preloader__row">
        <div class="preloader__item"></div>
        <div class="preloader__item"></div>
    </div>
</div>
<div class="container">
	<h1 class="h2 mb-4 subtitle">
		<?=$APPLICATION->ShowTitle();?>
	</h1>
    <?php if ($request->get('isAjax') === 'y') $APPLICATION->RestartBuffer()?>
    <div id="target_container">
    <?php if (!empty($searchRes)):?>
        <div class="mb-5 row d-flex align-items-center">
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
    <?php endif;

    $session = \Bitrix\Main\Application::getInstance()->getSession();
    $APPLICATION->IncludeComponent(
        "webco:search.ads.list",
        $session->get('view'),
        array(
            "ITEMS" => $searchRes,
            "CACHE_TIME" => 3600,
        ),
        false
    ); ?>
    </div>
    <?php if ($request->get('isAjax') === 'y') die()?>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
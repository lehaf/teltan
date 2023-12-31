<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Localization\Loc;

/** @global object $APPLICATION */

$APPLICATION->SetTitle("Teltan - main");
?>
<div class="container-fluid mb-4 mb-lg-5">
    <div class="container">
        <?php $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "slider",
            Array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "N",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "N",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("", ""),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => SLIDER_IBLOCK_ID,
                "IBLOCK_TYPE" => "content",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "20",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("URL_BUTTON", "TEXT_BUTTON", ""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "ID",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "DESC",
                "STRICT_SECTION_CHECK" => "N"
            )
        );

        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "flea",
            Array(
                "ADD_SECTIONS_CHAIN" => "N",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "N",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COUNT_ELEMENTS" => "Y",
                "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                "FILTER_NAME" => "sectionsFilter",
                "IBLOCK_ID" => SIMPLE_ADS_IBLOCK_ID,
                "IBLOCK_TYPE" => "announcements",
                "SECTION_CODE" => "",
                "SECTION_FIELDS" => array("", ""),
                "SECTION_ID" => $_REQUEST["SECTION_ID"],
                "SECTION_URL" => "",
                "SECTION_USER_FIELDS" => array("UF_NAME_EN",'UF_URL', "UF_NAME_HEB", "UF_FON", 'UF_NAME_ID_FOR_HTML'),
                "SHOW_PARENT_NAME" => "Y",
                "TOP_DEPTH" => "2",
                "VIEW_MODE" => "LINE"
            )
        );?>

    </div>
</div>
<div class="container">
    <div class="d-flex flex-column">
        <?php
        // PROPERTY MARKET
        global $arrFilterProp;
        $arrFilterProp = array(
            array(
                "LOGIC" => "OR",
                "PROPERTY_VIP_DATE" => false,
                "<PROPERTY_VIP_DATE" => date('Y-m-d H:i:s')
            )
        );

        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "main",
            Array(
                "BLOCK_TITLE" => Loc::getMessage("PROPERTY"),
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "N",
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "N",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("SHOW_COUNTER", "DATE_CREATE"),
                "FILTER_NAME" => "arrFilterProp",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => PROPERTY_ADS_IBLOCK_ID,
                "IBLOCK_TYPE" => "announcements",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "4",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("VIP_DATE", "LENTA_DATE", "COLOR_DATE", "PAKET_DATE", "PRICE", ""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "PROPERTY_TIME_RAISE",
                "SORT_BY2" => "ID",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "DESC",
                "STRICT_SECTION_CHECK" => "N",
                "CATEGORY" => PROPERTY_ADS_TYPE_CODE
            )
        );

        // AUTO MARKET
        global $arrFilterAuto;
        $arrFilterAuto = array(
            array(
                "LOGIC" => "OR",
                "PROPERTY_VIP_DATE" => false,
                "<PROPERTY_VIP_DATE" => date('Y-m-d H:i:s')
            )
        );

        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "main",
            Array(
                "BLOCK_TITLE" => Loc::getMessage("AUTO"),
                "ADD_SECTIONS_CHAIN" => "N",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "N",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "FIELD_CODE" => array(
                    "SHOW_COUNTER",
                    "DATE_CREATE"
                ),
                "FILTER_NAME" => "arrFilterAuto",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => AUTO_IBLOCK_ID,
                "IBLOCK_TYPE" => "announcements",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "N",
                "NEWS_COUNT" => "4",
                "PROPERTY_CODE" => array(
                    "VIP_DATE",
                    "LENTA_DATE",
                    "COLOR_DATE",
                    "PAKET_DATE",
                    "PRICE"
                ),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "PROPERTY_TIME_RAISE",
                "SORT_BY2" => "ID",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "DESC",
                "STRICT_SECTION_CHECK" => "N",
                "CATEGORY" => AUTO_ADS_TYPE_CODE
            )
        );

        // MOTO
        global $arrFilterMoto;
        $arrFilterMoto = array(
            array(
                "LOGIC" => "OR",
                "PROPERTY_VIP_DATE" => false,
                "<PROPERTY_VIP_DATE" => date('Y-m-d H:i:s')
            )
        );

        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "main",
            Array(
                "BLOCK_TITLE" => Loc::getMessage("MOTO"),
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "N",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("SHOW_COUNTER", "DATE_CREATE"),
                "FILTER_NAME" => "arrFilterMoto",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => MOTO_IBLOCK_ID,
                "IBLOCK_TYPE" => "announcements",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "4",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("VIP_DATE", "LENTA_DATE", "COLOR_DATE", "PAKET_DATE", "PRICE", ""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "PROPERTY_TIME_RAISE",
                "SORT_BY2" => "ID",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "DESC",
                "STRICT_SECTION_CHECK" => "N",
                "CATEGORY" => AUTO_ADS_TYPE_CODE
            )
        );

        // SCOOTER
        global $arrFilterScooter;
        $arrFilterScooter = array(
            array(
                "LOGIC" => "OR",
                "PROPERTY_VIP_DATE" => false,
                "<PROPERTY_VIP_DATE" => date('Y-m-d H:i:s')
            )
        );

        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "main",
            Array(
                "BLOCK_TITLE" => Loc::getMessage("SCOOTER"),
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "N",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("SHOW_COUNTER", "DATE_CREATE"),
                "FILTER_NAME" => "arrFilterScooter",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => SCOOTER_IBLOCK_ID,
                "IBLOCK_TYPE" => "announcements",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "4",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("VIP_DATE", "LENTA_DATE", "COLOR_DATE", "PAKET_DATE", "PRICE", ""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "PROPERTY_TIME_RAISE",
                "SORT_BY2" => "ID",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "DESC",
                "STRICT_SECTION_CHECK" => "N",
                "CATEGORY" => AUTO_ADS_TYPE_CODE
            )
        );

        // FLEA-MARKET
        global $arrFilterAD;
        $arrFilterAD = array(
            array(
                "LOGIC" => "OR",
                "PROPERTY_VIP_DATE" => false,
                "<PROPERTY_VIP_DATE" => date('Y-m-d H:i:s')
            )
        );

        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "main",
            Array(
                "BLOCK_TITLE" => Loc::getMessage("FLEA_MARKET"),
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "N",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("SHOW_COUNTER", "DATE_CREATE"),
                "FILTER_NAME" => "arrFilterAD",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => SIMPLE_ADS_IBLOCK_ID,
                "IBLOCK_TYPE" => "announcements",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "4",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("VIP_DATE", "LENTA_DATE", "COLOR_DATE", "PAKET_DATE", "PRICE", ""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "PROPERTY_TIME_RAISE",
                "SORT_BY2" => "ID",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "DESC",
                "STRICT_SECTION_CHECK" => "N",
                "IMG_VIEW" => 'CONTAINER'
            )
        );?>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
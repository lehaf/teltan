<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
    "webco:add_property",
    "rent",
    Array(

    )
);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
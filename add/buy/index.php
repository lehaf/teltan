<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString('<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>');
Asset::getInstance()->addString('<script src="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js"></script>');
Asset::getInstance()->addCss('https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css');

$APPLICATION->IncludeComponent(
    "webco:add_property",
    "buy",
    Array(
    )
);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
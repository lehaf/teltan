<?php

if (!empty($arResult['ITEMS'])) {
    $dateTime = new \Bitrix\Main\Type\DateTime();
    // Получаем типы лент-лейблов для vip объявлений
    $ribbonTypes = getHLData(PERSONAL_RIBBON_HL_ID);
    if (!empty($ribbonTypes)) {
        $ribbonTypes = [];
        foreach ($ribbonTypes as $lenta) {
            $ribbonTypes[$lenta['UF_XML_ID']] = $lenta;
        }
    }

    foreach ($arResult['ITEMS'] as &$item) {
        if (!empty($item['PROPERTIES']['PRICE']['VALUE'])) {
            $item['PROPERTIES']['PRICE']['VALUE'] = ICON_CURRENCY.' '.number_format($item['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');
        }

        if (!empty($item['PROPERTIES']['LENTA_DATE']['VALUE']) && strtotime($item['PROPERTIES']['LENTA_DATE']['VALUE']) > time() &&
            !empty($item['PROPERTIES']['TYPE_TAPE']['VALUE']) && !empty($ribbonTypes)) {
            $lentaXmlId = $item['PROPERTIES']['TYPE_TAPE']['VALUE'];

            $item['PROPERTIES']['TYPE_TAPE']['VALUE'] = [
                'NAME' => $ribbonTypes[$lentaXmlId]['UF_NAME'],
                'COLOR' => $ribbonTypes[$lentaXmlId]['UF_COLOR']
            ];
        }

        if (!empty($item['PROPERTIES']['COLOR_DATE']['VALUE']) && strtotime($item['PROPERTIES']['COLOR_DATE']['VALUE']) > time()) {
            $item['VIP_COLOR'] = PROPERTY_VIP_COLOR;
        }

    }
    unset($item);
}
<?php

if (!empty($arResult['ITEMS'])) {
    $dateTime = new \Bitrix\Main\Type\DateTime();
    // Получаем типы лент-лейблов для vip объявлений
    $lentaTypes = getHLData(LENTA_TYPES_HL_ID);
    if (!empty($lentaTypes)) {
        $editedLentaTypes = [];
        foreach ($lentaTypes as $lenta) {
            $editedLentaTypes[$lenta['UF_XML_ID']] = $lenta;
        }
        $lentaTypes = $editedLentaTypes;
    }

    foreach ($arResult['ITEMS'] as &$item) {
        if (!empty($item['PROPERTIES']['PRICE']['VALUE'])) {
            $item['PROPERTIES']['PRICE']['VALUE'] = ICON_CURRENCY.' '.number_format($item['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');
        }

        if (!empty($item['PROPERTIES']['LENTA_DATE']['VALUE']) && strtotime($item['PROPERTIES']['LENTA_DATE']['VALUE']) > time() &&
            !empty($item['PROPERTIES']['TYPE_TAPE']['VALUE']) && !empty($lentaTypes)) {
            $lentaXmlId = $item['PROPERTIES']['TYPE_TAPE']['VALUE'];

            $item['PROPERTIES']['TYPE_TAPE']['VALUE'] = [
                'NAME' => $lentaTypes[$lentaXmlId]['UF_NAME_RU'],
                'COLOR' => $lentaTypes[$lentaXmlId]['UF_COLOR']
            ];
        }

        if (!empty($item['PROPERTIES']['COLOR_DATE']['VALUE']) && strtotime($item['PROPERTIES']['COLOR_DATE']['VALUE']) > time()) {
            $item['VIP_COLOR'] = PROPERTY_VIP_COLOR;
        }

        $arResult['VIP_ITEMS_ID'][] = $item['ID'];
    }
    unset($item);

    $this->__component->setResultCacheKeys(['VIP_ITEMS_ID']);
}
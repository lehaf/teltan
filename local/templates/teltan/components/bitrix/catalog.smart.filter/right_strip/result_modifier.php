<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as $key => $item) {
        if (empty($item['VALUES']) ||
            ($item['PROPERTY_TYPE'] === 'N' && empty($item['VALUES']['MIN']['VALUE']) && empty($item['VALUES']['MAX']['VALUE'])) ||
            ($item['PROPERTY_TYPE'] === 'N' && $item['VALUES']['MIN']['VALUE'] === $item['VALUES']['MAX']['VALUE'])
        ) {
            unset($arResult['ITEMS'][$key]);
            continue;
        }

        if ($item['DISPLAY_TYPE'] === 'P') {
            foreach ($item['VALUES'] as $val) {
                if (isset($val['CHECKED'])) {
                    $arResult['ITEMS'][$key]['CHECKED_VALUE'] = $val['VALUE'];
                }
            }
        }
    }
}

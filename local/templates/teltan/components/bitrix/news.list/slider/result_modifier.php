<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!empty($arResult["ITEMS"])) {
    foreach ($arResult["ITEMS"] as &$item) {
        // Генерируем webp картинку и ресайзим картинки если их нет - тавим заглушку
        if (\Bitrix\Main\Loader::includeModule("webp.img")) {
            if (!empty($item['PREVIEW_PICTURE']['ID'])) {
                $item['PREVIEW_PICTURE']['SRC'] = \WebCompany\WebpImg::getResizeWebpSrc(
                    $item['PREVIEW_PICTURE']['ID'],
                    1000,
                    500,
                    true,
                    90
                );
            }
        }
    }
    unset($item);
}

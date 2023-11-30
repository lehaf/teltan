<?php

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as $k => $arItem){
        if($arItem['PREVIEW_PICTURE']['ID']) {
            $arResult['ITEMS'][$k]['PREVIEW_450_377'] = resizeImg($arItem['PREVIEW_PICTURE']['ID'], 450, 377);
        } else {
            $arResult['ITEMS'][$k]['PREVIEW_450_377'] = SITE_TEMPLATE_PATH.'/assets/no-image.svg';
        }

        if($arItem['PROPERTIES']['TYPE_TAPE']['VALUE'])
            $arResult['ITEMS'][$k]['TAPE'] =
                getHighloadInfo(
                PERSONAL_RIBBON_HL_ID,
                array(
                    'select' => array('*'),
                    'filter' => array('UF_XML_ID' => $arItem['PROPERTIES']['TYPE_TAPE']['VALUE'])
                )
            )[0];
    }
}


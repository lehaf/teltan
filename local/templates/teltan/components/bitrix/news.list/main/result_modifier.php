<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */

if (!empty($arResult['ITEMS'])) {
    $sectionsId = [];
    foreach ($arResult['ITEMS'] as $k => &$item) {
        $sectionsId[] = $item['IBLOCK_SECTION_ID'];
        // Ресайз картинок
        if (!empty($item['PREVIEW_PICTURE']['ID'])) {
            $item['PREVIEW_PICTURE'] = \CFile::ResizeImageGet(
                $item['PREVIEW_PICTURE']['ID'],
                array(
                    'width' => 450,
                    'height' => 377
                ),
                BX_RESIZE_IMAGE_PROPORTIONAL
            );
        } else {
            $item['PREVIEW_PICTURE']['src'] = SITE_TEMPLATE_PATH . '/assets/no-image.svg';
        }

        // Получаем ленту продвижения
        if (!empty($item['PROPERTIES']['TYPE_TAPE']['VALUE']))
            $item['TAPE'] =
                getHighloadInfo(
                    PERSONAL_RIBBON_HL_ID,
                    array(
                        'select' => array('*'),
                        'filter' => array('UF_XML_ID' => $item['PROPERTIES']['TYPE_TAPE']['VALUE'])
                    )
                )[0];

        // Местоположение
        if ($arParams['CATEGORY'] === PROPERTY_ADS_TYPE_CODE && (!empty($item['PROPERTIES']['MAP_LAYOUT']['VALUE']) || !empty($item['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE']))){
            if (!empty($item['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE'])) $region = $item['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE'];
            if (!empty($item['PROPERTIES']['MAP_LAYOUT']['VALUE'])) $city = $item['PROPERTIES']['MAP_LAYOUT']['VALUE'];
            $item['LOCATION'] = isset($city) ? $city . ', ' . $region : $region;
        } else {
            if (!empty($item['PROPERTIES']['LOCATION']['VALUE'])) $item['LOCATION'] = $item['PROPERTIES']['LOCATION']['VALUE'];
        }
    }
    unset($item);

    // Получаем разделы элементов
    if ($arParams['CATEGORY'] !== AUTO_ADS_TYPE_CODE) {
        $sections = \Bitrix\Iblock\SectionTable::getList(array(
            "select" => array("ID",  'NAME', 'CODE', 'SECTION_PAGE_RAW' =>'IBLOCK.SECTION_PAGE_URL'),
            "filter" => array(
                "ID" => $sectionsId,
                "IBLOCK_ID" => $arParams['IBLOCK_ID']
            )
        ))->fetchAll();

        if (!empty($sections)) {
            $itemSections = [];
            foreach ($sections as $sect) {
                $sect['SECTION_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($sect['SECTION_PAGE_RAW'], $sect, true, 'S');
                $itemSections[$sect['ID']] = $sect;
            }

            foreach ($arResult['ITEMS'] as &$item){
                if (!empty($itemSections[$item['IBLOCK_SECTION_ID']])) $item['SECTION'] = $itemSections[$item['IBLOCK_SECTION_ID']];
            }
            unset($item);
        }
    }
}


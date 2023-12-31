<?php

/** @var array $arResult */
/** @var array $arParams */

if (!empty($arResult['ITEMS'])) {
    $sectionsId = [];
    foreach ($arResult['ITEMS'] as $k => &$item) {
        $sectionsId[] = $item['IBLOCK_SECTION_ID'];
    }
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
        }
    }

    // Получаем все типы лент продвижения
    $ribbonsClass = GetEntityDataClass(PERSONAL_RIBBON_HL_ID);
    $ribbons = $ribbonsClass::getList(array(
        'select' => array('*'),
    ))->fetchAll();
    if (!empty($ribbons)) {
        $newTree = [];
        foreach ($ribbons as $ribbon) {
            $newTree[$ribbon['UF_XML_ID']] = $ribbon;
        }
        $ribbons = $newTree;
    }

    foreach ($arResult['ITEMS'] as &$item) {
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

        if (!empty($itemSections[$item['IBLOCK_SECTION_ID']])) $item['SECTION'] = $itemSections[$item['IBLOCK_SECTION_ID']];


        if (!empty($item['PROPERTIES']['TYPE_TAPE']['VALUE']) && !empty($item['PROPERTIES']['LENTA_DATE']['VALUE'])
            && strtotime($item['PROPERTIES']['LENTA_DATE']['VALUE']) > time() && !empty($ribbons[$item['PROPERTIES']['TYPE_TAPE']['VALUE']])) {
            $item['RIBBON'] = $ribbons[$item['PROPERTIES']['TYPE_TAPE']['VALUE']];
        }
    }
    unset($item);
}
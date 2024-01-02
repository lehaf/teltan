<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */

// VIP ITEMS
if (!empty($arParams['IBLOCK_ID'])) {
    // Получаем все возможные ленты продвижения
    $ribTypes = getHighloadInfo(
        PERSONAL_RIBBON_HL_ID,
        array(
            'select' => array('*'),
            'cache' => [
                'ttl' => 3600000,
                'cache_joins' => true
            ]
        )
    );
    if (!empty($ribTypes)) {
        $ribbonTypes = [];
        foreach ($ribTypes as $ribbon) {
            $ribbonTypes[$ribbon['UF_XML_ID']] = $ribbon;
        }
    }

    // Получаем VIP элементы
    $itemsIblockCLass = \Bitrix\Iblock\Iblock::wakeUp($arParams['IBLOCK_ID'])->getEntityDataClass();
    $select = [
        'ID',
        'CODE',
        'IBLOCK_SECTION_ID',
        'NAME',
        'DATE_CREATE',
        'PREVIEW_PICTURE',
        'SHOW_COUNTER',
        'TYPE_TAPE',
        'LENTA_DATE',
        'PRICE',
        'IBLOCK',
        'IBLOCK_SECTION',
    ];

    // Выборка местоположений элементов
    if ($arParams['CATEGORY'] === PROPERTY_ADS_TYPE_CODE){
        $select[] = 'MAP_LAYOUT';
        $select[] = 'MAP_LAYOUT_BIG';
    } else {
        $select[] = 'LOCATION';
    }

    $vipItems = $itemsIblockCLass::getList([
        'order' => [
            "TIME_RAISE.VALUE" => 'DESC',
            "VIP_DATE.VALUE" => 'DESC',
        ],
        'select' => $select,
        'filter' => [ ">=VIP_DATE.VALUE" => date('Y-m-d H:i:s')],
        'limit' => 2,
    ])->fetchCollection();


    foreach ($vipItems as $key => $vipItem) {
        $itemUrlPatternParams = [
            'ID' => $vipItem->getId(),
            'CODE' => $vipItem->getCode(),
            'IBLOCK_SECTION_ID' => $vipItem->getIblockSectionId(),
        ];

        $arResult['VIPS'][$key] = [
            'ID' => $vipItem->getId(),
            'IBLOCK_SECTION_ID' => $vipItem->getIblockSectionId(),
            'NAME' => $vipItem->getName(),
            'DATE_CREATE' => $vipItem->getDateCreate(),
            'SHOW_COUNTER' => $vipItem->getShowCounter(),
            'DETAIL_PAGE_URL' => \CIBlock::ReplaceDetailUrl($vipItem->getIblock()->getDetailPageUrl(), $itemUrlPatternParams, true, 'E'),
            'PROPERTIES' => [
                'PRICE' => ['VALUE' => !empty($vipItem->getPrice()) ? $vipItem->getPrice()->getValue() : ''],
                'LENTA_DATE' => ['VALUE' => !empty($vipItem->getLentaDate()) ? $vipItem->getLentaDate()->getValue() : ''],
            ],
            'TAPE' => !empty($ribbonTypes) && !empty($vipItem->getTypeTape()) ?  $ribbonTypes[$vipItem->getTypeTape()->getValue()] : ''
        ];

        // Ресайз картинок
        if (!empty($vipItem->getPreviewPicture())) {
            $arResult['VIPS'][$key]['PREVIEW_PICTURE'] = \CFile::ResizeImageGet(
                $vipItem->getPreviewPicture(),
                array(
                    'width' => 450,
                    'height' => 377
                ),
                BX_RESIZE_IMAGE_PROPORTIONAL
            );
        } else {
            $arResult['VIPS'][$key]['PREVIEW_PICTURE']['src'] = SITE_TEMPLATE_PATH . '/assets/no-image.svg';
        }

        // Получаем разделы элементов
        if ($arParams['CATEGORY'] !== AUTO_ADS_TYPE_CODE) {
            $sectionUrlPatternParams = [
                'ID' => $vipItem->getIblockSection()->getId(),
                'CODE' => $vipItem->getIblockSection()->getCode(),
            ];

            $arResult['VIPS'][$key]['SECTION'] = [
                'NAME' => $vipItem->getIblockSection()->getName(),
                'SECTION_PAGE_URL' => \CIBlock::ReplaceDetailUrl($vipItem->getIblock()->getSectionPageUrl(), $sectionUrlPatternParams, true, 'S')
            ];
        }

        // Местоположение
        if ($arParams['CATEGORY'] === PROPERTY_ADS_TYPE_CODE && ((!empty($vipItem->getMapLayout()) && !empty($vipItem->getMapLayout()->getValue()))
            || (!empty($vipItem->getMapLayoutBig()) && !empty($vipItem->getMapLayoutBig()->getValue())))){
            if (!empty($vipItem->getMapLayoutBig()) && !empty($vipItem->getMapLayoutBig()->getValue())) $region = $vipItem->getMapLayoutBig()->getValue();
            if (!empty($vipItem->getMapLayout()) && !empty($vipItem->getMapLayout()->getValue())) $city = $vipItem->getMapLayout()->getValue();
            $arResult['VIPS'][$key]['LOCATION'] = isset($city) ? $city . ', ' . $region : $region;
        } else {
            if (!empty($vipItem->getLocation()) && !empty($vipItem->getLocation()->getValue()))
                $arResult['VIPS'][$key]['LOCATION'] = $vipItem->getLocation()->getValue();
        }

        // Эрмитаж
        $arButtons = CIBlock::GetPanelButtons(
            $arParams["IBLOCK_ID"],
            $vipItem->getId(),
            0,
            array("SECTION_BUTTONS"=>false, "SESSID"=>false)
        );

        $arResult['VIPS'][$key]["ADD_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
        $arResult['VIPS'][$key]["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
        $arResult['VIPS'][$key]["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

        $arResult['VIPS'][$key]["ADD_LINK_TEXT"] = $arButtons["edit"]["add_element"]["TEXT"];
        $arResult['VIPS'][$key]["EDIT_LINK_TEXT"] = $arButtons["edit"]["edit_element"]["TEXT"];
        $arResult['VIPS'][$key]["DELETE_LINK_TEXT"] = $arButtons["edit"]["delete_element"]["TEXT"];
    }
}

// SIMPLE ITEMS
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
            $item['TAPE'] = !empty($ribbonTypes) ? $ribbonTypes[$item['PROPERTIES']['TYPE_TAPE']['VALUE']] : '';

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


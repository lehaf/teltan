<?php

/** @var array $arParams */
/** @var array $arResult */

$iblock = \Bitrix\Iblock\Iblock::wakeUp(PROPERTY_ADS_IBLOCK_ID);
$propertyClass = $iblock->getEntityDataClass();
$ads = $propertyClass::getList(array(
    'select' => [
        'ID',
        'CODE',
        'IBLOCK',
        'IBLOCK_SECTION_ID',
        'NAME',
        'MAP_LATLNG',
        'PRICE',
        'SHOW_COUNTER',
        'DATE_CREATE',
        'VIP_DATE',
        'PREVIEW_PICTURE'
    ],
    'filter' => [
        'IBLOCK_SECTION_ID' => $arParams['SECTION_ID'],
        'ACTIVE' => 'Y'
    ]
))->fetchCollection();

foreach ($ads as $addProperty) {
    $mapLatlnt = !empty($addProperty->getMapLatlng()) ? json_decode($addProperty->getMapLatlng()->getValue(), true) : [];
    $price = !empty($addProperty->getPrice()) ? '₪ '.$addProperty->getPrice()->getValue() : '';
    $previewImg = CFile::GetPath($addProperty->getPreviewPicture());
    $detailPageRaw = $addProperty->getIblock()->getDetailPageUrl();
    $detailPageUrl = CIBlock::ReplaceDetailUrl(
        $detailPageRaw,
        [
            'ID' => $addProperty->getId(),
            'CODE' => $addProperty->getCode(),
            'IBLOCK_SECTION_ID' => $addProperty->getIblockSectionId(),
        ],
        false,
        'E'
    );


    if ($addProperty->getVipDate() && strtotime($addProperty->getVipDate()->getValue()) > time()) {
        $arResult['VIP_MARKS']['features'][] = [
            'type' => 'Feature',
            'properties' => [
                'href' => $detailPageUrl,
                'image' => $previewImg ?? '/no-image.svg',
                'title' => $addProperty->getName(),
                'price' => $price,
                'addres' => $addProperty->getName(),
                'category' => $arParams['SECTION_NAME'],
                'views' => $addProperty->getShowCounter(),
                'date' => $addProperty->getDateCreate(),
                'isVipCard' => true,
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' =>
                    [
                        !empty($mapLatlnt['lng']) ? $mapLatlnt['lng'] : $mapLatlnt[0],
                        !empty($mapLatlnt['lat']) ? $mapLatlnt['lat'] : $mapLatlnt[1]
                    ]
            ]
        ];
    } else {
        $arResult['MARKS']['features'][] = [
            'type' => 'Feature',
            'properties' => [
                'href' => $detailPageUrl,
                'image' => $previewImg ?? '/no-image.svg',
                'title' => $addProperty->getName(),
                'price' => $price,
                'addres' => $addProperty->getName(),
                'category' => $arParams['SECTION_NAME'],
                'views' => $addProperty->getShowCounter(),
                'date' => $addProperty->getDateCreate(),
                'isVipCard' => false,
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' =>
                    [
                        !empty($mapLatlnt['lng']) ? $mapLatlnt['lng'] : $mapLatlnt[0],
                        !empty($mapLatlnt['lat']) ? $mapLatlnt['lat'] : $mapLatlnt[1]
                    ]
            ]
        ];
    }
}

$elements = $propertyClass::getList(array( // $ELEMENT_ID - id елемента
    'select' => array('ID', 'NAME', 'SHOW_COUNTER'),
    'filter' => array('ID' => $arResult['ELEMENTS']),
))->fetchAll();
if (!empty($elements)) {
    foreach ($elements as $element) {
        $arResult['ITEMS_SHOW_COUNTER'][$element['ID']] = $element['SHOW_COUNTER'];
    }
}

$typesLent = getHLData(LENTA_TYPES_HL_ID, ['*']);
if (!empty($typesLent)) {
    $newTypesLent = [];
    foreach ($typesLent as $lent) {
        $newTypesLent[$lent['UF_XML_ID']] = $lent;
    }
    $typesLent = $newTypesLent;
}


if (!empty($arResult['ITEMS'])) {
    $newItems = [];
    foreach ($arResult['ITEMS'] as &$item) {
        if (!empty($item['PROPERTIES']['TYPE_TAPE']['VALUE']) && !empty($item['PROPERTIES']['LENTA_DATE']['VALUE']) &&
            strtotime($item['PROPERTIES']['LENTA_DATE']['VALUE']) > time())
            $item['PROPERTIES']['TYPE_TAPE']['VALUE'] = $typesLent[$item['PROPERTIES']['TYPE_TAPE']['VALUE']];

        if (!empty($item['PROPERTIES']['VIP_DATE']['VALUE']) && strtotime($item['PROPERTIES']['VIP_DATE']['VALUE']) > time()) {
            $newItems['VIP_ITEMS'][] = $item;
        } else {
            $newItems['SIMPLE_ITEMS'][] = $item;
        }
    }
    unset($item);

    $arResult['ITEMS'] = $newItems;
}

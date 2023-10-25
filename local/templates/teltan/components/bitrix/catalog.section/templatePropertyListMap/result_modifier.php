<?php

/** @var array $arParams */
/** @var array $arResult */

$select = [
    'ID',
    'CODE',
    'IBLOCK_SECTION_ID',
    'NAME',
    'PROPERTY_MAP_LATLNG',
    'PROPERTY_PRICE',
    'DETAIL_PAGE_URL',
    'SHOW_COUNTER',
    'DATE_CREATE',
    'PROPERTY_VIP_DATE',
    'PREVIEW_PICTURE'
];
$filter = [
    "IBLOCK_ID" => PROPERTY_ADS_IBLOCK_ID,
    'IBLOCK_SECTION_ID' => $arParams['SECTION_ID'],
    'ACTIVE' => 'Y',
];
global $arrFilter;
if (!empty($arrFilter)) $filter = array_merge($filter,$arrFilter);
$res = CIBlockElement::GetList([], $filter, $select);
$ads = [];
while($markData = $res->GetNext()) if (!empty($markData)) $ads[] = $markData;

foreach ($ads as $addProperty) {
    $mapLatlnt = !empty($addProperty['~PROPERTY_MAP_LATLNG_VALUE']) ? json_decode($addProperty['~PROPERTY_MAP_LATLNG_VALUE'], true) : [];
    $price = !empty($addProperty['PROPERTY_PRICE_VALUE']) ? '₪ '.$addProperty['PROPERTY_PRICE_VALUE'] : '';
    $previewImg = !empty($addProperty['PREVIEW_PICTURE']) ? CFile::GetPath($addProperty['PREVIEW_PICTURE']) : '/no-image.svg';
    $detailPageUrl = CIBlock::ReplaceDetailUrl(
        $addProperty['DETAIL_PAGE_URL'],
        $addProperty,
        false,
        'E'
    );


    if (!empty($addProperty['PROPERTY_VIP_DATE_VALUE']) && strtotime($addProperty['PROPERTY_VIP_DATE_VALUE']) > time()) {
        $arResult['VIP_MARKS']['features'][] = [
            'type' => 'Feature',
            'properties' => [
                'href' => $detailPageUrl,
                'image' => $previewImg,
                'title' => $addProperty['NAME'],
                'price' => $price,
                'addres' => $addProperty['NAME'],
                'category' => $arParams['SECTION_NAME'],
                'views' => $addProperty['SHOW_COUNTER'],
                'date' => $addProperty['DATE_CREATE'],
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
                'image' => $previewImg,
                'title' => $addProperty['NAME'],
                'price' => $price,
                'addres' => $addProperty['NAME'],
                'category' => $arParams['SECTION_NAME'],
                'views' => $addProperty['SHOW_COUNTER'],
                'date' => $addProperty['DATE_CREATE'],
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

$iblock = \Bitrix\Iblock\Iblock::wakeUp(PROPERTY_ADS_IBLOCK_ID);
$propertyClass = $iblock->getEntityDataClass();
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

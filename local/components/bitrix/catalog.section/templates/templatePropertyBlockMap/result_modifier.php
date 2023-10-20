<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */

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
    $price = !empty($addProperty->getPrice()) ? '₪ ' . $addProperty->getPrice()->getValue() : '';
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
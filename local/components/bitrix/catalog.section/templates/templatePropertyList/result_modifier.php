<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */

if (!empty($arResult['ITEMS']) && !empty($arResult['ELEMENTS'])) {
    $countShowElement = [];
    $iblock = \Bitrix\Iblock\Iblock::wakeUp($arParams['IBLOCK_ID']);  // IB_ARTICLE - Ваш инфобло
    $classPropertyAdsClass = $iblock->getEntityDataClass();
    $elements = $classPropertyAdsClass::getList(array( // $ELEMENT_ID - id елемента
        'select' => array('ID', 'NAME', 'SHOW_COUNTER'),
        'filter' => array('ID' => $arResult['ELEMENTS']),
    ))->fetchAll();
    if (!empty($elements)) {
        foreach ($elements as $element) {
            $countShowElement[$element['ID']] = $element['SHOW_COUNTER'];
        }
    }

    $mapArray = ["type"=> "FeatureCollection"];
    $mapArrayVip = ["type" => "FeatureCollection"];
    $nameSection = $arParams['SECTION_NAME'];
    foreach ($arResult['ITEMS'] as &$item) {
        $counterJson = !empty($countShowElement[$item['ID']]) ? $countShowElement[$item['ID']] : 0;
        $mapLatlnt = json_decode($item['PROPERTIES']['MAP_LATLNG']['~VALUE'], true);

        if(!empty($item['PROPERTIES']['VIP_DATE']['VALUE']) && strtotime($item['PROPERTIES']['VIP_DATE']['VALUE']) > time()) {
            $mapArrayVip['features'][] = [
                'type' => 'Feature',
                'properties' => [
                    'href' => $item['DETAIL_PAGE_URL'],
                    'image' => $item['PREVIEW_PICTURE']['SAFE_SRC'] ?? '/no-image.svg',
                    'title' => $item['NAME'],
                    'price' => PROPERTY_CURRENCY_SYMBOL.' '.$item['PROPERTIES']['PRICE']['VALUE'],
                    'addres' => $item['NAME'],
                    'category' => $nameSection,
                    'views' => $counterJson,
                    'date' => $item['DATE_CREATE'],
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
        }else{
            $mapArray['features'][] = [
                'type' => 'Feature',
                'properties' => [
                    'href' => $item['DETAIL_PAGE_URL'],
                    'image' => $item['PREVIEW_PICTURE']['SAFE_SRC'] ?? '/no-image.svg',
                    'title' => $item['NAME'],
                    'price' => PROPERTY_CURRENCY_SYMBOL.' '.$item['PROPERTIES']['PRICE']['VALUE'],
                    'addres' => $item['NAME'],
                    'category' => $nameSection,
                    'views' => $counterJson,
                    'date' => $item['DATE_CREATE'],
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
    unset($item);

    $arResult['MAP_ARRAY'] = $mapArray;
    $arResult['MAP_ARRAY_VIP'] = $mapArrayVip;
}
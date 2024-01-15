<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if (!empty($arResult)) {
    
    $arResult['EDIT_PAGE'] = '#';
    switch ($arResult['IBLOCK_ID']) {
        case 1:
            $arResult['EDIT_PAGE'] = '/add/fm/?ID=' . $arResult['ID'] . '&EDIT=Y';
            break;
        case 2:
            if ($arResult['PROPERTIES']['BUY']["VALUE_XML_ID"] == 'true') {
                $arResult['EDIT_PAGE'] = '/add/rent/?ID=' . $arResult['ID'] . '&EDIT=Y';
            } else {
                $arResult['EDIT_PAGE'] = '/add/buy/?ID=' . $arResult['ID'] . '&EDIT=Y';
            }
            break;
        case 3:
            $arResult['EDIT_PAGE'] = '/add/auto/?ID=' . $arResult['ID'] . '&EDIT=Y';
            break;
        case 7:
            $arResult['EDIT_PAGE'] = '/add/moto/?ID=' . $arResult['ID'] . '&EDIT=Y';
            break;
        case 8:
            $arResult['EDIT_PAGE'] = '/add/scooter/?ID=' . $arResult['ID'] . '&EDIT=Y';
            break;
    }
    

    if (!empty($arResult['PROPERTIES']['ID_USER']['VALUE'])) {
        $rsUser = CUser::GetByID($arResult['PROPERTIES']['ID_USER']['VALUE']);
        $arUser = $rsUser->Fetch();
        $arResult['USER'] = $arUser;
        $arResult['USER']['IS_ONLINE'] = $arUser['IS_ONLINE'];
        $arResult['USER']['NAME'] = $arUser['NAME'];
        $arResult['USER']['DATE_REGISTER'] = explode(' ', $arUser['DATE_REGISTER'])[0];
    }

    if (!empty($arResult['PREVIEW_PICTURE']['ID'])) {
        if (empty($arResult['PROPERTIES']['PHOTOS']['VALUE'])) $arResult['PROPERTIES']['PHOTOS']['VALUE'] = [];
        array_unshift($arResult['PROPERTIES']['PHOTOS']['VALUE'],$arResult['PREVIEW_PICTURE']['ID']);
    }

    // Галерея
    if (!empty($arResult['PROPERTIES']['PHOTOS']['VALUE'])) {
        foreach($arResult['PROPERTIES']['PHOTOS']['VALUE'] as $imgId) {
            $arResult['PHOTOS']['BIG'][] = \CFile::ResizeImageGet(
                $imgId,
                array(
                    'width' => 610,
                    'height' => 470
                ),
                BX_RESIZE_IMAGE_PROPORTIONAL
            );

            $arResult['PHOTOS']['SMALL'][] = \CFile::ResizeImageGet(
                $imgId,
                array(
                    'width' => 116,
                    'height' => 75
                ),
                BX_RESIZE_IMAGE_EXACT
            );

            $arResult['PHOTOS']['BIG_SLIDER'][]['src'] = \CFile::GetPath($imgId);

            $arResult['PHOTOS']['SMALL_SLIDER'][] = \CFile::ResizeImageGet(
                $imgId,
                array(
                    'width' => 208,
                    'height' => 120
                ),
                BX_RESIZE_IMAGE_EXACT
            );
        }
    } else {
        $arResult['PHOTOS']['BIG'][]['src'] = SITE_TEMPLATE_PATH.'/assets/no-image.svg';
    }

    if ($arResult['IBLOCK_ID'] == PROPERTY_ADS_IBLOCK_ID && (!empty($arResult['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE']) || !empty($arResult['PROPERTIES']['MAP_LAYOUT']['VALUE']))){
        if (!empty($arResult['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE']) || !empty($arResult['PROPERTIES']['MAP_LAYOUT']['VALUE'])) $region = $arResult['PROPERTIES']['MAP_LAYOUT_BIG']['VALUE'];
        if (!empty($arResult['PROPERTIES']['MAP_LAYOUT']['VALUE'])) $city = $arResult['PROPERTIES']['MAP_LAYOUT']['VALUE'];
        $arResult['LOCATION'] = isset($city) ? $city . ', ' . $region : $region;
    } else {
        if (!empty($arResult['PROPERTIES']['LOCATION']['VALUE'])) $arResult['LOCATION'] = $arResult['PROPERTIES']['LOCATION']['VALUE'];
    }

    // MAP
    if (!empty($arResult['PROPERTIES']['MAP_LATLNG']['~VALUE'])) {
        $mapLatlnt = json_decode($arResult['PROPERTIES']['MAP_LATLNG']['~VALUE'], true);

        if ($mapLatlnt['lng'] == null) {
            $mapLatlnt['lat'] = $mapLatlnt[1];
            $mapLatlnt['lng'] = $mapLatlnt[0];
        }

        $arResult['MAP_MARK'] = json_encode([
            'type' => 'Feature',
            'properties' => [
                'href' => $arResult['DETAIL_PAGE_URL'],
                'image' => $arResult['PREVIEW_PICTURE']['SAFE_SRC'] ?? '/no-image.svg',
                'title' => $arResult['NAME'],
                'price' => !empty($arResult['PROPERTIES']['PRICE']['VALUE']) ? PROPERTY_CURRENCY_SYMBOL.' '.$arResult['PROPERTIES']['PRICE']['VALUE'] : '',
                'addres' => $arResult['NAME'],
                'date' => $arResult['DATE_CREATE'],
                'isVip' => !empty($arResult['PROPERTIES']['VIP_DATE']['VALUE']) && strtotime($arResult['PROPERTIES']['VIP_DATE']['VALUE']) > time() ? true : false,
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' =>
                    [$mapLatlnt['lng'], $mapLatlnt['lat']]
            ]
        ]);
    }
    // Собираем поля свойств для блока описания
    if (!empty($arResult['PROPERTIES'])) {
        foreach ($arResult['PROPERTIES'] as $prop){
            if (strripos($prop['CODE'], 'PROP') !== false && $prop['MULTIPLE'] == 'Y' && !empty($prop['VALUE']) && $prop['CODE'] !== 'PHOTOS') {
                $arResult['DESCRIPTION_PROPS'][] = [
                    'NAME' => $prop['NAME'],
                    'VALUE' => $prop['VALUE']
                ];
            }
        }
    }
}


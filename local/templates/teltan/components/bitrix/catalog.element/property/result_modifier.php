<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if (!empty($arResult)) {
    if (!empty($arResult['PROPERTIES']['ID_USER']['VALUE'])) {
        $rsUser = CUser::GetByID($arResult['PROPERTIES']['ID_USER']['VALUE']);
        $arUser = $rsUser->Fetch();
        $arResult['USER'] = $arUser;
        $arResult['USER']['IS_ONLINE'] = $arUser['IS_ONLINE'];
        $arResult['USER']['NAME'] = $arUser['NAME'];
        $arResult['USER']['DATE_REGISTER'] = explode(' ', $arUser['DATE_REGISTER'])[0];
    }

// Галерея
    if($arResult['PROPERTIES']['PHOTOS']['VALUE']) {
        foreach($arResult['PROPERTIES']['PHOTOS']['VALUE'] as $k => $item)
        {
            $arResult['PHOTOS'][$k]['BIG'] = resizeImg($item, 610, 470);
            $arResult['PHOTOS'][$k]['SMALL'] = resizeImg($item, 116, 75);
            $arResult['PHOTOS'][$k]['ORIG'] = CFile::GetPath($item);
            $arResult['PHOTOS'][$k]['SMALL_2'] = resizeImg($item, 208, 120);
        }
    } else {
        if ($arResult['PREVIEW_PICTURE']['SRC']) {
            $arResult['PHOTOS'] = [];
        }else{
            $arResult['PHOTOS'][0]['BIG'] = '/local/templates/teltan/assets/no-image.svg';
        }
    }

// Похожие объявления
    $i = 0;
    $arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "PROPERTY_PRICE", "DATE_CREATE", "SHOW_COUNTER", "PROPERTY_COLOR_DATE", "PROPERTY_LENTA_DATE", "PROPERTY_TYPE_TAPE");
    $arFilter = Array("IBLOCK_ID"=> $arResult['IBLOCK_ID'], "ACTIVE"=>"Y", "SECTION_ID" => $arResult['IBLOCK_SECTION_ID'], "!ID" => $arResult['ID']);
    $res = CIBlockElement::GetList(Array('RAND' => 'ASC'), $arFilter, false, Array("nTopCount" => 16), $arSelect);
    while($ob = $res->GetNextElement()) {
        $arResult['SIMILAR'][$i] = $ob->GetFields();
        $arResult['SIMILAR'][$i]['TAPE'] = getHighloadInfo(
            PERSONAL_RIBBON_HL_ID,
            array(
                'select' => array('*'),
                'filter' => array(
                    'UF_XML_ID' => $arResult['SIMILAR'][$i]['PROPERTY_TYPE_TAPE_VALUE']
                )
            )
        )[0];
        $i++;
    }

    $risesTypesClass = GetEntityDataClass(PERSONAL_RISE_HL_ID);
    $arResult['SPEED_UP_SALE']['RISES'] = $risesTypesClass::getList(array(
        'select' => array('*')
    ))->fetchAll();

    $vipTypesClass = GetEntityDataClass(PERSONAL_VIP_TYPES_HL_ID);
    $arResult['SPEED_UP_SALE']['VIPS'] = $vipTypesClass::getList(array(
        'select' => array('*')
    ))->fetchAll();

    $colorTypeClass = GetEntityDataClass(PERSONAL_COLOR_HL_ID);
    $arResult['SPEED_UP_SALE']['COLORS'] = $colorTypeClass::getList(array(
        'select' => array('*')
    ))->fetchAll();

    $ribbonsClass = GetEntityDataClass(PERSONAL_RIBBON_HL_ID);
    $arResult['SPEED_UP_SALE']['RIBBONS'] = $ribbonsClass::getList(array(
        'select' => array('*')
    ))->fetchAll();

    $packetsTypesClass = GetEntityDataClass(PERSONAL_PACKET_HL_ID);
    $arResult['SPEED_UP_SALE']['SETS'] = $packetsTypesClass::getList(array(
        'select' => array('*')
    ))->fetchAll();
}

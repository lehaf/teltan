<?
foreach ($arResult['ITEMS'] as $k => $arItem){
    if($arItem['PREVIEW_PICTURE']['ID'])
    {
        $arResult['ITEMS'][$k]['PREVIEW_203_179'] = resizeImg($arItem['PREVIEW_PICTURE']['ID'], 203, 179);
    }
    else
        $arResult['ITEMS'][$k]['PREVIEW_203_179'] = SITE_TEMPLATE_PATH.'/assets/no-image.svg';


    if($arItem['PROPERTIES']['TYPE_TAPE']['VALUE'])
        $arResult['ITEMS'][$k]['TAPE'] = getHighloadInfo(PERSONAL_RIBBON_HL_ID, array('select' => array('*'), 'filter' => array('UF_ACTIVE' => 1, 'UF_XML_ID' => $arItem['PROPERTIES']['TYPE_TAPE']['VALUE'])))[0];

    $arResult['ITEMS'][$k]['SECTION'] = getSectionInfo($arItem['IBLOCK_SECTION_ID'], $arItem['IBLOCK_ID']);
}


?>
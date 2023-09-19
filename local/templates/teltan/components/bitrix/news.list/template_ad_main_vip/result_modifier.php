<?
foreach ($arResult['ITEMS'] as $k => $arItem){
    if($arItem['PREVIEW_PICTURE']['ID'])
    {
        $arResult['ITEMS'][$k]['PREVIEW_450_377'] = resizeImg($arItem['PREVIEW_PICTURE']['ID'], 450, 377);
    }
    else
        $arResult['ITEMS'][$k]['PREVIEW_450_377'] = SITE_TEMPLATE_PATH.'/assets/no-image.svg';


    if($arItem['PROPERTIES']['TYPE_TAPE']['VALUE'])
        $arResult['ITEMS'][$k]['TAPE'] = getHighloadInfo(TYPE_TAPES_ID, array('select' => array('*'), 'filter' => array('UF_ACTIVE' => 1, 'UF_XML_ID' => $arItem['PROPERTIES']['TYPE_TAPE']['VALUE'])))[0];
}
?>
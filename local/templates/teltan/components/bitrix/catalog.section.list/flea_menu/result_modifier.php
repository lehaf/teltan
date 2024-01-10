<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['SECTIONS'])) {
    $newSections = [];
    foreach($arResult['SECTIONS'] as $section){
        if ($section['ELEMENT_CNT'] == 0) continue;

        switch (LANGUAGE_ID){
            case 'en':
                $section['NAME'] = $section['UF_NAME_EN'];
                break;
            case 'he':
                $section['NAME'] = $section['UF_NAME_HEB'];
                break;
        }

        if (empty($section['IBLOCK_SECTION_ID'])) {
            $newSections[$section['ID']] = $section;
        } else {
            $newSections[$section['IBLOCK_SECTION_ID']]['ITEMS'][$section['ID']] = $section;
        }
    }
    $arResult['SECTIONS'] = $newSections;
}
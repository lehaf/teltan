<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['SECTIONS'])) {
    $newSections = [];
    foreach($arResult['SECTIONS'] as $section){
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

    $counter = 0;
    $box = [];
    $sectionTree = [];
    foreach($newSections as $section){
        $box[] = $section;

        if ($counter === 3) {
            $sectionTree[] = $box;
            $box = [];
            $counter = 0;
        } else {
            $counter++;
        }
    }
    $arResult['SECTIONS'] = $sectionTree;
}

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

        // Ресайз картинок
        if (!empty($section['PICTURE']['ID'])) {
            $section['PICTURE'] = \CFile::ResizeImageGet(
                $section['PICTURE']['ID'],
                array(
                    'width' => 250,
                    'height' => 120
                ),
                BX_RESIZE_IMAGE_PROPORTIONAL
            );
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
    if (!empty($box)) $sectionTree[] = $box;
    $arResult['SECTIONS'] = $sectionTree;
}

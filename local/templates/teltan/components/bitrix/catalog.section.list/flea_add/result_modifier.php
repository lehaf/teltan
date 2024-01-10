<?php

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
    $arResult['SECTIONS'] = $newSections;
}
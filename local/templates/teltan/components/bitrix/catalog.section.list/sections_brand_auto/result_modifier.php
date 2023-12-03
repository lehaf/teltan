<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!empty($arResult['SECTIONS'])) {
    $newSections = [];
    $counter = 0;
    foreach ($arResult['SECTIONS'] as $key => $section) {
        if ($section['ELEMENT_CNT'] == 0) continue;

        if ($counter < 29){
            $newSections['SHOW'][] = $section;
        } else {
            $newSections['MORE'][] = $section;
        }
        $counter++;
    }

    $arResult['SECTIONS'] = $newSections;
}

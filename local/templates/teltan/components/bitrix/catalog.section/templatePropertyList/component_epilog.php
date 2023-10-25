<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
if ($arResult['IBLOCK_SECTION_ID']) {
    CModule::includeModule('iblock');
    $navChain = CIBlockSection::GetNavChain(
        false,
        $arResult['IBLOCK_SECTION_ID'], // Родительский раздел элемента
        array(
            'NAME',
            'CODE'
        ));
    switch (LANGUAGE_ID) {
        case 'he':
            $langId = 'HEB';
            break;
        case 'en':
            $langId = 'EN';
            break;
        default:
            $langId = false;
    }
    if (CSite::InDir('/flea/')) {
        $IBLOCK_ID = 1;
        $path = '/flea/';
    } elseif (CSite::InDir('/auto/')) {
        $IBLOCK_ID = 3;
        $path = '/auto/';
    } elseif (CSite::InDir('/moto/')) {
        $IBLOCK_ID = 7;
        $path = '/moto/';
    } elseif (CSite::InDir('/scooters/')) {
        $IBLOCK_ID = 8;
        $path = '/scooters/';
    } elseif (CSite::InDir('/property/')) {
        $IBLOCK_ID = 2;
        $path = '/property/';
    }

    while ($sectionPath = $navChain->GetNext()) {
        if ($langId) {
            $arFilter = array('IBLOCK_ID' => $IBLOCK_ID, 'CODE' => $sectionPath['CODE'], 'GLOBAL_ACTIVE' => 'Y');

            $db_list = CIBlockSection::GetList(array("timestamp_x" => "DESC"), $arFilter, false, array("UF_NAME_$langId"));

            if ($uf_value = $db_list->GetNext()) {
                $sectionPath['NAME'] = $uf_value["UF_NAME_$langId"];
            }

        }
        $path .= $sectionPath['CODE'] . '/';
        $APPLICATION->AddChainItem($sectionPath['NAME'], $path);
    }

    if ($langId) {
        $arFilter = array('IBLOCK_ID' => $IBLOCK_ID, ($arResult['CODE']) ? 'CODE' : 'ID' => ($arResult['CODE']) ?: $arResult['ID'], 'GLOBAL_ACTIVE' => 'Y');

        $db_list = CIBlockSection::GetList(array("timestamp_x" => "DESC"), $arFilter, false, array("UF_NAME_$langId"));

        if ($uf_value = $db_list->GetNext()) {
            $arResult['NAME'] = $uf_value["UF_NAME_$langId"];
        }

    }
    $APPLICATION->AddChainItem($arResult['NAME']); // Последний элемент
//
}
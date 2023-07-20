<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
ps($arResult);
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
    $path = '/catalog/'; // Начальный путь к Каталогу
    if (CSite::InDir('/flea/')) {
        $path = '/flea/'; // Начальный путь к Каталогу
        $IBLOCK_ID = 1;
    } elseif (CSite::InDir('/auto/')) {
        $path = '/auto/'; // Начальный путь к Каталогу
        $IBLOCK_ID = 3;
    } elseif (CSite::InDir('/moto/')) {
        $path = '/moto/'; // Начальный путь к Каталогу
        $IBLOCK_ID = 7;
    } elseif (CSite::InDir('/scooters/')) {
        $path = '/scooters/'; // Начальный путь к Каталогу
        $IBLOCK_ID = 8;
    } elseif (CSite::InDir('/property_new/')) {
        $path = '/property_new/'; // Начальный путь к Каталогу
        $IBLOCK_ID = 2;
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
        $arFilter = array('IBLOCK_ID' => $IBLOCK_ID, 'CODE' => $arResult['CODE'], 'GLOBAL_ACTIVE' => 'Y');

        $db_list = CIBlockSection::GetList(array("timestamp_x" => "DESC"), $arFilter, false, array("UF_NAME_$langId"));

        if ($uf_value = $db_list->GetNext()) {
            $arResult['NAME'] = $uf_value["UF_NAME_$langId"];
        }

    }
    $APPLICATION->AddChainItem($arResult['META_TAGS']['TITLE']); // Последний элемент
//
}
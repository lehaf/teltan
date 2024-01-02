<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class UserAdsCounter extends \CBitrixComponent
{
    private array $searchSort = [];
    private array $userSelectParams = [];
    private array $iblocks = [
        PROPERTY_ADS_IBLOCK_ID,
        SCOOTER_IBLOCK_ID,
        MOTO_IBLOCK_ID,
        AUTO_IBLOCK_ID,
        SIMPLE_ADS_IBLOCK_ID
    ];


    public function getAdsIblocks(array $adsId) : array
    {
        if (!empty($adsId)) {
            $items = \Bitrix\Iblock\ElementTable::getList(array(
                'select' => array('ID', 'IBLOCK_ID'),
                'filter' => array('ID' => $adsId),
                'cache' => array(
                    'ttl' => !empty($this->arParams['CACHE_TIME']) ? $this->arParams['CACHE_TIME'] : 3600,
                    'cache_joins' => true
                ),
            ))->fetchAll();

        }

        return !empty($items) ? $items : [];
    }

    public function setAdsDataToResult(array $items) : void
    {
        $ads = [];
        foreach ($items as $item) {
            $ads[$item['IBLOCK_ID']][] = $item['ID'];
            // формируем сортировку согласно поиску
            $this->searchSort[] = $item['ID'];
        }

        if (!empty($ads)) {
            // Получаем все возможные ленты продвижения
            $ribTypes = getHighloadInfo(
                PERSONAL_RIBBON_HL_ID,
                array(
                    'select' => array('*'),
                    'cache' => [
                        'ttl' => 3600000,
                        'cache_joins' => true
                    ]
                )
            );
            if (!empty($ribTypes)) {
                $ribbonTypes = [];
                foreach ($ribTypes as $ribbon) {
                    $ribbonTypes[$ribbon['UF_XML_ID']] = $ribbon;
                }
            }

            $resultAds = [];
            foreach ($ads as $iblockId => $adsIds) {
                $select = [
                    'ID',
                    'CODE',
                    'IBLOCK_SECTION_ID',
                    'NAME',
                    'SHOW_COUNTER',
                    'PREVIEW_PICTURE',
                    'PRICE',
                    'DATE_CREATE',
                    'VIP_DATE',
                    'COLOR_DATE',
                    'LENTA_DATE',
                    'TYPE_TAPE',
                    'IBLOCK',
                    'IBLOCK_SECTION',
                ];    
            
                // Выборка местоположений элементов
                if ($iblockId == PROPERTY_ADS_IBLOCK_ID){
                    $select[] = 'MAP_LAYOUT';
                    $select[] = 'MAP_LAYOUT_BIG';
                } else {
                    $select[] = 'LOCATION';
                }

                $order = [];
                $session = \Bitrix\Main\Application::getInstance()->getSession();
                if ($session->has('sort')) {
                    $sort = $session->get('sort');
                    $order[str_replace('property_', '', $sort['SORT']).'.VALUE'] = $sort['ORDER'];
                }

                $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass();
                $adsInfo = $iblockClass::getList(array(
                    'order' => $order,
                    'select' => $select,
                    'filter' => array('ID' => $adsIds, 'ACTIVE' => 'Y'),
                    'cache' => array(
                        'ttl' => !empty($this->arParams['CACHE_TIME']) ? $this->arParams['CACHE_TIME'] : 3600,
                        'cache_joins' => true
                    ),
                ))->fetchCollection();

                foreach ($adsInfo as $ad) {

                    $itemUrlPatternParams = [
                        'ID' => $ad->getId(),
                        'CODE' => $ad->getCode(),
                        'IBLOCK_SECTION_ID' => $ad->getIblockSectionId(),
                    ];

                    $resultAds[$ad->getId()] = [
                        'ID' => $ad->getId(),
                        'NAME' => $ad->getName(),
                        'DATE_CREATE' => $ad->getDateCreate(),
                        'SHOW_COUNTER' => $ad->getShowCounter(),
                        'DETAIL_PAGE_URL' => \CIBlock::ReplaceDetailUrl($ad->getIblock()->getDetailPageUrl(), $itemUrlPatternParams, true, 'E'),
                        'PROPERTIES' => [
                            'PRICE' => ['VALUE' => !empty($ad->getPrice()) ? $ad->getPrice()->getValue() : ''],
                            'LENTA_DATE' => ['VALUE' => !empty($ad->getLentaDate()) ? $ad->getLentaDate()->getValue() : ''],
                            'VIP_DATE' => ['VALUE' => !empty($ad->getVipDate()) ? $ad->getVipDate()->getValue() : ''],
                            'COLOR_DATE' => ['VALUE' => !empty($ad->getColorDate()) ? $ad->getColorDate()->getValue() : ''],
                        ],
                        'TAPE' => !empty($ribbonTypes) && !empty($ad->getTypeTape()) ?  $ribbonTypes[$ad->getTypeTape()->getValue()] : ''
                    ];

                    // Ресайз картинок
                    if (!empty($ad->getPreviewPicture())) {
                        $resultAds[$ad->getId()]['PREVIEW_PICTURE'] = \CFile::ResizeImageGet(
                            $ad->getPreviewPicture(),
                            array(
                                'width' => 450,
                                'height' => 377
                            ),
                            BX_RESIZE_IMAGE_PROPORTIONAL
                        );
                    } else {
                        $resultAds[$ad->getId()]['PREVIEW_PICTURE']['src'] = SITE_TEMPLATE_PATH . '/assets/no-image.svg';
                    }

                    // Получаем разделы элементов
                    if ($iblockId != AUTO_IBLOCK_ID && $iblockId != SCOOTER_IBLOCK_ID && $iblockId != MOTO_IBLOCK_ID) {
                        $sectionUrlPatternParams = [
                            'ID' => $ad->getIblockSection()->getId(),
                            'CODE' => $ad->getIblockSection()->getCode(),
                        ];

                        $resultAds[$ad->getId()]['SECTION'] = [
                            'NAME' => $ad->getIblockSection()->getName(),
                            'SECTION_PAGE_URL' => \CIBlock::ReplaceDetailUrl($ad->getIblock()->getSectionPageUrl(), $sectionUrlPatternParams, true, 'S')
                        ];
                    }

                    // Местоположение
                    if ($iblockId == PROPERTY_ADS_IBLOCK_ID && ((!empty($ad->getMapLayout()) && !empty($ad->getMapLayout()->getValue()))
                            || (!empty($ad->getMapLayoutBig()) && !empty($ad->getMapLayoutBig()->getValue())))){
                        if (!empty($ad->getMapLayoutBig()) && !empty($ad->getMapLayoutBig()->getValue())) $region = $ad->getMapLayoutBig()->getValue();
                        if (!empty($ad->getMapLayout()) && !empty($ad->getMapLayout()->getValue())) $city = $ad->getMapLayout()->getValue();
                        $resultAds[$ad->getId()]['LOCATION'] = isset($city) ? $city . ', ' . $region : $region;
                    } else {
                        if (!empty($ad->getLocation()) && !empty($ad->getLocation()->getValue()))
                            $resultAds[$ad->getId()]['LOCATION'] = $ad->getLocation()->getValue();
                    }

                    // Эрмитаж
                    $arButtons = CIBlock::GetPanelButtons(
                        $iblockId,
                        $ad->getId(),
                        0,
                        array("SECTION_BUTTONS"=>false, "SESSID"=>false)
                    );

                    $resultAds[$ad->getId()]["ADD_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
                    $resultAds[$ad->getId()]["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
                    $resultAds[$ad->getId()]["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

                    $resultAds[$ad->getId()]["ADD_LINK_TEXT"] = $arButtons["edit"]["add_element"]["TEXT"];
                    $resultAds[$ad->getId()]["EDIT_LINK_TEXT"] = $arButtons["edit"]["edit_element"]["TEXT"];
                    $resultAds[$ad->getId()]["DELETE_LINK_TEXT"] = $arButtons["edit"]["delete_element"]["TEXT"];
                }
            }

            if (!empty($resultAds)) $this->sortAds($resultAds);
        }
    }

    public function sortAds(array $ads) : void
    {
        if (!empty($ads)) {
            foreach ($ads as $adId => $adData) {
                $key = array_search($adId, $this->searchSort);
                $typeAds = strtotime($adData['PROPERTIES']['VIP_DATE']['VALUE']) > time() ? 'VIP' : 'COMMON';
                $this->arResult['ITEMS'][$typeAds][$key] = $adData;
            }
        }
    }

    public function executeComponent()
    {
        $items = $this->getAdsIblocks($this->arParams['ITEMS']);
        if (!empty($items)) {
            $this->setAdsDataToResult($items);
            $this->includeComponentTemplate();
        }
    }
}
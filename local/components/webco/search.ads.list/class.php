<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class UserAdsCounter extends \CBitrixComponent
{
    private object $nav;
    private array $searchSort = [];


    public function getUserAds(array $itemsId) : void
    {
        // формируем сортировку согласно поиску
        $this->searchSort = $itemsId;

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

        $select = [
            'ID',
            'CODE',
            'IBLOCK_ID',
            'IBLOCK_SECTION_ID',
            'DATE_CREATE',
            'NAME',
            'SECTION_NAME' => 'IBLOCK_SECTION.NAME',
            'SECTION_PAGE_URL' => 'IBLOCK.SECTION_PAGE_URL',
            'DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL',
            'SHOW_COUNTER',
            'PREVIEW_PICTURE',
        ];

        $selectUserProps = [
            'TIME_RAISE',
            'PRICE',
            'COUNT_RAISE',
            'VIP_DATE',
            'PAKET_DATE',
            'COLOR_DATE',
            'LENTA_DATE',
            'TYPE_TAPE',
            'ID_USER',
            'MAP_LAYOUT',
            'MAP_LAYOUT_BIG',
            'LOCATION',
        ];


        $order = [];
        $session = \Bitrix\Main\Application::getInstance()->getSession();
        if ($session->has('sort')) {
            $sort = $session->get('sort');
            if ($sort['NAME'] === 'Relevance') {
                $relevanceSort = 'Y';
            } else {
                $order[str_replace('property_', '', $sort['SORT'])] = $sort['ORDER'];
                $relevanceSort = 'N';
            }
        }

        $nav = new \Bitrix\Main\UI\PageNavigation('search_list');
        $maxPageElements = !empty($this->arParams['MAX_PAGE_ELEMENTS']) ? $this->arParams['MAX_PAGE_ELEMENTS'] : 12;

        $nav->allowAllRecords(false)
            ->setPageSize($maxPageElements)
            ->initFromUri();

        $query = \Bitrix\Iblock\ElementTable::query()
            ->setOrder($order)
            ->setSelect(array_merge($select,$selectUserProps))
            ->setLimit($nav->getLimit())
            ->setOffset($nav->getOffset())
            ->setFilter([
                'ID' => $itemsId,
                'ACTIVE' => 'Y',
            ])
            ->setGroup([
                'ID',
            ])
            ->registerRuntimeField(
                new \Bitrix\Main\Entity\ReferenceField(
                    'ELEMENT_PROPERTY', // Даем алиас таблице
                    '\Bitrix\Iblock\ElementPropertyTable',
                    ['=this.ID' => 'ref.IBLOCK_ELEMENT_ID'],
                )
            )
            ->registerRuntimeField(
                new \Bitrix\Main\Entity\ReferenceField(
                    'PROPERTY', // Даем алиас таблице
                    '\Bitrix\Iblock\PropertyTable',
                    ['=this.ELEMENT_PROPERTY.IBLOCK_PROPERTY_ID' => 'ref.ID'],
                )
            );

        foreach ($selectUserProps as $propCode) {
            $query->registerRuntimeField(
                $propCode,
                [
                    'expression' => ['GROUP_CONCAT(CASE WHEN %s = "'.$propCode.'" THEN %s  END)', 'PROPERTY.CODE', 'ELEMENT_PROPERTY.VALUE']
                ]
            );
        }

        $count = $query->queryCountTotal();
        $nav->setRecordCount($count);
        $this->nav = $nav;

        $collection = $query->exec()->fetchAll();

        if (!empty($collection)) {
            $resultAds = [];
            foreach ($collection as &$ad) {
                $ad['PRICE'] =  !empty($ad['PRICE']) ? ICON_CURRENCY.' '.round($ad['PRICE']) : '';
                $ad['COUNT_RAISE'] = round($ad['COUNT_RAISE']);
                $ad['RIBBON'] = !empty($ribbonTypes) && !empty($ad['TYPE_TAPE']) ?  $ribbonTypes[$ad['TYPE_TAPE']] : '';
                $ad['DETAIL_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($ad['DETAIL_PAGE_URL'], $ad, true, 'E');

                // Получаем разделы элементов
                if ($ad['IBLOCK_ID'] != AUTO_IBLOCK_ID && $ad['IBLOCK_ID'] != SCOOTER_IBLOCK_ID && $ad['IBLOCK_ID'] != MOTO_IBLOCK_ID) {
                    $ad['SECTION'] = [
                        'NAME' => $ad['SECTION_NAME'],
                        'SECTION_PAGE_URL' => \CIBlock::ReplaceDetailUrl($ad['SECTION_PAGE_URL'], $ad, true, 'S')
                    ];
                }

                // Местоположение
                if ($ad['IBLOCK_ID'] == PROPERTY_ADS_IBLOCK_ID && (!empty($ad['MAP_LAYOUT_BIG']) || !empty($ad['MAP_LAYOUT']))){
                    if (!empty($ad['MAP_LAYOUT_BIG']) || !empty($ad['MAP_LAYOUT'])) $region = $ad['MAP_LAYOUT_BIG'];
                    if (!empty($ad['MAP_LAYOUT'])) $city = $ad['MAP_LAYOUT'];
                    $ad['LOCATION'] = isset($city) ? $city . ', ' . $region : $region;
                }

                // Ресайз картинок
                if (!empty($ad['PREVIEW_PICTURE'])) {
                    $ad['PREVIEW_PICTURE'] = \CFile::ResizeImageGet(
                        $ad['PREVIEW_PICTURE'],
                        array(
                            'width' => 250,
                            'height' => 200
                        ),
                        BX_RESIZE_IMAGE_PROPORTIONAL_ALT
                    );
                } else {
                    $ad['PREVIEW_PICTURE']['src'] = SITE_TEMPLATE_PATH . '/assets/no-image.svg';
                }

                // Эрмитаж
                $arButtons = CIBlock::GetPanelButtons(
                    $ad['IBLOCK_ID'],
                    $ad['ID'],
                    0,
                    array("SECTION_BUTTONS"=>false, "SESSID"=>false)
                );

                $ad["ADD_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
                $ad["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
                $ad["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

                $ad["ADD_LINK_TEXT"] = $arButtons["edit"]["add_element"]["TEXT"];
                $ad["EDIT_LINK_TEXT"] = $arButtons["edit"]["edit_element"]["TEXT"];
                $ad["DELETE_LINK_TEXT"] = $arButtons["edit"]["delete_element"]["TEXT"];

                $resultAds[] = $ad;
            }
            unset($ad);
        }

        if (!empty($resultAds)) $this->sortAds($resultAds, $relevanceSort);
    }

    public function sortAds(array $ads, string $relevanceSort = 'Y') : void
    {
        if (!empty($ads)) {
            foreach ($ads as $key => $adData) {
                if ($relevanceSort === 'Y') $key = array_search($adData['ID'], $this->searchSort);
                $typeAds = strtotime($adData['VIP_DATE']) > time() ? 'VIP' : 'COMMON';
                $this->arResult['ITEMS'][$typeAds][$key] = $adData;
            }
        }
    }

    public function executeComponent()
    {
        if (!empty($this->arParams['ITEMS'])) {
            $this->getUserAds($this->arParams['ITEMS']);
            $this->includeComponentTemplate();
            global $APPLICATION;
            $APPLICATION->IncludeComponent(
                "bitrix:main.pagenavigation",
                "user-history",
                array(
                    "NAV_OBJECT" => $this->nav,
                    "SHOW_COUNT" => "N",
                ),
                false
            );
        }
    }
}
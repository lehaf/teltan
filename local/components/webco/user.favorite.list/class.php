<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class UserFavoriteList extends \CBitrixComponent
{
    private int $curUserId;
    private object $nav;
    private string $pagerName = 'favorite';
    private array $iblocksId = [
        PROPERTY_ADS_IBLOCK_ID,
        SCOOTER_IBLOCK_ID,
        MOTO_IBLOCK_ID,
        AUTO_IBLOCK_ID,
        SIMPLE_ADS_IBLOCK_ID,
    ];

    public function __construct($component = \null)
    {
        $this->curUserId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
        parent::__construct($component);
    }

    public function getUserAds() : void
    {
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
            'PRICE',
            'VIP_DATE',
            'COLOR_DATE',
            'LENTA_DATE',
            'TYPE_TAPE',
            'MAP_LAYOUT',
            'MAP_LAYOUT_BIG',
            'LOCATION',
            'PROP_TRANSMISION_Left',
            'PROP_PROBEG_Left',
            'PROP_KM_ML',
            'PROP_ENGIEN_LITERS_Left',
            'PROP_ENGINE',
            'PROP_KM_ML_ENGIE',
        ];

        $nav = new \Bitrix\Main\UI\PageNavigation($this->pagerName);
        $maxPageElements = !empty($this->arParams['MAX_PAGE_ELEMENTS']) ? $this->arParams['MAX_PAGE_ELEMENTS'] : 12;

        $nav->allowAllRecords(false)
            ->setPageSize($maxPageElements)
            ->initFromUri();

        $itemsId = getFavoritesUser($this->curUserId);

        $query = \Bitrix\Iblock\ElementTable::query()
            ->setOrder(['DATE_CREATE' => 'DESC'])
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
            )
            ->registerRuntimeField(
                "EDIT_PAGE",
                [
                    'expression' => [
                        'CASE WHEN %s = "1" THEN "/add/fm/" 
                      WHEN %s = "2" AND (%s = "34" OR %s = "32") THEN "/add/rent/" 
                      WHEN %s = "2" AND (%s = "35" OR %s = "33") THEN "/add/buy/" 
                      WHEN %s = "3" THEN "/add/auto/" 
                      WHEN %s = "7" THEN "/add/moto/" 
                      WHEN %s = "8" THEN "/add/scooter/" 
                END',
                        'IBLOCK_ID',
                        'IBLOCK_ID',
                        'IBLOCK_SECTION_ID',
                        'IBLOCK_SECTION_ID',
                        'IBLOCK_ID',
                        'IBLOCK_SECTION_ID',
                        'IBLOCK_SECTION_ID',
                        'IBLOCK_ID',
                        'IBLOCK_ID',
                        'IBLOCK_ID',
                    ]
                ]
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
                $ad['RIBBON'] = !empty($ribbonTypes) && !empty($ad['TYPE_TAPE']) ?  $ribbonTypes[$ad['TYPE_TAPE']] : '';
                $ad['COUNT_RAISE'] = round($ad['COUNT_RAISE']);
                $ad['DETAIL_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($ad['DETAIL_PAGE_URL'], $ad, true, 'E');

                // Получаем разделы элементов
                if ($ad['IBLOCK_ID'] != AUTO_IBLOCK_ID && $ad['IBLOCK_ID'] != SCOOTER_IBLOCK_ID && $ad['IBLOCK_ID'] != MOTO_IBLOCK_ID) {
                    $ad['SECTION'] = [
                        'NAME' => $ad['SECTION_NAME'],
                        'SECTION_PAGE_URL' => \CIBlock::ReplaceDetailUrl($ad['SECTION_PAGE_URL'], $ad, true, 'S')
                    ];
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
        } else {
            $this->abortResultCache();

            if (!empty($_GET[$this->pagerName])) {
                global $APPLICATION;
                $curPage = $APPLICATION->GetCurPage();
                LocalRedirect($curPage);
            }
        }

        if (!empty($resultAds)) $this->arResult['ADS'] = $resultAds;
    }


    public function bindTagsToCache()
    {
        global $CACHE_MANAGER;
        foreach ($this->iblocksId as $iblockId) {
            $CACHE_MANAGER->RegisterTag("iblock_id_".$iblockId);
        }
        $CACHE_MANAGER->RegisterTag("favorite_user_".$this->curUserId);
    }

    public function setPageNavigationToResult()
    {
        global $APPLICATION;
        ob_start();
        $APPLICATION->IncludeComponent(
            "bitrix:main.pagenavigation",
            "user-history",
            array(
                "NAV_OBJECT" => $this->nav,
                "SHOW_COUNT" => "N",
            ),
            false
        );
        $this->arResult['PAGINATION'] = ob_get_contents();
        ob_end_clean();
    }

    public function executeComponent()
    {
        if ($this->startResultCache($this->arParams['CACHE_TIME'], [$this->curUserId,$this->pagerName, $_GET[$this->pagerName]])) {
            $this->bindTagsToCache();
            $this->getUserAds();
            $this->setPageNavigationToResult();
            $this->includeComponentTemplate();
        }
    }
}
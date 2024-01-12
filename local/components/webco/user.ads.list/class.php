<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class UserAdsList extends \CBitrixComponent
{
    private array $iblocks = [
        PROPERTY_ADS_IBLOCK_ID => [
            'EDIT_PAGE' => [
                'BUY' => '/add/buy/',
                'RENT' => '/add/rent/',
            ]
        ],
        SCOOTER_IBLOCK_ID => [
            'EDIT_PAGE' => '/add/scooter/'
        ],
        MOTO_IBLOCK_ID => [
            'EDIT_PAGE' => '/add/moto/'
        ],
        AUTO_IBLOCK_ID => [
            'EDIT_PAGE' => '/add/auto/'
        ],
        SIMPLE_ADS_IBLOCK_ID => [
            'EDIT_PAGE' => '/add/fm/'
        ],
    ];

    public function getUserAds(int $iblockId, array $editLink, string $active = 'Y') : array
    {
        $select = [
            'ID',
            'CODE',
            'IBLOCK_ID',
            'IBLOCK_SECTION_ID',
            'NAME',
            'SHOW_COUNTER',
            'PREVIEW_PICTURE',
            'TIME_RAISE',
            'PRICE',
            'DATE_CREATE',
            'COUNT_RAISE',
            'VIP_DATE',
            'PAKET_DATE',
            'COLOR_DATE',
            'LENTA_DATE',
            'TYPE_TAPE',
            'IBLOCK',
            'IBLOCK_SECTION',
        ];

        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass();
        $adsInfo = $iblockClass::getList(array(
            'order' => ['ID' => 'ASC'],
            'select' => $select,
            'filter' => array(
                'ID_USER.VALUE' => \Bitrix\Main\Engine\CurrentUser::get()->getId(),
                'ACTIVE' => $active
            )
        ))->fetchCollection();

        $resultAds = [];
        foreach ($adsInfo as $ad) {
            $itemUrlPatternParams = [
                'ID' => $ad->getId(),
                'CODE' => $ad->getCode(),
                'IBLOCK_SECTION_ID' => $ad->getIblockSectionId(),
            ];

            if ($iblockId === PROPERTY_ADS_IBLOCK_ID) {
                if (in_array($ad->getIblockSectionId(), BUY_SECTION_ID_ARRAY))
                    $editPage = $editLink['EDIT_PAGE']['BUY'];
                if (in_array($ad->getIblockSectionId(), RENT_SECTION_ID_ARRAY))
                    $editPage = $editLink['EDIT_PAGE']['BUY'];
            } else {
                $editPage = $editLink['EDIT_PAGE'];
            }

            $resultAds[$ad->getId()] = [
                'ID' => $ad->getId(),
                'IBLOCK_ID' => $ad->getIblockId(),
                'NAME' => $ad->getName(),
                'ACTIVE' => $active,
                'DATE_CREATE' => $ad->getDateCreate(),
                'SHOW_COUNTER' => $ad->getShowCounter(),
                'DETAIL_PAGE_URL' => \CIBlock::ReplaceDetailUrl($ad->getIblock()->getDetailPageUrl(), $itemUrlPatternParams, true, 'E'),
                'EDIT_PAGE' => $editPage,
                'PROPERTIES' => [
                    'PRICE' => ['VALUE' => !empty($ad->getPrice()) ? ICON_CURRENCY.' '.$ad->getPrice()->getValue() : ''],
                    'LENTA_DATE' => ['VALUE' => !empty($ad->getLentaDate()) ? $ad->getLentaDate()->getValue() : ''],
                    'VIP_DATE' => ['VALUE' => !empty($ad->getVipDate()) ? $ad->getVipDate()->getValue() : ''],
                    'PAKET_DATE' => ['VALUE' => !empty($ad->getPaketDate()) ? $ad->getPaketDate()->getValue() : ''],
                    'COLOR_DATE' => ['VALUE' => !empty($ad->getColorDate()) ? $ad->getColorDate()->getValue() : ''],
                    'TIME_RAISE' => ['VALUE' => !empty($ad->getTimeRaise()) ? $ad->getTimeRaise()->getValue() : ''],
                    'COUNT_RAISE' => ['VALUE' => !empty($ad->getCountRaise()) ? $ad->getCountRaise()->getValue() : ''],
                ],
                'TAPE' => !empty($ribbonTypes) && !empty($ad->getTypeTape()) ?  $ribbonTypes[$ad->getTypeTape()->getValue()] : ''
            ];

            // Ресайз картинок
            if (!empty($ad->getPreviewPicture())) {
                $resultAds[$ad->getId()]['PREVIEW_PICTURE'] = \CFile::ResizeImageGet(
                    $ad->getPreviewPicture(),
                    array(
                        'width' => 250,
                        'height' => 200
                    ),
                    BX_RESIZE_IMAGE_PROPORTIONAL_ALT
                );
            } else {
                $resultAds[$ad->getId()]['PREVIEW_PICTURE']['src'] = SITE_TEMPLATE_PATH . '/assets/no-image.svg';
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

        return $resultAds;
    }

    public function setUserAdsToResult() : void
    {
        if (!empty($this->iblocks)) {
            $resultAds = [];
            foreach ($this->iblocks as $iblockId => $editLink) {
                $iblockUserAds = $this->getUserAds($iblockId, $editLink, $this->arParams['ACTIVE']);
                $resultAds = array_merge($resultAds,$iblockUserAds);
            }

            if (!empty($resultAds)) $this->arResult['ADS'] = $resultAds;
        }
    }

    public function bindTagsToCache()
    {
        global $CACHE_MANAGER;
        foreach ($this->iblocks as $iblockId => $editPage) {
            $CACHE_MANAGER->RegisterTag("iblock_id_".$iblockId);
        }
    }

    public function executeComponent()
    {
        if ($this->startResultCache()) {
            $this->bindTagsToCache(); // Вешаем теги инфоблока на кэш
            $this->setUserAdsToResult($this->arParams['ACTIVE']);
            $this->includeComponentTemplate();
        }
    }
}
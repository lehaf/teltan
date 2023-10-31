<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class UserAdsCounter extends \CBitrixComponent
{
    private array $userSelectParams = [];
    private array $iblocks = [
        PROPERTY_ADS_IBLOCK_ID,
        SCOOTER_IBLOCK_ID,
        MOTO_IBLOCK_ID,
        AUTO_IBLOCK_ID,
        SIMPLE_ADS_IBLOCK_ID
    ];
    private array $adsIblocksData = [
        PROPERTY_ADS_IBLOCK_ID => [
            "NAME" => 'PROPERTY',
            'FREE_USER_PROP' =>  'UF_DAYS_FREE3',
            'COST_USER_PROP' =>  'UF_COUNT_RENT',
            'COUNT_ADS_USER_PROP' =>  'UF_COUNT_APART',
        ],
        SCOOTER_IBLOCK_ID => [
            "NAME" => 'AUTO',
            'FREE_USER_PROP' =>  'UF_UF_DAYS_FREE2',
            'COST_USER_PROP' =>  'UF_AUTO',
            'COUNT_ADS_USER_PROP' =>  'UF_COUNT_AUTO',
        ],
        MOTO_IBLOCK_ID => [
            "NAME" => 'AUTO',
            'FREE_USER_PROP' =>  'UF_UF_DAYS_FREE2',
            'COST_USER_PROP' =>  'UF_AUTO',
            'COUNT_ADS_USER_PROP' =>  'UF_COUNT_AUTO',
        ],
        AUTO_IBLOCK_ID => [
            "NAME" => 'AUTO',
            'FREE_USER_PROP' =>  'UF_UF_DAYS_FREE2',
            'COST_USER_PROP' =>  'UF_AUTO',
            'COUNT_ADS_USER_PROP' =>  'UF_COUNT_AUTO',
        ],
        SIMPLE_ADS_IBLOCK_ID => [
            "NAME" => 'FLEA',
            'FREE_USER_PROP' =>  'UF_DAYS_FREE1',
            'COST_USER_PROP' =>  'UF_ANOUNC',
            'COUNT_ADS_USER_PROP' =>  'UF_COUNT_FLEA',
        ],
    ];

    public function setSelectUserParams() : void
    {
        foreach ($this->adsIblocksData as $userProps) {
            $this->userSelectParams[] = $userProps['FREE_USER_PROP'];
            $this->userSelectParams[] = $userProps['COST_USER_PROP'];
            $this->userSelectParams[] = $userProps['COUNT_ADS_USER_PROP'];
        }
    }

    public function setUserCounters(array $user) : void
    {
        if (!empty($user)) {
            $autoAdded = false;
            foreach ($this->adsIblocksData as $userProps) {
                if ($userProps['NAME'] === 'AUTO') {
                    if ($autoAdded === false) {
                        $autoAdded = true;
                        $this->arResult['COUNTER'][$userProps['NAME']]['USED'] = $user[$userProps['COUNT_ADS_USER_PROP']];
                        $this->arResult['COUNTER'][$userProps['NAME']]['POSSIBLE'] =
                            $user[$userProps['FREE_USER_PROP']] + $user[$userProps['COST_USER_PROP']];
                        $this->arResult['COUNTER'][$userProps['NAME']]['FREE_LIMIT'] = $user[$userProps['FREE_USER_PROP']];
                        $this->arResult['COUNTER'][$userProps['NAME']]['COST_LIMIT'] = $user[$userProps['COST_USER_PROP']];
                    }
                } else {
                    $this->arResult['COUNTER'][$userProps['NAME']]['USED'] = $user[$userProps['COUNT_ADS_USER_PROP']];
                    $this->arResult['COUNTER'][$userProps['NAME']]['POSSIBLE'] =
                        $user[$userProps['FREE_USER_PROP']] + $user[$userProps['COST_USER_PROP']];
                    $this->arResult['COUNTER'][$userProps['NAME']]['FREE_LIMIT'] = $user[$userProps['FREE_USER_PROP']];
                    $this->arResult['COUNTER'][$userProps['NAME']]['COST_LIMIT'] = $user[$userProps['COST_USER_PROP']];
                }
            }
        }
    }

    public function getUserCountAdsAndLimits()
    {
        $this->setSelectUserParams();
        if (!empty(\Bitrix\Main\Engine\CurrentUser::get()->getId())) {
            $user = \Bitrix\Main\UserTable::getList(array(
                'select' => array('ID', ...$this->userSelectParams),
                'filter' => array('ID' => \Bitrix\Main\Engine\CurrentUser::get()->getId()),
            ))->fetch();
            if (!empty($user)) $this->setUserCounters($user);
        }
    }

    public function getUserAds() : void
    {
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            foreach ($this->iblocks as $iblockId) {
                $iblock = \Bitrix\Iblock\Iblock::wakeUp($iblockId);
                $iblockClass = $iblock->getEntityDataClass();
                $collection = $iblockClass::getList(array(
                    'select' => ['ID', 'FREE_AD', 'IBLOCK_ID'],
                    'filter' => ['ID_USER.VALUE' => \Bitrix\Main\Engine\CurrentUser::get()->getId()]
                ))->fetchCollection();

                foreach ($collection as $item) {
                    if ($item->getFreeAd()->getValue()) {
                        $this->arResult['USER_ADS'][$this->adsIblocksData[$iblockId]['NAME']]['FREE_ADS'][] = $item->getId();
                        $this->arResult['USER_ADS'][$this->adsIblocksData[$iblockId]['NAME']]['FREE_ADS_COUNT'] += 1;
                    } else {
                        $this->arResult['USER_ADS'][$this->adsIblocksData[$iblockId]['NAME']]['COST_ADS'][] = $item->getId();
                        $this->arResult['USER_ADS'][$this->adsIblocksData[$iblockId]['NAME']]['COST_ADS_COUNT'] += 1;
                    }
                }
            }
        }
    }

    public function executeComponent()
    {
        $this->getUserCountAdsAndLimits();
        $this->getUserAds();
        $this->includeComponentTemplate();
    }
}
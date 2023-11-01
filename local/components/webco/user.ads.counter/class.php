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
            'FREE_USER_PROP' =>  'UF_FREE_PROPERTY',
            'COST_USER_PROP' =>  'UF_AVAILABLE_PROPERTY',
            'COUNT_ADS_USER_PROP' =>  'UF_COUNT_PROPERTY',
        ],
        SCOOTER_IBLOCK_ID => [
            "NAME" => 'AUTO',
            'FREE_USER_PROP' =>  'UF_FREE_AUTO',
            'COST_USER_PROP' =>  'UF_AVAILABLE_AUTO',
            'COUNT_ADS_USER_PROP' =>  'UF_COUNT_AUTO',
        ],
        MOTO_IBLOCK_ID => [
            "NAME" => 'AUTO',
            'FREE_USER_PROP' =>  'UF_FREE_AUTO',
            'COST_USER_PROP' =>  'UF_AVAILABLE_AUTO',
            'COUNT_ADS_USER_PROP' =>  'UF_COUNT_AUTO',
        ],
        AUTO_IBLOCK_ID => [
            "NAME" => 'AUTO',
            'FREE_USER_PROP' =>  'UF_FREE_AUTO',
            'COST_USER_PROP' =>  'UF_AVAILABLE_AUTO',
            'COUNT_ADS_USER_PROP' =>  'UF_COUNT_AUTO',
        ],
        SIMPLE_ADS_IBLOCK_ID => [
            "NAME" => 'FLEA',
            'FREE_USER_PROP' =>  'UF_FREE_FLEA',
            'COST_USER_PROP' =>  'UF_AVAILABLE_FLEA',
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
        if (\Bitrix\Main\Loader::includeModule('highloadblock') && \Bitrix\Main\Loader::includeModule('iblock')) {
            $curTime = new \Bitrix\Main\Type\DateTime();
            $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
            $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
            $userRates = $boughtRateEntity::getList(array(
                'order' => array('ID' => 'DESC'),
                'select' => array('*'),
                'filter' => array(
                    'UF_USER_ID'=> $userId,
                    '>UF_DATE_EXPIRED'=> $curTime
                )
            ))->fetchAll();

            if (!empty($userRates)) {
                foreach ($userRates as $key => $rate) {
                    $this->arResult['USER_ADS'][$rate['UF_TYPE']]['COST_ADS'][$key]['DATE_EXPIRED'] = $rate['UF_DATE_EXPIRED'];
                    $this->arResult['USER_ADS'][$rate['UF_TYPE']]['COST_ADS'][$key]['LIMIT'] = $rate['UF_COUNT_REMAIN'];

                    if (!empty($rate['UF_ID_ANONC']))
                        $this->arResult['USER_ADS'][$rate['UF_TYPE']]['COST_ADS'][$key]['COUNT'] += count($rate['UF_ID_ANONC']);
                }
            }

            // Получаем бесплатные объявления пользователей
            foreach ($this->iblocks as $iblockId) {
                $iblock = \Bitrix\Iblock\Iblock::wakeUp($iblockId);
                $iblockClass = $iblock->getEntityDataClass();
                $collection = $iblockClass::getList(array(
                    'select' => ['ID', 'ACTIVE_TO'],
                    'filter' => [
                        'ID_USER.VALUE' => \Bitrix\Main\Engine\CurrentUser::get()->getId(),
                        '!FREE_AD.VALUE' => false
                    ]
                ))->fetchCollection();

                foreach ($collection as $item) {
                    if ($item->getId()) {
                        $this->arResult['USER_ADS'][$this->adsIblocksData[$iblockId]['NAME']]['FREE_ADS'][] = $item->getId();
                        $this->arResult['USER_ADS'][$this->adsIblocksData[$iblockId]['NAME']]['FREE_ADS_COUNT'] += 1;
                        $this->arResult['USER_ADS'][$this->adsIblocksData[$iblockId]['NAME']]['FREE_DATE_EXPIRED'] = $item->getActiveTo();
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
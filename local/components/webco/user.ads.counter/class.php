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
        ],
        SCOOTER_IBLOCK_ID => [
            "NAME" => 'AUTO',
            'FREE_USER_PROP' =>  'UF_FREE_AUTO',
        ],
        MOTO_IBLOCK_ID => [
            "NAME" => 'AUTO',
            'FREE_USER_PROP' =>  'UF_FREE_AUTO',
        ],
        AUTO_IBLOCK_ID => [
            "NAME" => 'AUTO',
            'FREE_USER_PROP' =>  'UF_FREE_AUTO',
        ],
        SIMPLE_ADS_IBLOCK_ID => [
            "NAME" => 'FLEA',
            'FREE_USER_PROP' =>  'UF_FREE_FLEA',
        ],
    ];

    public function setSelectUserParams() : void
    {
        foreach ($this->adsIblocksData as $userProps) {
            $this->userSelectParams[] = $userProps['FREE_USER_PROP'];
        }
    }

    private function getUserRates() : ?array
    {
        $boughtRateEntity = GetEntityDataClass(BOUGHT_RATE_HL_ID);
        $userRates = $boughtRateEntity::getList(array(
            'order' => array('ID' => 'ASC'),
            'select' => array('*'),
            'filter' => array(
                'UF_USER_ID'=>  \Bitrix\Main\Engine\CurrentUser::get()->getId(),
                '>UF_DATE_EXPIRED'=> new \Bitrix\Main\Type\DateTime()
            )
        ))->fetchAll();

        return $userRates ?? NULL;
    }

    public function getUserRateAdsLimitInfo(array $userRates) : array
    {
        $limits = [];
        if (!empty($userRates)) {
            foreach ($userRates as $rate) {
                $limits[$rate['UF_TYPE']] += $rate['UF_COUNT_REMAIN'];
            }
        }
        return $limits;
    }

    public function setUserCounters(array $user, array $userRates = []) : void
    {
        if (!empty($user)) {
            $autoAdded = false;
            $rateLimits = $this->getUserRateAdsLimitInfo($userRates);
            foreach ($this->adsIblocksData as $userProps) {
                if ($userProps['NAME'] === 'AUTO') {
                    if ($autoAdded === false) {
                        $autoAdded = true;
                        $costAdsCount = 0;
                        if (!empty($this->arResult['USER_ADS'][$userProps['NAME']]['COST_ADS'])) {
                            foreach ($this->arResult['USER_ADS'][$userProps['NAME']]['COST_ADS'] as $rateAds) {
                                $costAdsCount += $rateAds['COUNT'];
                            }
                        }
                        $this->arResult['COUNTER'][$userProps['NAME']]['USED'] =
                            $costAdsCount + $this->arResult['USER_ADS'][$userProps['NAME']]['FREE_ADS_COUNT'];


                        $this->arResult['COUNTER'][$userProps['NAME']]['POSSIBLE'] =
                            $user[$userProps['FREE_USER_PROP']] + $rateLimits[$userProps['NAME']];
                        $this->arResult['COUNTER'][$userProps['NAME']]['FREE_LIMIT'] = $user[$userProps['FREE_USER_PROP']];
                        $this->arResult['COUNTER'][$userProps['NAME']]['COST_LIMIT'] = $user[$userProps['COST_USER_PROP']];
                    }
                } else {
                    $costAdsCount = 0;
                    if (!empty($this->arResult['USER_ADS'][$userProps['NAME']]['COST_ADS'])) {
                        foreach ($this->arResult['USER_ADS'][$userProps['NAME']]['COST_ADS'] as $rateAds) {
                            $costAdsCount += $rateAds['COUNT'];
                        }
                    }
                    $this->arResult['COUNTER'][$userProps['NAME']]['USED'] =
                        $costAdsCount + $this->arResult['USER_ADS'][$userProps['NAME']]['FREE_ADS_COUNT'];


                    $this->arResult['COUNTER'][$userProps['NAME']]['POSSIBLE'] =
                        $user[$userProps['FREE_USER_PROP']] + $rateLimits[$userProps['NAME']];
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
                'cache' => [
                    'ttl' => 360000,
                    'cache_joins' => true
                ]
            ))->fetch();

            if (!empty($user)) {
                $userRates = $this->getUserRates();
                $this->getUserAds($userRates);
                $this->setUserCounters($user, $userRates);
            }
        }
    }

    private function getActiveUserAds() : array
    {
        $cache = \Bitrix\Main\Data\Cache::createInstance(); // Служба кеширования
        $taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache(); // Служба пометки кеша тегами
        $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();

        $userAds = [];
        $cacheTtl = 360000000;
        $cachePath = 'user_ads_counter';
        $cacheId = 'user_ads_counter_'.$userId;

        if ($cache->initCache($cacheTtl, $cacheId, $cachePath)) {
            $userAds = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            // Начинаем записывать теги
            $taggedCache->startTagCache($cachePath);
            foreach ($this->iblocks as $iblockId) {
                $taggedCache->registerTag("iblock_id_".$iblockId);
            }
            $taggedCache->endTagCache();

            $select = [
                'ID',
                'IBLOCK_ID',
                'NAME',
                'ACTIVE_TO',
            ];

            $selectUserProps = [
                'ID_USER',
                'FREE_AD',
            ];

            $query = \Bitrix\Iblock\ElementTable::query()
                ->setSelect(array_merge($select,$selectUserProps))
                ->setFilter([
                    'IBLOCK_ID' => $this->iblocks,
                    'ACTIVE' => 'Y',
                    'ID_USER' => \Bitrix\Main\Engine\CurrentUser::get()->getId(),
                    '!FREE_AD' => false
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

            $userAds = $query->exec()->fetchAll();
            $cache->endDataCache($userAds);
        }

        return $userAds;
    }

    public function getUserAds(array $userRates) : void
    {
        if (\Bitrix\Main\Loader::includeModule('highloadblock') && \Bitrix\Main\Loader::includeModule('iblock')) {

            // Получаем платные объявления
            if (!empty($userRates)) {
                foreach ($userRates as $key => $rate) {
                    $this->arResult['USER_ADS'][$rate['UF_TYPE']]['COST_ADS'][$key]['DATE_EXPIRED'] = $rate['UF_DATE_EXPIRED'];
                    $this->arResult['USER_ADS'][$rate['UF_TYPE']]['COST_ADS'][$key]['LIMIT'] = $rate['UF_COUNT_REMAIN'];

                    if (!empty($rate['UF_ID_ANONC']))
                        $this->arResult['USER_ADS'][$rate['UF_TYPE']]['COST_ADS'][$key]['COUNT'] += count($rate['UF_ID_ANONC']);
                }
            }

            // Получаем бесплатные объявления пользователей
            $freeAds = $this->getActiveUserAds();
            if (!empty($freeAds)) {
                foreach ($freeAds as $item) {
                    $this->arResult['USER_ADS'][$this->adsIblocksData[$item['IBLOCK_ID']]['NAME']]['FREE_ADS'][] = $item['ID'];
                    $this->arResult['USER_ADS'][$this->adsIblocksData[$item['IBLOCK_ID']]['NAME']]['FREE_ADS_COUNT'] += 1;
                    $this->arResult['USER_ADS'][$this->adsIblocksData[$item['IBLOCK_ID']]['NAME']]['FREE_DATE_EXPIRED'] = $item['ACTIVE_TO'];
                }
            }

        }
    }

    public function executeComponent()
    {
        $this->getUserCountAdsAndLimits();
        $this->includeComponentTemplate();
    }
}
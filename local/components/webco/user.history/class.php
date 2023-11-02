<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class UserHistory extends \CBitrixComponent
{
    private object $nav;
    public function setUserHistory() : void
    {
        if (\Bitrix\Main\Loader::includeModule('highloadblock')) {
            $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
            $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(USER_BUY_HISTORY_HL_ID)->fetch();
            $userHistoryClass = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock)->getDataClass();

            $nav = new \Bitrix\Main\UI\PageNavigation("history");
            $maxPageElements = !empty($this->arParams['MAX_PAGE_ELEMENTS']) ? $this->arParams['MAX_PAGE_ELEMENTS'] : 20;

            $nav->allowAllRecords(false)
                ->setPageSize($maxPageElements)
                ->initFromUri();

            $historyRes = $userHistoryClass::getList(array(
                'order' => array('ID' => 'DESC'),
                'select' => array('*'),
                'filter' => array('UF_USER_ID'=> $userId),
                "count_total" => true,
                "offset" => $offset = $nav->getOffset(),
                "limit" => $nav->getLimit(),
                'cache' => [
                    'ttl' => 86400,
                    'cache_joins' => true
                ]
            ));

            $count = $historyRes->getCount();
            $nav->setRecordCount($count);
            $this->nav = $nav;

            $history = $historyRes->fetchAll();
            $this->arResult['HISTORY'] = $history ? $history : [];
        }
    }

    public function executeComponent()
    {
        global $APPLICATION;
        $this->setUserHistory();
        $this->includeComponentTemplate();
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


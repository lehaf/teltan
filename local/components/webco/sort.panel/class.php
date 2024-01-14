<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class SortPanel extends \CBitrixComponent
{
    protected object $post;
    private object $session;

    public function setViews() : void
    {
        if (!empty(!empty($this->arParams['VIEWS']))) {
            $viewsSet = $this->arParams['VIEWS'];

            if (!$this->session->has('view') || empty($this->session->get('view'))) {
                $defaultView = array_key_first($viewsSet);
                if (!empty($defaultView)) {
                    $this->session->set('view',$defaultView);
                }
            }

            if ($this->post->get('isAjax') === 'y' && !empty($this->post->get('typeOfView')) &&
                !empty($viewsSet[$this->post->get('typeOfView')])) {
                $this->session->set('view', $this->post->get('typeOfView'));
            }

            if ($this->session->has('view') || empty($this->session->get('view'))) {
                $curView = $this->session->get('view');
                $viewsSet[$curView]['ACTIVE'] = 'Y';
            }

            $this->arResult['VIEWS'] = $viewsSet;
        }
    }

    public function setSorts() : void
    {
        if (!empty($this->arParams['SORTS'])) {
            $sortsSet = $this->arParams['SORTS'];

            if (!$this->session->has('sort') || empty($this->session->get('sort'))) {
                if (!empty($sortsSet[0])) {
                    $this->session->set('sort', $sortsSet[0]);
                }
            }

            if ($this->post->get('isAjax') === 'y' && !empty($sortsSet[$this->post->get('sortNumber')])) {
                $this->session->set('sort', $sortsSet[$this->post->get('sortNumber')]);
            }

            if ($this->session->has('sort') && !empty(array_search($this->session->get('sort'), $sortsSet)) || empty($this->session->get('sort'))) {
                $curSort = $this->session->get('sort');
                $this->arResult['SORT_TEXT'] = $curSort['NAME'];
                $curSortKey = array_search($curSort, $sortsSet);
                $sortsSet[$curSortKey]['ACTIVE'] = 'Y';
            } else {
                if (!empty($sortsSet[0])) {
                    $this->arResult['SORT_TEXT'] = $sortsSet[0]['NAME'];
                    $this->session->set('sort', $sortsSet[0]);
                    $sortsSet[0]['ACTIVE'] = 'Y';
                }
            }

            $this->arResult['SORTS'] =  $sortsSet;
        }
    }

    public function prepareResult() : void
    {
        $this->post = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
        $this->session = \Bitrix\Main\Application::getInstance()->getSession();
        $this->setViews();
        $this->setSorts();
    }

    public function executeComponent()
    {
        $this->prepareResult();
        if (!empty($this->arParams['ELEMENTS_EXIST'])) $this->includeComponentTemplate();

    }
}


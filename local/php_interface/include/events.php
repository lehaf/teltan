<?php

AddEventHandler("main", "OnBuildGlobalMenu", "ModifiAdminMenu");
AddEventHandler("main", "OnBeforeProlog", "setUserLastActivityDate");

function ModifiAdminMenu(&$adminMenu, &$moduleMenu){
    $moduleMenu[] = array(
        "parent_menu" => "global_menu_content",
        "section" => "Настройки сайта",
        "sort"        => 1000,
        "url"         => "/bitrix/admin/bxk_site_settings.php",
        "text"        => 'Настройки сайта',
        "title"       => '',
        "icon"        => "form_menu_icon",
        "page_icon"   => "form_page_icon",
        "items_id"    => "menu_price",
        "items"       => array()

    );
}

function setUserLastActivityDate() {
    global $USER;
    if ($USER->IsAuthorized()) {
        CUser::SetLastActivityDate($USER->GetID());
    }
}


AddEventHandler("main", "OnAfterUserAdd", array("MyClass", "OnAfterUserAddHandler"));
AddEventHandler("iblock", "OnAfterIBlockElementDelete", array("MyClass", "OnAfterIBlockElementDeleteHandler"));

class MyClass
{
    public static function OnAfterIBlockElementDeleteHandler($arFields)
    {
        $hlbl = 5;
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($hlbl)->fetch();

        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $rsData = $entity_data_class::getList(array(
            "select" => array("*"),
            "order" => array("ID" => "ASC"),
            "filter" => array("UF_ID_AD" => $arFields['ID'])  // Задаем параметры фильтра выборки
        ));

        while ($arData = $rsData->Fetch()) {
            $entity_data_class::Delete($arData['ID']);
        }
    }

    // создаем обработчик события "OnAfterUserAdd"
    function OnAfterUserAddHandler(&$arFields)
    {
        $user = new CUser;
        $fields = array(
            "UF_FREE_PROPERTY" => 1,
            "UF_FREE_AUTO" => 1,
            "UF_FREE_FLEA" => 1,
            "UF_AVAILABLE_PROPERTY" => 1,
            "UF_AVAILABLE_AUTO" => 1,
            "UF_AVAILABLE_FLEA" => 1,
        );
        $user->Update($arFields['ID'], $fields);
    }
}
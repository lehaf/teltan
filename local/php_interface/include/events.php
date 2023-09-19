<?

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
?>
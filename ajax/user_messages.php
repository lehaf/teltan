<?php

if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
    echo $userId > 0 ? getCountUnreadMessages($userId) : 0;
}


<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$arEventFields = array(
"REGISTER_LINK" => '/auctions/invite-register/?email=' . $_POST['email'] . '&auction=' . $_POST['auctionId'],
"EMAIL" =>$_POST['email'],
);
CEvent::Send("ADV_CONTRACT_INFO", 's1', $arEventFields);
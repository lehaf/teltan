<?php

/** @var AuctionBidding $Auction */
/** @var array $arResult */
/** @var $request */


$userID = \Bitrix\Main\Engine\CurrentUser::get()->getId();

// список ставок пользователей
$ratesList = $Auction->getRatesList($userID, 4);

$arResult = [
	'result'    => 'ok',
	'ratesList' => $ratesList,
];




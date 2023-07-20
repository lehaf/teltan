<?php

/** @var AuctionBidding $Auction */
/** @var array $arResult */
/** @var $request */

//$arData = [
//	'APPS_START' => $Auction->AUCTION['APPS_DATE_START'] . ' ' . $Auction->AUCTION['APPS_TIME_START'],
//	'APPS_END' => $Auction->AUCTION['APPS_DATE_END'] . ' ' . $Auction->AUCTION['APPS_TIME_END'],
//	'AUCTION_START' => $Auction->AUCTION['AUCTION_DATE_START'] . ' ' . $Auction->AUCTION['AUCTION_TIME_START'],
//	'AUCTION_END' => $Auction->AUCTION['AUCTION_DATE_END'] . ' ' . $Auction->AUCTION['AUCTION_TIME_END'],
//	'FINISHED' => $Auction->AUCTION['FINISHED'],
//];
$USER_ID = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$USER_TIME_ZONE = getUserTimeZone($USER_ID);
$timeZone = new \DateTimeZone($USER_TIME_ZONE);
$objDateTimeNow = new \Bitrix\Main\Type\DateTime();
$objDateTimeNow->setTimeZone($timeZone);

$obj1 = new \Bitrix\Main\Type\DateTime($Auction->AUCTION['APPS_DATE_START']);

$arData = [
	'objDateTimeNow' => $objDateTimeNow,
//	'USER_TIME_ZONE' => null,
	'USER_TIME_ZONE' => $USER_TIME_ZONE,
	'APPS_START' => $Auction->AUCTION['APPS_DATE_START'],
	'APPS_END' => $Auction->AUCTION['APPS_DATE_END'],
	'AUCTION_START' => $Auction->AUCTION['AUCTION_DATE_START'],
	'AUCTION_END' => $Auction->AUCTION['AUCTION_DATE_END'],
	'FINISHED' => $Auction->AUCTION['FINISHED'],
];

list($auctionState, $dataFinish, $dataFinishTs) = $Auction->getAuctionState($arData);

//pr($Auction->AUCTION);
$arResult['arData'] = $arData;
$arResult['timeZone'] = $timeZone;
$arResult['auctionState'] = $auctionState;
if ($auctionState==$Auction::AUCTION_STATE_BIDDING_IN_PROCESS)
{
	$firstCheck = $request->getPost('firstCheck');

	list($nextRateValue, $nextRateValuePrint) = $Auction->getNextRateValue();

	$currentPrice = floatval($Auction->AUCTION['CURRENT_PRICE']);
	$currentPricePrint = $Auction->printPrice($Auction->AUCTION['CURRENT_PRICE'], $Auction->AUCTION['CURRENCY']);

	$lastRateInfo = $Auction->getLastRateInfo();
	$lastRateID = !empty($lastRateInfo['ID'])?intval($lastRateInfo['ID']):0;
	$lastRateUserID = !empty($lastRateInfo['CREATED_BY'])?intval($lastRateInfo['CREATED_BY']):0;

	if ($firstCheck == 1)
	{
		$userID = intval(\Bitrix\Main\Engine\CurrentUser::get()->getId());

		// получаем
		$lastRateInfo = $Auction->getLastRateInfo($userID);
		$lastRateIdUser = !empty($lastRateInfo['ID'])?intval($lastRateInfo['ID']):0;
	}
	else
	{
		$lastRateIdUser = -1;
	}

	$arResult = [
		'result'                => 'ok',
		'dataFinish'            => $dataFinish,     // время окончания торгов
		'dataFinishTs'          => $dataFinishTs,   // ts окончания торгов
		'currentPrice'          => $currentPrice,   // текущая цена
		'currentPricePrint'     => $currentPricePrint,   // текущая цена
		'nextRateValue'         => $nextRateValue,   // размер след. ставка
		'nextRateValuePrint'    => $nextRateValuePrint,   // размер след. ставка
		'lastRateID'            => $lastRateID,    // id записи крайней ставки
		'lastRateUserID'        => $lastRateUserID,   // id пользователя записи крайней ставки
		'lastRateIdUser'        => $lastRateIdUser,   // id записи крайней ставки текущего пользователя
	];

	// список ставок пользователей
//	$arResult['ratesList'] = $Auction->getRatesList();

}

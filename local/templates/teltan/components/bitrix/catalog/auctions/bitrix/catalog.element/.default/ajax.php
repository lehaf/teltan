<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/classes/AuctionBidding.php';

Bitrix\Main\Loader::includeModule("iblock");

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$ID = $request->getPost('ID');
$IBLOCK_ID_AUCTION = $request->getPost('IBLOCK_ID_AUCTION');
$IBLOCK_ID_RATES = $request->getPost('IBLOCK_ID_RATES');
$TASK = $request->getPost('TASK');

$Auction = new AuctionBidding($ID, $IBLOCK_ID_AUCTION, $IBLOCK_ID_RATES);

$arResult = ['result'=>'error'];

if (empty($Auction->AUCTION))
{
	$arResult['message'] = 'Аукцион на найден';
	echo \Bitrix\Main\Web\Json::encode($arResult);
	die;
}
switch ($TASK)
{
	case 'checkState':
		include 'tasks/checkState.php';
		break;

	case 'setRate':
		include 'tasks/setRate.php';
		break;

	case 'getRatesList':
		include 'tasks/getRatesList.php';
		break;

	case 'buyAuction':
		include 'tasks/buyAuction.php';
		break;

	case 'surrender':
		include 'tasks/surrender.php';
		break;

}

echo \Bitrix\Main\Web\Json::encode($arResult);

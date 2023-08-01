<?php
/** @var AuctionBidding $Auction */
/** @var array $arResult */
/** @var $request */

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/classes/AuctionBidding.php';

Bitrix\Main\Loader::includeModule("pull");

$rateValue = $request->getPost('rateValue');


$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();

if (check_bitrix_sessid() && !empty($ID) && !empty($rateValue))
{
	if ($Auction->AUCTION['CURRENT_PRICE'] >= $rateValue && $Auction->AUCTION['TRADE_TYPE_ENUM_ID'] == 34 ||
		$Auction->AUCTION['CURRENT_PRICE'] <= $rateValue && $Auction->AUCTION['TRADE_TYPE_ENUM_ID'] == 35)
	{
		$arResult['message'] = 'Ошибка ставки. ' . $Auction->AUCTION['CURRENT_PRICE'] . ' ' . $rateValue ;
	}
	elseif($Auction->canMakeRates())
	{
		// делаем ставку
		$rateValue = floatval(str_replace([' ', ','], ['', '.'], $rateValue));

		if ($lastRateIdUser = $Auction->setRate($userId, $rateValue))
		{
			// ставка сохранена

			$arResult = [
				'result'         => 'ok',
				'lastRateIdUser' => $lastRateIdUser,
			];

			$res = \CPullStack::AddShared(Array(
				'module_id' => 'auctions',
				'command' => 'new_rate',
				'params' => [
					'AUCTION_DATE_END' => $Auction->AUCTION['AUCTION_DATE_END'],
					'AUCTION_DATE_END_TS' => $Auction->AUCTION['AUCTION_DATE_END_TS'],
				],
			));
		}
		else
		{
			if (!empty($Auction->errorMessage)) $arResult['message'] = $Auction->errorMessage;
				else $arResult['message'] = 'Ошибка добавления ставки.';
		}

	}
	else
	{
		$arResult['message'] = 'Нельзя делать ставку.';
	}

}




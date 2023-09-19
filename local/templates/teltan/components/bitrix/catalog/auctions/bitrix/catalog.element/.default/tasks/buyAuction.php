<?php
/** @var AuctionBidding $Auction */
/** @var array $arResult */
/** @var $request */

$BUY_AGREE = $request->getPost('BUY_AGREE');


$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
//die();
if (check_bitrix_sessid() && !empty($ID) && !empty($BUY_AGREE))
{
	if ($Auction->buy($userId, $BUY_AGREE))
	{
		$arResult = [
			'result' => 'ok',
			'reloadPage' => 1,
		];
//		$arResult['message'] = 'Ошибка ставки. ' . $Auction->AUCTION['CURRENT_PRICE'] . ' ' . $rateValue ;
	}
	else
	{
		$arResult['message'] = !empty($Auction->errorMessage) ? $Auction->errorMessage : '';
	}

}




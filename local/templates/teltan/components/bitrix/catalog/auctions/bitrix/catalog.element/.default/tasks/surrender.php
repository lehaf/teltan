<?php
/** @var AuctionBidding $Auction */
/** @var array $arResult */
/** @var $request */


if (check_bitrix_sessid() && !empty($ID))
{
	$Auction->finalize();
	$res = \CPullStack::AddShared(Array(
		'module_id' => 'auctions',
		'command' => 'reload_page',
		'params' => ['RELOAD' => 'Y'],
	));
	$arResult = [
		'result' => 'ok',
	];
}




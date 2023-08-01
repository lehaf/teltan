<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

if (!empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;

	if (!empty($templateData['CURRENCIES']))
	{
		$loadCurrency = Loader::includeModule('currency');
	}

	/*CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
		?>
		<script>
			BX.Currency.setCurrencies(<?=$templateData['CURRENCIES']?>);
		</script>
		<?
	}*/
}

/*if (isset($templateData['JS_OBJ']))
{
	?>
	<script>
		BX.ready(BX.defer(function(){
			if (!!window.<?=$templateData['JS_OBJ']?>)
			{
				window.<?=$templateData['JS_OBJ']?>.allowViewedCount(true);
			}
		}));
	</script>

	<?
}*/


$arWsUsers = [
	1,  // admin
];

?>
<?php // метка времени для работы счетчика времени ?>
<?/*<script>
    var serverTimeStamp = <?= time().'000' ?>,
        viaWs = <?= in_array($USER->GetID(), $arWsUsers)?1:0 ?>;
        viaWs = <?= $USER->IsAuthorized()?1:0 ?>;
</script>*/?>
<script>
    var serverTimeStamp = <?= time().'000' ?>,
        viaWs = <?= $USER->IsAuthorized()?1:0 ?>;
</script>

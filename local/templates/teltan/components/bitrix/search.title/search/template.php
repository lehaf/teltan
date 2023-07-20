<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if($INPUT_ID == '')
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if($CONTAINER_ID == '')
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
    <div class="mt-3 mt-xl-0 col-12 col-xl order-3 order-xl-2 search-input-main" id="<?=$CONTAINER_ID?>">
	<form class="mr-0 mr-xl-3" action="<?=$arResult["FORM_ACTION"]?>">
        <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn btn-primary btn-on-search" type="submit" id="button-addon1">
                    <i class="icon-magnifying-glass-1"></i>
                </button>
            </div>
		    <input placeholder="<?=Loc::getMessage('CT_BST_SEARCH_BUTTON')?>" class="form-control" id="<?=$INPUT_ID?>" type="text" name="q" value="<?=$_GET['q'];?>" size="40" maxlength="50" autocomplete="off" />
        </div>
    </form>
	</div>
<?endif?>
<script>
	BX.ready(function(){
		new JCTitleSearch({
			'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
			'INPUT_ID': '<?echo $INPUT_ID?>',
			'MIN_QUERY_LEN': 3
		});
	});
</script>

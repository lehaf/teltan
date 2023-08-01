<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;

Loc::loadMessages($_SERVER['DOCUMENT_ROOT'] . '/local/templates/p2a/common_messages.php');

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/helpers/FormHelper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/classes/AuctionBase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/classes/AuctionBidding.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/classes/AuctionParticipation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/helpers/TeamHelper.php';

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 * @var array $arParams
 * @var array $arResult
 *
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();


include $_SERVER['DOCUMENT_ROOT']. SITE_TEMPLATE_PATH . '/components/bitrix/catalog.section.list/tile/include/_lang-modifier.php';

if (SITE_ID != 's1')
{
	$langName = "NAME_" . mb_strtoupper(LANGUAGE_ID);
	$langField = "UF_NAME_" . mb_strtoupper(LANGUAGE_ID);

	$arSelect = ['ID', 'IBLOCK_ID', 'XML_ID', 'NAME'];
	$arSelect["{$langName}_"] = $langName;

	$arTranslatePropNames = [];
	$arTranslateRefs = [];


	if (!empty($arResult['DISPLAY_PROPERTIES']))
	{
		$arPropIds = $arTableNames = [];

		foreach ($arResult['DISPLAY_PROPERTIES'] as $arProp)
		{
			$arPropIds[$arProp['ID']] = $arProp['CODE'];

			if ($arProp['USER_TYPE'] == 'directory')
				$arTableNames[$arProp['ID']] = $arProp['USER_TYPE_SETTINGS']['TABLE_NAME'];
		}

		// получаем переводы по значениям справочника
		foreach ($arTableNames as $propId=>$tableName)
		{
			if (!array_key_exists($tableName, $arTranslateRefs))
			{
				$_arItems = getDataFromReference($tableName, ['*'], 'UF_XML_ID',[], [],1);

				if (count($_arItems))
				{
					reset($_arItems);
					$_arItem = current($_arItems);
					if (!array_key_exists($langField, $_arItem)) $langField = 'UF_NAME';
				}


				$_arItems = getDataFromReference($tableName, ['UF_XML_ID', $langField], 'UF_XML_ID');

				$arTranslateRefs[$tableName] = [];

				foreach ($_arItems as $_arItem)
					$arTranslateRefs[$tableName][$_arItem['UF_XML_ID']] = $_arItem[$langField];
			}
		}

		foreach ($arPropIds as $propId=>$propCode)
		{
			if (!array_key_exists($propId, $arTranslatePropNames))
			{
				$iblock = \Bitrix\Iblock\Iblock::wakeUp(IBLOCK_ID_CONFIGURATOR_AUCTIONS_FIELD_GROUPS)->getEntityDataClass();
				$rsFields = $iblock::getList(array(
					'filter' => [
						'IBLOCK_ID' => IBLOCK_ID_CONFIGURATOR_AUCTIONS_FIELD_GROUPS,
						'XML_ID' => $propId,
					],
					'select' => $arSelect,
					'order' => ['SORT'=>'ASC']
				));

				if($arField = $rsFields->fetch())
				{
					$arTranslatePropNames[$arField['XML_ID']] = $arField;
				}
			}

			if (array_key_exists($propId, $arTranslatePropNames))
			{
				if (!empty($arTranslatePropNames[$propId]["{$langName}_VALUE"]))
				{
					$arResult['DISPLAY_PROPERTIES'][$propCode]['NAME'] = $arTranslatePropNames[$propId]["{$langName}_VALUE"];
					$arResult['DISPLAY_PROPERTIES'][$propCode]['TRANSLATED'] = 'Y';
				}
			}
		}

		foreach ($arResult['DISPLAY_PROPERTIES'] as &$arProperty)
		{
			// переводим значения типа справочник
			if ($arProperty['USER_TYPE'] == 'directory' && array_key_exists($arProperty['USER_TYPE_SETTINGS']['TABLE_NAME'], $arTranslateRefs))
			{
				if (!empty($arProperty['VALUE']))
				{
					$arValue = [];

					foreach ($arProperty['VALUE'] as $value)
					{
						if (!empty($arTranslateRefs[$arProperty['USER_TYPE_SETTINGS']['TABLE_NAME']][$value]))
							$arValue[] = $arTranslateRefs[$arProperty['USER_TYPE_SETTINGS']['TABLE_NAME']][$value];
					}

					if(!empty($arValue))
						$arProperty['DISPLAY_VALUE'] = count($arValue)>1 ? $arValue : $arValue[0];
				}
			}
			elseif($arProperty['PROPERTY_TYPE'] == 'L')
			{
				$_langKey = mb_strtoupper(str_replace('-', '_', $arProperty['CODE']) . '_' . str_replace('-', '_', $arProperty['VALUE_XML_ID']));
				if ($_val = Loc::getMessage($_langKey))
				{
					$arProperty['VALUE'] = $arProperty['DISPLAY_VALUE'] = $_val;
				}
//				else
//				{
//					pr($arProperty);
//				}
//				pr($_langKey);
			}
			elseif ($arProperty['PROPERTY_TYPE'] == 'N' && $arProperty['USER_TYPE'] == 'SASDCheckboxNum')
			{
				$arProperty['DISPLAY_VALUE'] = $arProperty['VALUE']==1 ? Loc::getMessage("VALUE_YES") : Loc::getMessage("VALUE_NO");
			}
//			else
//			{
//				pr($arProperty);
//			}

//			if ($arProperty['NAME'] == 'Класс автомобиля')
//			{
//				pr($arProperty);
//			}

			// пробуем перевести то, что осталось (название св-ва)
			if ($arProperty['TRANSLATED'] == 'Y') continue;

			if ($val = Loc::getMessage($arProperty['CODE']))
			{
//				pr($arProperty['NAME']. ' - ' . $val);
				$arProperty['NAME'] = $val;
			}
			elseif($arProperty['NAME'] == 'Комментарий')
			{
				$arProperty['NAME'] = Loc::getMessage('COMMENT_LABEL');
			}
//			else
//			{
//				pr($arProperty['NAME']. ' - ' . $arProperty['CODE']);
//			}
		}
		unset($arProperty);
	}
}

$AuctionBidding = new AuctionBidding($arResult['ID'] , $arParams['IBLOCK_ID'], IBLOCK_ID_AUCTION_RATES);
$AuctionParticipation = new AuctionParticipation();

// получаем часовой пояс пользователя
$arResult['USER_TIME_ZONE'] = getUserTimeZone($arParams['USER_ID']);

$arResult['IS_TEAM_MEMBER'] = TeamHelper::getUserTeamMember();
if ($arResult['IS_TEAM_MEMBER'])
{
	$arResult['USER_ID'] = TeamHelper::getAccountId($arParams['USER_ID']);

	// получаем данные по члену команды
	$arSelect = Array("ID", "IBLOCK_ID", "NAME");
	$arFilter = Array("IBLOCK_ID"=>IBLOCK_ID_TEAM_MEMBERS, "XML_ID"=>$arParams['USER_ID']);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	if($ob = $res->GetNextElement())
	{
		$arFields     = $ob->GetFields();
		$teamMemberId = $arFields['ID'];
	}
}
else
{
	$arResult['USER_ID'] = $arParams['USER_ID'];
}


if (!empty($arResult['PROPERTIES']['DOCUMENTS']['VALUE']))
	$arResult['DISPLAY_PROPERTIES']['DOCUMENTS'] = CIBlockFormatProperties::GetDisplayValue($arResult, $arResult['PROPERTIES']['DOCUMENTS'], "news_out");


$arResult['LOCATION_DATA'] = [];
if (!empty($arResult['DISPLAY_PROPERTIES']['REGION_REF']['DISPLAY_VALUE']))
{
	$arResult['LOCATION_DATA'][] = $arResult['DISPLAY_PROPERTIES']['REGION_REF']['DISPLAY_VALUE'];
	unset($arResult['DISPLAY_PROPERTIES']['REGION_REF']);
}

if (!empty($arResult['DISPLAY_PROPERTIES']['COUNTRY_REF']['DISPLAY_VALUE']))
{
	$arResult['LOCATION_DATA'][] = $arResult['DISPLAY_PROPERTIES']['COUNTRY_REF']['DISPLAY_VALUE'];
	unset($arResult['DISPLAY_PROPERTIES']['COUNTRY_REF']);
}

if (!empty($arResult['DISPLAY_PROPERTIES']['CITY_REF']['DISPLAY_VALUE']))
{
	$arResult['LOCATION_DATA'][] = $arResult['DISPLAY_PROPERTIES']['CITY_REF']['DISPLAY_VALUE'];
	unset($arResult['DISPLAY_PROPERTIES']['CITY_REF']);
}

$arResult['SELLER_INFO'] = FormHelper::getUserProfileInfo($arResult['CREATED_BY']);
$arResult['USER_INFO'] = FormHelper::getUserProfileInfo($arResult['USER_ID']);


if (empty($arResult['DISPLAY_PROPERTIES']['CURRENT_PRICE']['DISPLAY_VALUE']))
	$arResult['DISPLAY_PROPERTIES']['CURRENT_PRICE']['DISPLAY_VALUE'] = $arResult['DISPLAY_PROPERTIES']['START_PRICE_REQUIRED']['DISPLAY_VALUE'];


$CURRENCY = $arResult['DISPLAY_PROPERTIES']['CURRENCY_REQUIRED']['DISPLAY_VALUE'];
$START_PRICE = $arResult['DISPLAY_PROPERTIES']['START_PRICE_REQUIRED']['DISPLAY_VALUE'];
$CURRENT_PRICE = $arResult['DISPLAY_PROPERTIES']['CURRENT_PRICE']['DISPLAY_VALUE'];

unset($arResult['DISPLAY_PROPERTIES']['CURRENCY_REQUIRED']);
unset($arResult['DISPLAY_PROPERTIES']['START_PRICE_REQUIRED']);


$arResult['PRINT_START_PRICE'] = $AuctionBidding->printPrice($START_PRICE, $CURRENCY);
$arResult['PRINT_CURRENT_PRICE'] = $AuctionBidding->printPrice($CURRENT_PRICE, $CURRENCY);
$arResult['CURRENCY'] = $CURRENCY;


// шаг аукциона
if ($arResult['DISPLAY_PROPERTIES']['TRADE_TYPE_REQUIRED']['VALUE_XML_ID'] == 'bidding-up')
{
	if ($arResult['DISPLAY_PROPERTIES']['STEP_TYPE_REQUIRED']['VALUE_XML_ID'] == 'percent')
	{
		// процент
		$arResult['STEP_VALUE'] = $arResult['DISPLAY_PROPERTIES']['STEP_VALUE_REQUIRED']['DISPLAY_VALUE'] . '%';
		$arResult['NEXT_STEP_VALUE'] = $CURRENT_PRICE + ($START_PRICE / 100 * $arResult['DISPLAY_PROPERTIES']['STEP_VALUE_REQUIRED']['DISPLAY_VALUE']);
	}
	else
	{
		// money
		$arResult['STEP_VALUE'] = $AuctionBidding->printPrice($arResult['DISPLAY_PROPERTIES']['STEP_VALUE_REQUIRED']['DISPLAY_VALUE'], $CURRENCY);
		$arResult['NEXT_STEP_VALUE'] = $CURRENT_PRICE + $arResult['DISPLAY_PROPERTIES']['STEP_VALUE_REQUIRED']['DISPLAY_VALUE'];
	}
}
else
{
	if ($arResult['DISPLAY_PROPERTIES']['STEP_TYPE_REQUIRED']['VALUE_XML_ID'] == 'percent')
	{
		// процент
		$arResult['STEP_VALUE'] = $arResult['DISPLAY_PROPERTIES']['STEP_VALUE_REQUIRED']['DISPLAY_VALUE'] . '%';
		$arResult['NEXT_STEP_VALUE'] = $CURRENT_PRICE - ($START_PRICE / 100 * $arResult['DISPLAY_PROPERTIES']['STEP_VALUE_REQUIRED']['DISPLAY_VALUE']);
	}
	else
	{
		// money
		$arResult['STEP_VALUE'] = $AuctionBidding->printPrice($arResult['DISPLAY_PROPERTIES']['STEP_VALUE_REQUIRED']['DISPLAY_VALUE'], $CURRENCY);
		$arResult['NEXT_STEP_VALUE'] = $CURRENT_PRICE - $arResult['DISPLAY_PROPERTIES']['STEP_VALUE_REQUIRED']['DISPLAY_VALUE'];
	}
}


$arResult['PRINT_NEXT_STEP_VALUE'] = $AuctionBidding->printPrice($arResult['NEXT_STEP_VALUE'], $CURRENCY);


// получаем кол-во подавших заявки на участие, одобренных оператором
$arResult['PARTICIPATION_COUNT'] = $AuctionParticipation->getCount($arResult['ID'], IBLOCK_ID_AUCTIONS_APPS_PARTICIPATION);

list($arResult['USER_SEND_PARTICIPATION'], $arResult['USER_PARTICIPATION_STATUS']) = $AuctionParticipation->getUserParticipation($arResult['ID'], IBLOCK_ID_AUCTIONS_APPS_PARTICIPATION, $arResult['USER_ID']);

// формирует массив для автоставок
$arResult['AUTO_BIDS_LIST'] = $AuctionBidding->getAutoBidsList();

// список ставок
$arResult['RATES_LIST'] = $AuctionBidding->getRatesList($arResult['USER_ID'], 4);
//var_dump($arResult['PROPERTIES']['APPS_DATE_START_REQUIRED']['VALUE']);

$objDateTimeNow = new \Bitrix\Main\Type\DateTime();
//pr($objDateTimeNow);
//pr($arResult['USER_TIME_ZONE']);
//pr($arResult['TIME_ZONE_OFFSET']);
//$timeOffset = CTimeZone::GetOffset($arParams['USER_ID']);
//$objDateTimeNow->add("{$arResult['TIME_ZONE_OFFSET']} seconds");
$timeZone = new \DateTimeZone($arResult['USER_TIME_ZONE']);
$objDateTimeNow->setTimeZone($timeZone);
$arResult['OBJ_DATE_TIME_NOW'] = $objDateTimeNow;
//$objDateTimeNow->add("$timeOffset seconds");
//pr($objDateTimeNow);
$arData = [
	'objDateTimeNow' => $objDateTimeNow,
	'USER_TIME_ZONE' => $arResult['USER_TIME_ZONE'],
	'APPS_START' => $arResult['PROPERTIES']['APPS_DATE_START_REQUIRED']['VALUE'],
	'APPS_END' => $arResult['PROPERTIES']['APPS_DATE_END_REQUIRED']['VALUE'],
	'AUCTION_START' => $arResult['PROPERTIES']['AUCTION_DATE_START_REQUIRED']['VALUE'],
	'AUCTION_END' => $arResult['PROPERTIES']['AUCTION_DATE_END_REQUIRED']['VALUE'],
	'FINISHED' => $arResult['PROPERTIES']['FINISHED']['VALUE'],
];

list($arResult['AUCTION_STATE'], $arResult['DATA_FINISH'], $arResult['DATA_FINISH_TS']) = $AuctionBidding->getAuctionState($arData);


if ($arResult['AUCTION_STATE'] == $AuctionBidding::AUCTION_STATE_BIDDING_FINISHED)
{
	$arResult['LAST_RATE'] = $AuctionBidding->getLastRateInfo();
}
else
{
	$arResult['LAST_RATE'] = [];
}

foreach ($arResult['MORE_PHOTO'] as &$arItem)
{
	$arFile = CFile::ResizeImageGet($arItem['ID'], Array("width"=>840, "height"=>840), BX_RESIZE_IMAGE_PROPORTIONAL);
	$arItem['SRC'] = $arFile['src'];

}
unset($arItem);

$AuctionBase = new AuctionBase();
$arSkipProps = $AuctionBase->getAuctionsSkipProps();
$arResult['REQUEST_SECTION_INFO'] = $AuctionBase->getSectionInfo($arParams['IBLOCK_ID'], $arResult['IBLOCK_SECTION_ID']);
$arResult['GROUPS_TREE'] = $AuctionBase->getGroupsTree(IBLOCK_ID_CONFIGURATOR_AUCTIONS_FIELD_GROUPS, $arResult['REQUEST_SECTION_INFO']);

foreach ($arResult['GROUPS_TREE'] as &$arGroup)
{
	if (empty($arGroup['NAME'])) continue;

	$arGroup['ITEMS'] = [];

	foreach ($arGroup['FIELDS'] as $propId)
	{
		foreach ($arResult['DISPLAY_PROPERTIES'] as $arProp)
		{
			if ($arProp['ID'] != $propId) continue;

			if (strpos($arProp['CODE'], '_DATE_') !== false && !empty($arProp['DISPLAY_VALUE']))
			{
				$ar = explode('&nbsp;', $arProp['DISPLAY_VALUE']);
				$arProp['DISPLAY_VALUE'] = $ar[0];
			}

			$arGroup['ITEMS'][] = [
				'ID'            => $arProp['ID'],
				'NAME'          => $arProp['NAME'],
				'DISPLAY_VALUE' => $arProp['DISPLAY_VALUE'],
			];
		}
	}
}
unset($arGroup);

<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => 'добавление элемента телтан',
	"DESCRIPTION" => 'добавление элемента телтан',
	"ICON" => "/images/cat_list.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 30,
	"PATH" => array(
		"ID" => "content",
		"CHILD" => array(
			"ID" => "teltan",
			"NAME" => 'добавление элемента телтан',
			"SORT" => 30,
			"CHILD" => array(
				"ID" => "webco+add+teltan",
			),
		),
	),
);

?>
<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"MAX_PAGE_ELEMENTS" => Array(
			"NAME" => 'Кол-во элементов на странице',
			"TYPE" => "STRING",
			"DEFAULT"=>'12',
			"PARENT" => "VISUAL"
		),
		"ACTIVE" => Array(
			"NAME" => 'Какие объявление выводить',
			"TYPE" => "LIST",
			"DEFAULT"=>'Y',
			"VALUES" => [
				'Y' => 'Y',
				'N' => 'N'
			],
			"PARENT" => "VISUAL",
		),

		"CACHE_TIME" => Array(
			"NAME" => "Время кэширования компонента",
			"TYPE" => "STRING",
			"DEFAULT"=>'360000000',
			"PARENT" => "BASE",
		)
	)
);


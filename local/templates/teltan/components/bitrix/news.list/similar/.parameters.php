<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"CATEGORY" => Array(
		"PARENT" => 'VISUAL',
		"NAME" => 'Код категории объявлений',
		"TYPE" => "LIST",
		"VALUES" => array(
			"AUTO",
			"PROPERTY",
			"FLEA"
		),
	),
    "IMG_VIEW" => Array(
        "PARENT" => 'VISUAL',
        "NAME" => 'Отображение картинки',
        "TYPE" => "LIST",
        "DEFAULT" => "FULL",
        "VALUES" => array(
            "FULL" => 'На всю ширину карточки',
            "CONTAINER" => "В собственном контейнере",
        ),
    )
);
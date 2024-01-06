<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "ROOT_SECTION_URL" => Array(
        "PARENT" => 'VISUAL',
        "NAME" => 'Страница со всеми элементами',
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),
    "SHOW_SECTIONS" => Array(
        "PARENT" => 'VISUAL',
        "NAME" => 'Показывать разделы',
        "TYPE" => "LIST",
        "DEFAULT" => "N",
        "VALUES" => array(
            "Y" => 'Да',
            "N" => "Нет",
        ),
    )
);

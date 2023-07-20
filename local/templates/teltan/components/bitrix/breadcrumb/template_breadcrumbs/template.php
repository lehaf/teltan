<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';
ps($arResult);
$strReturn .= '<div class="container-fluid breadcrumb-beckground p-0 mb-3 mb-lg-5" itemprop="http://schema.org/breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb text-primary justify-content-end">';

$itemSize = count($arResult);
krsort($arResult);
$count = 0;
foreach ($arResult as $key => $value){
	$arResult[$count] = $value;
	$count++;
}
ps(get_defined_vars());
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
if($index == 0){
	$strReturn .= '<li class="breadcrumb-item active" aria-current="page">' . $title . '</li>';
}else {
	$strReturn .= '<li class="breadcrumb-item"><a href="' . $arResult[$index]["LINK"] . '">' . $title . '</a></li>';
}
}

$strReturn .= '</ol></nav></div></div>';

return $strReturn;

?>

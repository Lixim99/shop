<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
?>
<?php if($arResult["FILE"] <> ''): ?>
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="banner-text text-center">
            <?include($arResult["FILE"]);?>
        </div>
    </div>
</div>
<?endif?>


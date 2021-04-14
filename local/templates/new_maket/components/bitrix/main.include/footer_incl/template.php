<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?php if($arResult["FILE"] <> ''): ?>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <?include($arResult["FILE"]);?>
            </div>
        </div>
    </div>
<?endif?>


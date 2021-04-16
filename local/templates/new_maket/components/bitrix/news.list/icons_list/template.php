<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
<section id="features" class="features section">
    <div class="container">
        <div class="row">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <div class="col-md-4 col-sm-6 feature text-center">
        <?if (isset($arItem["PROPERTIES"]["ICON_CLASS"]["VALUE"])):?>
            <span class="icon icon-<?=$arItem["PROPERTIES"]["ICON_CLASS"]["VALUE"]?>"></span>
        <?endif;?>
        <?if (isset($arItem['DETAIL_TEXT'])):?>
            <div class="feature-content">
                <h5><?=$arItem['NAME']?></h5>
                <p><?=$arItem['DETAIL_TEXT']?></p>
            </div>
        <?endif;?>
    </div>
<?endforeach;?>
        </div>
    </div>
</section>

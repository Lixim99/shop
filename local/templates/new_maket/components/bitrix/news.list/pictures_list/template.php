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
<section id="works" class="works section no-padding">
    <div class="container-fluid">
        <div class="row no-gutter">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <div class="col-lg-3 col-md-6 col-sm-6 work">
        <a href="<?=$arItem['PREVIEW_PICTURE']["SRC"]?>" class="work-box">
            <img src="<?=$arItem['PREVIEW_PICTURE']["SRC"]?>" alt="">
            <?if (isset($arItem['NAME']) && isset($arItem['PREVIEW_TEXT'])):?>
                <div class="overlay">
                    <div class="overlay-caption">
                        <h5><?=$arItem['NAME']?></h5>
                        <p><?=$arItem['PREVIEW_TEXT']?></p>
                    </div>
                </div>
            <?endif;?>
        </a>
    </div>
<?endforeach;?>
        </div>
    </div>
</section>

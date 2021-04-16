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
<section id="testimonials" class="section testimonials no-padding">
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="flexslider">
                <ul class="slides">
<?foreach($arResult["ITEMS"] as $arItem):
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <li>
        <?if (isset($arItem['PREVIEW_PICTURE']['SRC'])):?>
            <div class="col-md-6">
                <div class="avatar">
                    <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="" class="img-responsive">
                </div>
            </div>
        <?endif;?>
        <?if (isset($arItem["PROPERTIES"]["POSITION"]['VALUE'])
                && isset($arItem["PROPERTIES"]["COMPANY"]['VALUE'])
                && isset($arItem['PREVIEW_TEXT'])):
            $personInfo = "{$arItem["NAME"]}, {$arItem["PROPERTIES"]["POSITION"]['VALUE']}";?>
            <div class="col-md-6">
                <blockquote>
                    <p><?='"' . TruncateText($arItem['PREVIEW_TEXT'], 120) . '"'?></p>
                    <cite class="author">
                        <?=$personInfo .= (isset($arItem["PROPERTIES"]["COMPANY"]['VALUE']))? "AT {$arItem["PROPERTIES"]["COMPANY"]['VALUE']}": ''?>
                    </cite>
                </blockquote>
            </div>
        <?endif;?>
    </li>
<?endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</section>
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
<section id="teams" class="section teams">
    <div class="container">
        <div class="row">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
    $photoPath = CFile::GetPath($arItem['PROPERTIES']['PHOTO']['VALUE']);
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <div class="col-md-3 col-sm-6">
        <div class="person">
            <img src="<?=$photoPath?>" alt="" class="img-responsive">
            <div class="person-content">
                <h4><?=$arItem['NAME']?></h4>
                <h5 class="role"><?=$arItem['PROPERTIES']['POSITION']['VALUE']?></h5>
                <p><?=$arItem['PREVIEW_TEXT']?></p>
            </div>
            <ul class="social-icons clearfix">
                <?for ($i = 0; $i < count($arItem['PROPERTIES']['USER_LINKS']['VALUE']); $i++) :?>
                    <?if (isset($arItem['PROPERTIES']['USER_LINKS']['VALUE'][$i])
                            && isset($arItem['PROPERTIES']['USER_LINKS']['DESCRIPTION'][$i])):?>
                        <li>
                            <a href="<?=$arItem['PROPERTIES']['USER_LINKS']['DESCRIPTION'][$i]?>">
                                <span class="fa fa-<?=strtolower($arItem['PROPERTIES']['USER_LINKS']['VALUE'][$i])?>"></span>
                            </a>
                        </li>
                    <?endif;?>
                <?endfor;?>
            </ul>
        </div>
    </div>
<?endforeach;?>
        </div>
    </div>
</section>
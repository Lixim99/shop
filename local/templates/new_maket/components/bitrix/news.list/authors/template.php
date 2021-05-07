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
<?if (!empty($arResult["ITEMS"])):?>
<section id="teams" class="section teams">
    <div class="container">
        <div class="row">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="col-md-3 col-sm-6">
                <div class="person">
                    <?if (!empty($arItem['PREVIEW_PICTURE']['SRC'])):?>
                        <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="" class="img-responsive">
                    <?endif;?>
                    <div class="person-content">
                        <h4><?=$arItem['NAME']?></h4>
                        <?if (!empty($arItem['PROPERTIES']['POSITION']['VALUE'])):?>
                            <h5 class="role"><?=$arItem['PROPERTIES']['POSITION']['VALUE']?></h5>
                        <?endif;?>
                        <?if (!empty($arItem['PREVIEW_TEXT'])):?>
                            <p><?=$arItem['PREVIEW_TEXT']?></p>
                        <?endif;?>
                    </div>
                    <ul class="social-icons clearfix">
                        <?foreach ($arItem['PROPERTIES']['USER_LINKS']['VALUE'] as $index => $USER_LINK):?>
                            <?if (!empty($arItem['PROPERTIES']['USER_LINKS']['DESCRIPTION'][$index])):?>
                                <li>
                                    <a href="<?=$arItem['PROPERTIES']['USER_LINKS']['DESCRIPTION'][$index]?>">
                                        <span class="fa fa-<?=strtolower($USER_LINK)?>"></span>
                                    </a>
                                </li>
                            <?endif;?>
                        <?endforeach;?>
                    </ul>
                </div>
            </div>
        <?endforeach;?>
        </div>
    </div>
</section>
<?endif;?>

<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if (!empty($arResult['ELEMENTS'])) :?>
<section id="features" class="features section">
    <div class="container">
        <div class="row">
            <? foreach ($arResult['ELEMENTS'] as $element) :?>
                <div class="col-md-4 col-sm-6 feature text-center">
                    <span class="icon icon-<?=$element['ICON_VALUE']?>"></span>
                    <?if (isset($element['NAME']) && isset($element['DETAIL_TEXT'])):?>
                        <div class="feature-content">
                            <h5><?=$element['NAME']?></h5>
                            <p><?=$element['DETAIL_TEXT']?></p>
                        </div>
                    <?endif;?>
                </div>
            <?endforeach;?>
        </div>
    </div>
</section>
<?endif;?>

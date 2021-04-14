<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if (!empty($arResult['ELEMENTS'])) :?>
    <section id="works" class="works section no-padding">
        <div class="container-fluid">
            <div class="row no-gutter">
                <?foreach ($arResult['ELEMENTS'] as $element):?>
                    <div class="col-lg-3 col-md-6 col-sm-6 work">
                        <a href="<?=$element['PICTURE']?>" class="work-box">
                            <img src="<?=$element['PICTURE']?>" alt="">
                            <?if (isset($element['TITLE']) && isset($element['TEXT'])):?>
                                <div class="overlay">
                                    <div class="overlay-caption">
                                        <h5><?=$element['TITLE']?></h5>
                                        <p><?=$element['TEXT']?></p>
                                    </div>
                                </div>
                            <?endif;?>
                        </a>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </section>
<?endif;?>

<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if (!empty($arResult['ELEMENTS'])) :?>
    <section id="testimonials" class="section testimonials no-padding">
        <div class="container-fluid">
            <div class="row no-gutter">
                <div class="flexslider">
                    <ul class="slides">
                        <?foreach ($arResult['ELEMENTS'] as $element):?>
                            <li>
                                <?if (isset($element['PHOTO'])):?>
                                    <div class="col-md-6">
                                        <div class="avatar">
                                            <img src="<?=$element['PHOTO']?>" alt="" class="img-responsive">
                                        </div>
                                    </div>
                                <?endif;?>
                                <?if (isset($element['PERSON']) && isset($element['TEXT'])):?>
                                    <div class="col-md-6">
                                        <blockquote>
                                            <p><?='"' . TruncateText($element['TEXT'], 120) . '"'?></p>
                                            <cite class="author">
                                                <?=$element['PERSON']?>
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
<?endif;?>

<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if (!empty($arResult['ELEMENTS'])) :?>
    <section id="teams" class="section teams">
        <div class="container">
            <div class="row">
                <?foreach ($arResult['ELEMENTS'] as $element) :?>
                    <div class="col-md-3 col-sm-6">
                        <div class="person">
                            <img src="<?=$element['PERSONAL_PHOTO']?>" alt="" class="img-responsive">
                            <div class="person-content">
                                <h4><?=$element['NAME']?></h4>
                                <h5 class="role"><?=$element['AUTHOR_POSITION']?></h5>
                                <p><?=$element['TEXT']?></p>
                            </div>
                            <ul class="social-icons clearfix">
                                <?foreach ($element['LINKS'] as $linkName => $ref) :?>
                                    <?if (isset($ref)):?>
                                    <li><a href="<?=$ref?>"><span class="fa fa-<?=strtolower($linkName)?>"></span></a></li>
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

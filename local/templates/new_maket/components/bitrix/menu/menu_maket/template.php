<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
    <div class="header-content clearfix">
        <a class="logo" href="#"><img src="<?=SITE_TEMPLATE_PATH?>/images/logo.png" alt=""></a>
        <nav class="navigation" role="navigation">
            <ul class="primary-nav">
                <?foreach ($arResult as $elem):?>
                    <li><a href="<?=$elem['LINK']?>"><?=$elem['TEXT']?></a></li>
                <?endforeach;?>
            </ul>
        </nav>
        <a href="#" class="nav-toggle">Menu<span></span></a>
    </div>
<?endif;?>


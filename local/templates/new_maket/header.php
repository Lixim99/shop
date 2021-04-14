<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Page\Asset;

global $APPLICATION;
?>
<head>
<?
$APPLICATION->ShowHead();
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/bootstrap.min.css');
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/flexslider.css');
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/jquery.fancybox.css');
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/main.css');
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/responsive.css');
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/animate.min.css');
Asset::getInstance()->addCss('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
Asset::getInstance()
    ->addString("<link rel='apple-touch-icon' sizes='180x180' href='".SITE_TEMPLATE_PATH."/apple-icon-180x180.png'>");
Asset::getInstance()
    ->addString("<link rel=icon' type='image/png' sizes='192x192' href='".SITE_TEMPLATE_PATH."/android-icon-192x192.png'>");
Asset::getInstance()
    ->addString("<link rel='icon' type='image/png' sizes='32x32' href='".SITE_TEMPLATE_PATH."/favicon-32x32.png'>");
Asset::getInstance()
    ->addString("<link rel='icon' type='image/png' sizes='96x96' href='".SITE_TEMPLATE_PATH."/favicon-96x96.png'>");
Asset::getInstance()
    ->addString("<link rel='icon' type='image/png' sizes='16x16' href='".SITE_TEMPLATE_PATH."/favicon-16x16.png'>");

Asset::getInstance()->addJs('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/bootstrap.min.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.flexslider-min.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.fancybox.pack.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.waypoints.min.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/retina.min.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/modernizr.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/main.js');

?>
<title><?$APPLICATION->ShowTitle();?></title>
</head>
<body>
<?$APPLICATION->ShowPanel();?>
<section class="banner" role="banner">
    <header id="header">
        <div class="header-content clearfix">
            <a class="logo" href="#"><img src="<?=SITE_TEMPLATE_PATH?>/images/logo.png" alt=""></a>
            <nav class="navigation" role="navigation">
                <ul class="primary-nav">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#works">Works</a></li>
                    <li><a href="#teams">Our Team</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                    <li><a href="#download">Download</a></li>
                </ul>
            </nav>
            <a href="#" class="nav-toggle">Menu<span></span></a>
        </div>
    </header>

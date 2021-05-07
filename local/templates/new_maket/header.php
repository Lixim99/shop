<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Page\Asset;

global $APPLICATION;
?>
<!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
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
                <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "menu_maket",
                [
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => [],
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "top",
                    "USE_EXT" => "N",
                    "COMPONENT_TEMPLATE" => "menu_maket"
                ],
                false
            );?>
            </header>
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                ".default",
                [
                    "AREA_FILE_SHOW" => "file",
                    "COMPONENT_TEMPLATE" => ".default",
                    "EDIT_TEMPLATE" => "",
                    "PATH" => SITE_TEMPLATE_PATH."/top.php"
                ],
                false
            );?>
        </section>

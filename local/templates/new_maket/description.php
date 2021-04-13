<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arTemplate = [
    "NAME"=>Loc::getMessage('T_DEFAULT_DESC_NAME'),
    "DESCRIPTION"=>Loc::getMessage('T_DEFAULT_DESC_DESC')
];

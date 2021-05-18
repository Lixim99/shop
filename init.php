<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arLoadedClasses = [
    '\\ItBuro\\Handler' => '/local/php_interface/classes/Handler.php'
];

foreach ($arLoadedClasses as $index => $loadedClassPath) {
    if (!file_exists(\Bitrix\Main\Application::getDocumentRoot() . $loadedClassPath)) {
        unset($arLoadedClasses[$index]);
    }
}

if (!empty($arLoadedClasses)) {
    \Bitrix\Main\Loader::registerAutoLoadClasses(null, $arLoadedClasses);
}

if (class_exists(\ItBuro\Handler::class)) {
    \ItBuro\Handler::initEvents();
}

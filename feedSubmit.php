<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main\{Loader, Application};
use \Bitrix\Highloadblock\HighloadBlockTable;

Loader::includeModule('highloadblock');

$arrRequest = Application::getInstance()->getContext()->getRequest()->toArray();
$HLId = array_pop($arrRequest);

if (!empty($HLId) && !empty($arrRequest)) {
    $entityClass = HighloadBlockTable::compileEntity($HLId)->getDataClass();

    $addResult = $entityClass::add($arrRequest);
    $arrError = $addResult->getErrorMessages();
    $ansForUser = (count($arrError) == 0)?'Спасибо за ваше мнение!':implode($arrError);
    echo $ansForUser;
}

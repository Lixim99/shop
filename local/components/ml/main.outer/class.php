<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Main\ORM\Entity;

class MainOuter extends CBitrixComponent
{
    function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }

    function executeComponent()
    {
        echo '<pre>';
        var_dump($this->arParams);
        echo '</pre>';

        Loader::includeModule('iblock');

        Bitrix\Iblock\Iblock::wakeUp($this->arParams);

        $this->includeComponentTemplate();
    }
}
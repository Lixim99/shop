<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;


class IconsOuter extends CBitrixComponent
{
//    public function onPrepareComponentParams($arParams)
//    {
//        return $arParams;
//    }

    public function executeComponent()
    {
        Loader::includeModule('iblock');

        /**
         * @var \Bitrix\Iblock\ElementTable $iblockClass
         */
        $iblockClass =  Bitrix\Iblock\Iblock::wakeUp(5)->getEntityDataClass();

        $arrElements = $iblockClass::query()
            ->setSelect(['ID', 'NAME', 'DETAIL_TEXT', 'ICON_VALUE' => 'ICON_CLASS.VALUE'])
            ->where('ACTIVE', true)
            ->exec()
            ->fetchAll();

         /*
        $arrElements = [];
        while ($element = $elementsRs->fetch()) {

            $arrElements[$element['ID']] = [

            ];
        }
        */

        $this->arResult['ELEMENTS'] = $arrElements;
        $this->includeComponentTemplate();
    }

}

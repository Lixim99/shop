<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;


class PicOuter extends CBitrixComponent
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
        $iblockClass =  Bitrix\Iblock\Iblock::wakeUp(6)->getEntityDataClass();

        $elementsRs = $iblockClass::query()
            ->setSelect(['ID', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE'])
            ->where('ACTIVE', true)
            ->exec();

        $arrElements = [];

        while ($element = $elementsRs->fetch()) {
            $arrElements[$element['ID']] = [
                'TITLE' => $element['NAME'],
                'TEXT' => $element['PREVIEW_TEXT'],
                'PICTURE' => CFile::GetPath($element['PREVIEW_PICTURE']),
            ];
        }

        $this->arResult['ELEMENTS'] = $arrElements;
        $this->includeComponentTemplate();
    }

}

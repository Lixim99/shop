<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;


class SliderOuter extends CBitrixComponent
{
//    public function onPrepareComponentParams($arParams)
//    {
//        return $arParams;
//    }

    public function executeComponent()
    {
        Loader::includeModule('highloadblock');


        $hlSliderClass = HighloadBlockTable::compileEntity('Slider')->getDataClass();
        $sliderValResult = $hlSliderClass::query()
            ->setSelect([
                'ID',
                'UF_MESSAGE',
                'UF_PHOTO',
                'UF_COMPANY',
                'UF_POSITION',
                'UF_NAME'
            ])
            ->exec();

        $arrSliderVal = [];
        $sliderPersonInfo = [];

        while ($sliderValues = $sliderValResult->fetch()) {
            if (!empty($sliderValues['UF_POSITION'])) {
                $sliderValues['UF_NAME'] .= ",{$sliderValues['UF_POSITION']}";
            }
            if (!empty($sliderValues['UF_POSITION'])) {
                $sliderValues['UF_NAME'] .= " AT {$sliderValues['UF_POSITION']}";
            }
            $arrSliderVal[$sliderValues['ID']] = [
                'PERSON' => strtoupper($sliderValues['UF_NAME']),
                'TEXT' => $sliderValues['UF_MESSAGE'],
                'PHOTO' => CFile::GetPath($sliderValues['UF_PHOTO']),
            ];
        }

        $this->arResult['ELEMENTS'] = $arrSliderVal;

        $this->includeComponentTemplate();
    }
}

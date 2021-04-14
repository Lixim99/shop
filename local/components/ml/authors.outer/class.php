<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;


class AuthorsOuter extends CBitrixComponent
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
        $iblockClass =  Bitrix\Iblock\Iblock::wakeUp(7)->getEntityDataClass();

        $elementsRs = $iblockClass::query()
            ->setSelect([
                'ID',
                'NAME',
                'PREVIEW_TEXT',
                'AUTHOR_POSITION' => 'POSITION.VALUE',
                'PERSONAL_PHOTO' => 'PHOTO.VALUE',
                'FACEBOOK' => 'FACEBOOK_LINK.VALUE',
                'TWITTER' => 'TWITTER_LINK.VALUE',
                'LINKDIN' => 'LINKDIN_LINK.VALUE',
                'GOOGLE_PLUS' => 'GOOGLE_PLUS_LINK.VALUE',
                'OTHER' => 'OTHER_LINK.VALUE'
                ])
            ->where('ACTIVE', true)
            ->exec();

        $arrElements = [];

        while ($element = $elementsRs->fetch()) {
            $arrElements[$element['ID']] = [
                'NAME' => $element['NAME'],
                'TEXT' => $element['PREVIEW_TEXT'],
                'AUTHOR_POSITION' => $element['AUTHOR_POSITION'],
                'PERSONAL_PHOTO' => CFile::GetPath($element['PERSONAL_PHOTO']),
                'LINKS' => [
                    'FACEBOOK' => $element['FACEBOOK'],
                    'TWITTER' => $element['TWITTER'],
                    'LINKEDIN' => $element['LINKDIN'],
                    'GOOGLE-PLUS' => $element['GOOGLE_PLUS'],
                    'DRIBBBLE' => $element['OTHER']
                ],
            ];
        }

        $this->arResult['ELEMENTS'] = $arrElements;
        $this->includeComponentTemplate();
    }

}

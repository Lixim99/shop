<?php

namespace ItBuro;

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Application;
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
use Bitrix\Main\Mail\Internal\EventMessageTable;
use Bitrix\Main\ORM\Query\Query;

/**
 * Class Handler
 * @package ItBuro
 */
class Handler
{
    /**
     *
     */
    public const PROGRAM_PROPERTY_CODE = 'PROGRAM_REVIEW';

    /**
     *
     */
    public const REVIEW_EVENT_TYPE = 'REVIEWS';

    /**
     *
     */
    public const REVIEW_IBLOCK_CODE = 'feedback';

    /**
     * @throws \Bitrix\Main\LoaderException
     */
    public static function initEvents()
    {
        $eventManager = EventManager::getInstance();

        if (Loader::includeModule('iblock')) {
            $eventManager->addEventHandler(
                'iblock',
                'OnAfterIBlockElementAdd',
                [static::class, 'sendNewReviewEmail']
            );
        }
    }

    /**
     * @return int
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function getReviewIblockId()
    {
        if (!Loader::includeModule('iblock')) {
            return 0;
        }

        $arIblock = IblockTable::query()
            ->where([
                ['ACTIVE'],
                ['CODE', static::REVIEW_IBLOCK_CODE]
            ])
            ->addSelect('ID')
            ->setCacheTtl(360000)
            ->exec()
            ->fetch();

        return (int)$arIblock['ID'];
    }

    /**
     * @param $arFields
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function sendNewReviewEmail(&$arFields)
    {
        // если элемент не добавился, или это не элемент инфоблока отзывов, то выходим
        if (empty($arFields['ID']) or $arFields['IBLOCK_ID'] != static::getReviewIblockId()) {
            return;
        }

        $arFieldsEmail = [
            'NAME' => $arFields['NAME'],
            'MAIN_INFO' => '',
            'PROGRAM_NAME' => ''
        ];

        $arMainInfo = [];

        // собираем инфу по свойствам
        if (!empty($arFields['PROPERTY_VALUES'])) {
            $rsProperties = PropertyTable::query()
                ->where([
                    ['IBLOCK_ID', $arFields['IBLOCK_ID']],
                    ['ACTIVE']
                ])
                ->where(
                    Query::filter()
                        ->logic('or')
                        ->whereIn('CODE', array_keys($arFields['PROPERTY_VALUES']))
                        ->whereIn('ID', array_keys($arFields['PROPERTY_VALUES']))
                )
                ->setSelect([
                    'NAME',
                    'CODE',
                    'PROPERTY_TYPE',
                    'LINK_IBLOCK_ID',
                    'ID'
                ])
                ->exec();

            while ($property = $rsProperties->fetch()) {
                $arPropertyInfo = $arFields['PROPERTY_VALUES'][$property['ID']]
                    ?? $arFields['PROPERTY_VALUES'][$property['CODE']];

                if (is_array($arPropertyInfo)) {
                    $arProperty = current($arPropertyInfo);
                    if (!empty($arProperty['VALUE'])) {
                        $arPropertyValue = $arProperty['VALUE'];
                    }
                } else {
                    $arPropertyValue = $arPropertyInfo;
                }

                if (empty($arPropertyValue)) {
                    continue;
                }

                switch ($property['PROPERTY_TYPE']) {
                    case PropertyTable::TYPE_ELEMENT:
                        if (empty($property['LINK_IBLOCK_ID'])) {
                            break;
                        }

                        $arElementIblock = ElementTable::query()
                            ->where([
                                ['ACTIVE'],
                                ['IBLOCK_ID', $property['LINK_IBLOCK_ID']],
                                ['ID', $arPropertyValue]
                            ])
                            ->addSelect('NAME')
                            ->exec()
                            ->fetch();
                        if (empty($arElementIblock['NAME'])) {
                            break;
                        }

                        if ($property['CODE'] == static::PROGRAM_PROPERTY_CODE) {
                            $arFieldsEmail['PROGRAM_NAME'] = $arElementIblock['NAME'];
                        }

                        $arMainInfo[$property['ID']] = [
                            'NAME' => $property['NAME'],
                            'VALUE' => $arElementIblock['NAME']
                        ];

                        break;

                    default:
                        $arMainInfo[$property['ID']] = [
                            'NAME' => $property['NAME'],
                            'VALUE' => $arPropertyValue
                        ];
                        break;
                }
            }
        }

        // закидываем основной текст
        if (!empty($arFields['PREVIEW_TEXT'])) {
            $arMainInfo[] = [
                'NAME' => 'Текст отзыва',
                'VALUE' => $arFields['PREVIEW_TEXT']
            ];
        }

        // собираем основную инфу по отзыву в одну строку
        foreach ($arMainInfo as $index => $info) {
            $arFieldsEmail['MAIN_INFO'] .= "{$info['NAME']}: {$info['VALUE']} \n" ;
        }

        // отправляем письмо
        if (empty($arFieldsEmail)) {
            return;
        }

        $context = Application::getInstance()->getContext();

        $arEventMessage = EventMessageTable::query()
            ->where([
                ['EVENT_NAME', static::REVIEW_EVENT_TYPE],
                ['ACTIVE', 'Y'],
                ['LANGUAGE_ID', $context->getLanguage()]
            ])
            ->addSelect('ID')
            ->exec()
            ->fetch();

        if (empty($arEventMessage)) {
            return;
        }

        $mailResult = \Bitrix\Main\Mail\Event::send([
            'MESSAGE_ID' => $arEventMessage['ID'],
            'EVENT_NAME' => static::REVIEW_EVENT_TYPE,
            "LID" => $context->getSite() ?? 's1',
            "C_FIELDS" => $arFieldsEmail,
            'LANGUAGE_ID' => $context->getLanguage()
        ]);

        if (!$mailResult->isSuccess()) {
            \CEventLog::Add([
                "SEVERITY" => "INGO",
                "AUDIT_TYPE_ID" => "Debug",
                "MODULE_ID" => "main",
                "DESCRIPTION" => 'Ошибка отправки письма: ' . serialize($mailResult->getErrorMessages()),
            ]);
        }
    }
}
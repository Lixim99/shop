<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock\HighloadBlockTable;
use \Bitrix\Main\{ORM\Entity, Application, Context, Engine\Contract\Controllerable};

class CHLOuter extends CBitrixComponent implements Controllerable
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['ENTITY_VALUE'] = strval($arParams['ENTITY_VALUE']);
        return $arParams;
    }

    public function executeComponent()
    {
        Loader::includeModule('highloadblock');

        $entityId = $this->arParams['ENTITY_VALUE'];

        if (!is_numeric($entityId)) {
            $hlEntity = HighloadBlockTable::query()
                ->addSelect('ID')
                ->where('NAME', $this->arParams['ENTITY_VALUE'])
                ->exec()
                ->fetch();

            $this->arParams['ENTITY_VALUE'] = $hlEntity['ID'];
        }

        global $USER_FIELD_MANAGER;
        $arFields = $USER_FIELD_MANAGER->GetUserFields(
            'HLBLOCK_' . $entityId,
            0,
            Context::getCurrent()->getLanguage()
        );
        $enum = new \CUserFieldEnum;

        $arRes = [];

        foreach ($arFields as $value) {
            $arRes[$value['USER_TYPE_ID']][$value['ID']] = $value;
            if ($value['USER_TYPE_ID'] == \Bitrix\Main\UserField\Types\EnumType::USER_TYPE_ID) {
                $listValue = $enum->GetList([], ['USER_FIELD_ID' => $value['ID']]);
                $arRes[$value['USER_TYPE_ID']][$value['ID']]['LIST_VALUES'] = $listValue->arResult;
            }
        }

        $this->arResult['USERS_FIELDS'] = $arRes;
        $this->arResult['UNIQUE_DATA_TYPE'] = array_keys($arRes);
        $this->arResult['HL_ID'] = $entityId;

        $this->arResult['SIGNATURE'] = $this->getSignedParameters();

        $this->includeComponentTemplate();
    }

    protected function listKeysSignedParameters()
    {
        return [
            'ENTITY_VALUE'
        ];
    }

    public function configureActions()
    {
        return [
            'sendAnswer' => [
                'prefilters' => [],
            ],
        ];
    }

    public function sendAnswerAction()
    {
        Loader::includeModule('highloadblock');

        $arrRequest = $this->request->get('fields');
        $HLId = $this->arParams['ENTITY_VALUE'];

        if (!empty($HLId) && !empty($arrRequest)) {
            $entityClass = HighloadBlockTable::compileEntity($HLId)->getDataClass();

            $addResult = $entityClass::add($arrRequest);
            if ($addResult->isSuccess()) {
                $ansForUser = 'Спасибо за ваше мнение!';
            } else {
                throw new \Bitrix\Main\SystemException('Ошибка заполнения: ' . implode($addResult->getErrorMessages()));
            }
        }

        return $ansForUser;
    }
}

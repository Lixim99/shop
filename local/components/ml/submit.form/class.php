<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock\HighloadBlockTable;
use \Bitrix\Main\{ORM\Entity, Application, Context, Engine\Contract\Controllerable};

class CHLOuter extends CBitrixComponent implements Controllerable
{
//    public function onPrepareComponentParams($arParams)
//    {
//
//        return $arParams;
//    }

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
        $arFields = $USER_FIELD_MANAGER->GetUserFields('HLBLOCK_' . $entityId, 0, Context::getCurrent()->getLanguage());
        $enum = new \CUserFieldEnum;

        $arRes = [];

        foreach ($arFields as $value) {
            $arRes[$value['USER_TYPE_ID']][$value['ID']] = $value;
            if ($value['USER_TYPE_ID'] == 'enumeration') {
                $listValue = $enum->GetList([], ['USER_FIELD_ID' => $value['ID']]);
                $arRes[$value['USER_TYPE_ID']][$value['ID']]['LIST_VALUES'] = $listValue->arResult;
            }
        }

        /*
        $usersFields = [
            (new Fields\IntegerField('ID')),
            (new Fields\StringField('ENTITY_ID')),
            (new Fields\StringField('FIELD_NAME')),
            (new Fields\StringField('USER_TYPE_ID')),
            (new Fields\BooleanField('MULTIPLE')),
            (new Fields\StringField('SETTINGS')),
            (new Fields\StringField('MANDATORY')),
        ];
        $listFields = [
            (new Fields\IntegerField('ID')),
            (new Fields\StringField('USER_FIELD_ID')),
            (new Fields\StringField('VALUE')),
        ];
        $langFields = [
            (new Fields\StringField('USER_FIELD_ID')),
            (new Fields\StringField('LIST_COLUMN_LABEL')),
        ];

        $userFieldsEntity = self::getEntity(
            'UsersFields', $usersFields, 'Field', 'b_user_field'
        );

        $refListEntity = self::getEntity(
            'ListField', $listFields, 'UserFieldList', 'b_user_field_enum'
        );

        $refLangEntity = self::getEntity(
            'LangField', $langFields, 'UserLangFields', 'b_user_field_lang'
        );


        $customUserClass = $userFieldsEntity->getDataClass();

        $arrUsersFields = $customUserClass::query()
            ->setSelect([
                'ID', 'ENTITY_ID', 'FIELD_NAME', 'USER_TYPE_ID', 'MANDATORY', 'MULTIPLE', 'SETTINGS',
                'LIST_VALUE' => 'LIST.VALUE', 'LIST_ID' => 'LIST.ID',
                'TITLE_RU' => 'LANG.LIST_COLUMN_LABEL'
            ])
            ->registerRuntimeField(
                (new Fields\Relations\Reference(
                    'LIST',
                    $refListEntity,
                    ORM\Query\Join::on(
                        'this.ID', 'ref.USER_FIELD_ID'
                    )
                ))
            )
            ->registerRuntimeField(
                (new Fields\Relations\Reference(
                    'LANG',
                    $refLangEntity,
                    ORM\Query\Join::on(
                        'this.ID', 'ref.USER_FIELD_ID'
                    )
                ))
            )
            ->where('ENTITY_ID', 'HLBLOCK_' . $entityId)
            ->exec();

        $arrFields = [];

        while ($userField = $arrUsersFields->fetch()) {
            if (!isset($arrFields[$userField['USER_TYPE_ID']][$userField['FIELD_NAME']])) {
                $arrFields[$userField['USER_TYPE_ID']][$userField['FIELD_NAME']] = [
                    'MUST_FILL' => $userField['MANDATORY'],
                    'SETTINGS' => unserialize($userField['SETTINGS']),
                    'VALUE' => [
                        $userField['LIST_ID'] => $userField['LIST_VALUE']
                    ]
                ];
            } else {
                $arrFields[$userField['USER_TYPE_ID']][$userField['FIELD_NAME']]['VALUE'] += [
                    $userField['LIST_ID'] => $userField['LIST_VALUE']
                ];
            }

            if (!empty($userField['TITLE_RU'])) {
                $arrFields[$userField['USER_TYPE_ID']][$userField['FIELD_NAME']]['NAME_RU'] = $userField['TITLE_RU'];
            }
        }
        */

        $this->arResult['USERS_FIELDS'] = $arRes;
        $this->arResult['UNIQUE_DATA_TYPE'] = array_keys($arRes);
        $this->arResult['HL_ID'] = $entityId;

        $this->arResult['SIGNATURE'] = $this->getSignedParameters();

        $this->includeComponentTemplate();
    }

//    public static function getEntity(string $name, array $fields, string $nameSpace, string $tableName)
//    {
//        return Entity::compileEntity(
//            $name,
//            $fields,
//            [
//                'namespace' => $nameSpace,
//                'table_name' => $tableName
//            ]
//        );
//    }

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
//        throw new \Bitrix\Main\SystemException('test execp');

        Loader::includeModule('highloadblock');

        $arrRequest = Application::getInstance()->getContext()->getRequest()->toArray();
        $HLId = $this->arParams['ENTITY_VALUE'];

        $ansForUser = 'Ошибка заполнения';
        if (!empty($HLId) && !empty($arrRequest)) {
            $entityClass = HighloadBlockTable::compileEntity($HLId)->getDataClass();

            $addResult = $entityClass::add($arrRequest);
            $arrError = $addResult->getErrorMessages();
            $ansForUser = (count($arrError) == 0) ? 'Спасибо за ваше мнение!' : implode($arrError);
        }

        return $ansForUser;
    }
}

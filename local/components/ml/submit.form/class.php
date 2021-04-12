<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock\HighloadBlockTable;
use \Bitrix\Main\{ORM, ORM\Entity, ORM\Fields, Application};
use Bitrix\Main\Engine\Contract\Controllerable;

Loader::includeModule('highloadblock');

class CHLOuter extends CBitrixComponent implements Controllerable
{
    public function onPrepareComponentParams($arParams)
    {
        if (!is_numeric($arParams)) {
            $hlEntity = HighloadBlockTable::query()
                ->addSelect('ID')
                ->where('NAME', $this->arParams['ENTITY_VALUE'])
                ->exec()
                ->fetch();

            $this->arParams['ENTITY_VALUE'] = $hlEntity['ID'];
        }

        return $arParams;
    }

    public function executeComponent()
    {
        self::onPrepareComponentParams($this->arParams['ENTITY_VALUE']);

        $entityId = $this->arParams['ENTITY_VALUE'];

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

        $this->arResult['USERS_FIELDS'] = $arrFields;
        $this->arResult['UNIQUE_DATA_TYPE'] = array_keys($arrFields);
        $this->arResult['HL_ID'] = $entityId;

        $this->includeComponentTemplate();
    }

    public static function getEntity(string $name, array $fields, string $nameSpace, string $tableName)
    {
        return Entity::compileEntity(
            $name,
            $fields,
            [
                'namespace' => $nameSpace,
                'table_name' => $tableName
            ]
        );
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
        $arrRequest = Application::getInstance()->getContext()->getRequest()->toArray()['post'];
        $HLId = array_pop($arrRequest);

        $ansForUser = 'Ошибка заполнения';
//        if (!empty($HLId) && !empty($arrRequest)) {
//            $entityClass = HighloadBlockTable::compileEntity($HLId)->getDataClass();
//
//            $addResult = $entityClass::add($arrRequest);
//            $arrError = $addResult->getErrorMessages();
//            $ansForUser = (count($arrError) == 0)?'Спасибо за ваше мнение!':implode($arrError);
//        }

        return $arrRequest;
    }
}

<?php
/*
             *     ,MMM8&&&.            *
                  MMMM88&&&&&    .
                 MMMM88&&&&&&&
     *           MMMLITVINOV&&&
                 MMM88&&&&&&&&

                 'MMM88&&&&&&'
                   'MMM8&&&'      *
          |\___/|
          )     (             .              '
         =\     /=
           )===(       *
          /     \
          |     |
         /       \
         \       /
  _/\_/\_/\__  _/_/\_/\_/\_/\_/\_/\_/\_/\_/\_
  |  |  |  |( (  |  |  |  |  |  |  |  |  |  |
  |  |  |  | ) ) |  |  |  |  |  |  |  |  |  |
  |  |  |  |(_(  |  |  |  |  |  |  |  |  |  |
  |  |  |  |  |  |  |  LITVINOV  MAX  |  |  |
  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/SF.php';

use \Bitrix\Highloadblock;
use \Bitrix\Main\{ORM\Query\Query, ORM\Fields, ORM\Entity, Loader, FileTable, ORM};
use \Bitrix\Iblock\{IblockTable, Iblock, ElementTable};

Loader::includeMOdule('highloadblock');
Loader::includeMOdule('iblock');

/**
 * HIGLOADBLOCK name
 */
$entity = Highloadblock\HighloadBlockTable::compileEntity('ProductMarkingCodeGroup');
$query = new Query($entity);
$rs = $query->setSelect(['ID', 'UF_NAME'])->addFilter('>ID', 4)->exec();

/*
echo '<b>HIGLOAD блоки по названию</b></br>';
echo '<pre>';
print_r($rs->fetchAll());
echo '</pre>';
*/

/**
 *  Creat new tmp class
 */
$entity = Entity::compileEntity(
    'MyEntity',
    [
        (new Fields\IntegerField('ID'))
            ->configurePrimary(),
        (new Fields\StringField('NAME'))
            ->configureRequired(),
    ],
    [
        'namespace' => 'MyNamespace',
        'table_name' => 'b_iblock',
    ]
);

$query = new Query($entity);
$rs = $query->setSelect(['ID', 'NAME'])->exec();

/*
echo '<b>Создание собственной сущности</b></br>';
echo '<pre>';
var_dump($rs->fetchAll());
echo '</pre>';
*/

/**
 *  MagicMethods and save
 *
 */
$ent = IblockTable::compileEntity('cloth');

$query = new Query($ent);

$rs = $query
    ->where('ID', '>=', 4)
    ->setSelect(['ID', 'NAME', 'BRAND_REF'])
    ->exec()
    ->fetchCollection();

$arProd = [];

foreach ($rs as $obj) {
    if ($obj->getId() == 4) {
        $arProd[$obj->getId()] = [
            'NAME' => $obj->setName('Handler'),
        ];
        $obj->save();
    }
    $arProd[$obj->getId()] = [
        'NAME' => $obj->getName(),
    ];
    foreach ($obj->getBrandRef()->getAll() as $value) {
        $arProd[$obj->getId()]['BRAND'][] = $value->get('VALUE');
    }

}

/*
echo '<b>Компиляция сущности по ApiCode инфоблока</b></br>';
echo '<pre>';
var_dump($arProd);
echo '</pre>';
*/

/**
 *  ADD, DELETE, UPDATE D7 *(extends class DataManager)
 * @returns object;
 */
$resUpdate = IblockTable::update(3, ['fields' => ['API_CODE' => 'SOME_SHIT']]);
$resAdd = IblockTable::add([
    'fields' => [
        'ID' => '6',
        'TIMESTAMP_X' => date('H:i:s'),
        'IBLOCK_TYPE_ID' => 'offerce',
        'LID' => 's1',
        'NAME' => 'NAME',
        'ACTIVE' => 'Y'
    ]
]);
$resDel = IblockTable::delete(3);

/**
 *  Fast object creating and update
 * @var \Bitrix\Main\ORM\Objectify\EntityObject $obj
 * @var \Bitrix\Main\ORM\Objectify\EntityObject $newObj
 */

$entity = Entity::compileEntity(
    'MyEntity',
    [
        (new Fields\IntegerField('ID'))
            ->configurePrimary(),
        (new Fields\StringField('NAME'))
            ->configureRequired(),
    ],
    [
        'namespace' => 'NewSpace',
        'table_name' => 'b_iblock',
    ]
);

$obj = $entity->wakeUpObject(2);
$obj->setName('NewName');
//$obj->save();

$newObj = $entity->createObject();
$newObj->setName(date('H:i:s'));
//$newObj->save();

/**
 * RuntimeFields and relation 1:1
 * @var \Bitrix\Main\ORM\Objectify\EntityObject $obj
 * @var \Bitrix\Main\ORM\Objectify\EntityObject $picObj
 */
$elemEntity = ElementTable::getEntity();
$fileEntity = FileTable::getEntity();

//$elemEntity->addField(
//    (new Fields\Relations\Reference(
//        'PICTURE',
//        $fileEntity,
//        ORM\Query\Join::on(
//            'this.PREVIEW_PICTURE', 'ref.ID'
//        )
//    ))->configureJoinType(ORM\Query\Join::TYPE_LEFT)
//);

//echo '<pre>';
//print_r();
//echo '</pre>';
$rs =
    (new Query($elemEntity))
    ->where('ACTIVE')
    ->setSelect([
            'ID',
            'NAME',
            'PREVIEW_PICTURE',
            'PICTURE',
            new \Bitrix\Main\Entity\ExpressionField(
                'PICTURE_SRC',
                'CONCAT("/upload/", %s, "/", %s)',
                ['PICTURE.SUBDIR', 'PICTURE.FILE_NAME']
            )
        ])
        ->where('IBLOCK_ID', '=', 1)
        ->whereNotNull('PREVIEW_PICTURE')
//        ->registerRuntimeField(
//            'PICTURE',
//            (new Fields\Relations\Reference(
//                'PICTURE',
//                $fileEntity,
//                \Bitrix\Main\ORM\Query\Join::on(
//                    'this.PREVIEW_PICTURE', 'ref.ID'
//                )
//            ))->configureJoinType('left')
//        )
        ->registerRuntimeField(
            'PICTURE',
            (new Fields\Relations\Reference(
                'PICTURE',
                FileTable::class,
                ORM\Query\Join::on(
                    'this.PREVIEW_PICTURE', 'ref.ID'
                )
            ))
        )
        ->exec()
        ->fetchCollection();

$arrElement = [];

foreach ($rs as $obj) {

    $arrElement[$obj->getId()] = [
        'NAME' => $obj->getName(),
        'PICTURE_SRC' => $obj->get('PICTURE_SRC'),

    ]; ?>
    <img src="<?= $arrElement[$obj->getId()]['PICTURE_SRC'] ?>">
    <?php
//    if ($obj->getPreviewPicture() == 7) {
//        $picObj = $obj->get('PICTURE');
//        $picObj->set('HEIGHT', 111);
//        $picObj->save();
//    }
}

//echo '<pre>';
//var_dump($arrElement);
//echo '</pre>';

/**
 * Relation 1:MANY
 *  @var \Bitrix\Main\ORM\Objectify\EntityObject $obj
 */
$hlEntity = Entity::compileEntity(
    'HLEntity',
    [
        (new Fields\IntegerField('ID'))
            ->configurePrimary(),
        (new Fields\StringField('UF_NAME'))
            ->configureRequired(),
        (new Fields\StringField('UF_FILE')),
        (new Fields\StringField('UF_XML_ID'))
    ],
    [
        'namespace' => 'NewSpace',
        'table_name' => 'eshop_brand_reference',
    ]
);

$iblockEntity = IblockTable::compileEntity('cloth');
$hlField = $iblockEntity->getField('BRAND_REF');
$hlPropEntity = $hlField->getRefEntity();

$rs1 =
    (new Query($hlEntity))
        ->setSelect([
            'ID',
            'UF_NAME',
            'IBLOCK_ELEM' => 'ELEMENT.IBLOCK_ELEMENT_ID',
        ])
        ->where('ID', 1)
        ->registerRuntimeField(
            (new Fields\Relations\Reference(
                'ELEMENT',
                $hlPropEntity,
                ORM\Query\Join::on(
                    'this.UF_XML_ID', 'ref.VALUE'
                )
            ))
        )
        ->exec()
        ->fetchAll();

$arRes = [];

//foreach ($rs1 as $obj) {
//    foreach ($obj->get('IBLOCK_ELEM')->getAll() as $value) {
//        $arRes[$obj->getId()] = [
//            'IBLOCK_ID' => $value->getValue()
//        ];
//    }
//}
echo '<pre>';
var_dump($rs1);
echo '</pre>';
//$rs =
//    (new Query($hlEntity))
//    ->setSelect(['ID', 'UF_NAME', 'UF_FILE'])
//    ->exec()
//    ->fetchCollection();

//foreach ($rs as $obj) {
//    echo '<pre>';
//    var_dump($obj->getUfFile());
//    echo '</pre>';
//}

$rsProps = ElementPropertyTable::query()
    ->where([
        ['IBLOCK_ELEMENT_ID', $ElementID],
        ['ELEMENT.IBLOCK_ID', $arParams['IBLOCK_ID']]
    ])
    ->where(Query::filter()
        ->logic('or')
        ->where('PROPERTY.PROPERTY_TYPE', 'E')
        ->where(Query::filter()
            ->where([
                ['PROPERTY.PROPERTY_TYPE', 'S'],
                ['PROPERTY.USER_TYPE', 'directory']
            ])
        )
    )
    ->setSelect($arSelect)
    ->addOrder('PROPERTY.SORT', 'ASC')

    /**
     * min runtime field
     */
    ->registerRuntimeField('PROPERTY', [
        'data_type' => '\Bitrix\Iblock\PropertyTable',
        'reference' => ['this.IBLOCK_PROPERTY_ID' => 'ref.ID']
    ])
    ->exec();

/**
 * Пример "ручного кеша"
 */
if (!empty($arParams['ORGANIZATIONS_IBLOCK_ID']) and Loader::includeModule('iblock')) {

    $cache = Application::getInstance()->getCache();
    $taggedCache = Application::getInstance()->getTaggedCache();

    $cacheId = md5(serialize(array_merge($arParams, [$ElementID])));

    if ($cache->initCache($arParams['CACHE_TIME'], $cacheId, "/iblock/projects")) {
        $arOrganizationsIds = $cache->getVars();
    } elseif ($cache->startDataCache()) {
        $taggedCache->startTagCache("/iblock/projects");
        $taggedCache->registerTag("iblock_id_" . $arParams['ORGANIZATIONS_IBLOCK_ID']);
        $taggedCache->registerTag("iblock_id_" . $arParams['PROGRAMS_IBLOCK_ID']);

        $arPrograms = \Bitrix\Iblock\ElementPropertyTable::query()
            ->where([
                ['VALUE', $ElementID],
                ['PROPERTY.CODE', 'PROGRAM_ORGANIZER']
            ])
            ->setSelect(['PROGRAM_ID' => 'ELEMENT.ID'])
            ->registerRuntimeField('PROPERTY', [
                'data_type' => '\Bitrix\Iblock\PropertyTable',
                'reference' => ['this.IBLOCK_PROPERTY_ID' => 'ref.ID']
            ])
            ->exec()
            ->fetchAll();

        $arProgramsIds = array_column($arPrograms, 'PROGRAM_ID');

        if (!empty($arProgramsIds)) {
            $arOrganizations = \Bitrix\Iblock\ElementPropertyTable::query()
                ->where('PROPERTY.CODE', 'ORGANIZATIONS')
                ->whereIn('IBLOCK_ELEMENT_ID', $arProgramsIds)
                ->setSelect(['PROP_ID' => 'VALUE'])
                ->registerRuntimeField('PROPERTY', [
                    'data_type' => '\Bitrix\Iblock\PropertyTable',
                    'reference' => ['this.IBLOCK_PROPERTY_ID' => 'ref.ID']
                ])
                ->exec()
                ->fetchAll();

            $arOrganizationsIds = array_column($arOrganizations, 'PROP_ID');
        }
        $taggedCache->endTagCache();
        $cache->endDataCache((!empty($arOrganizationsIds) ? $arOrganizationsIds : 0));
    } else {
        $cache->abortDataCache();
        $arOrganizationsIds = 0;
    }
}

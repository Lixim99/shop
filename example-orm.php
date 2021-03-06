<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Тестовый список");

use \Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\UI\PageNavigation;

$list_id = 'example_list';

$grid_options = new GridOptions($list_id);
$sort = $grid_options->GetSorting(['sort' => ['ID' => 'DESC'], 'vars' => ['by' => 'by', 'order' => 'order']]);
$nav_params = $grid_options->GetNavParams(["nPageSize" => 1]);


$nav = new PageNavigation('request_list');
$nav->allowAllRecords(true)
    ->setPageSize($nav_params['nPageSize'])
    ->initFromUri();

$filterOption = new Bitrix\Main\UI\Filter\Options($list_id);
$filterData = $filterOption->getFilter([]);
$filter = [];

echo '<pre>';
var_dump($filterData);
echo '</pre>';

foreach ($filterData as $k => $v) {
    $filter = [
//        'ID' => $filterData['FIND'],
        'NAME' => "%" . $filterData['FIND'] . "%",
    ];
}


$res = Bitrix\Iblock\IblockTable::getList([
    'filter' => $filter,
    'select' => [
        "*",
    ],
    'offset' => $nav->getOffset(),
    'limit' => $nav->getLimit(),
    'order' => $sort['sort']
]);

$ui_filter = [
    ['id' => 'NAME', 'name' => 'Название', 'type' => 'text', 'default' => true],
    ['id' => 'DATE_CREATE', 'name' => 'Дата создания', 'type' => 'date', 'default' => true],
//    ['id' => 'ID', 'name' => 'IBLOCK_ID', 'type' => 'text', 'default' => true],
];
?>
    <h2>Фильтр</h2>
    <div>
        <? $APPLICATION->IncludeComponent('bitrix:main.ui.filter', '', [
            'FILTER_ID' => $list_id,
            'GRID_ID' => $list_id,
            'FILTER' => $ui_filter,
            'ENABLE_LIVE_SEARCH' => true,
            'ENABLE_LABEL' => true
        ]); ?>
    </div>
    <div style="clear: both;"></div>

    <hr>

    <h2>Таблица</h2>
<?php
$columns = [];
$columns[] = ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true];
$columns[] = ['id' => 'NAME', 'name' => 'Название', 'sort' => 'NAME', 'default' => true];
$columns[] = ['id' => 'DATE_CREATE', 'name' => 'Создано', 'sort' => 'DATE_CREATE', 'default' => true];

foreach ($res->fetchAll() as $row) {
    $list[] = [
        'data' => [
            "ID" => $row['ID'],
            "NAME" => $row['NAME'],
            "DATE_CREATE" => $row['DATE_CREATE'],
        ],
        'actions' => [
            [
                'text' => 'Просмотр',
                'default' => true,
                'onclick' => 'document.location.href="?op=view&id=' . $row['ID'] . '"'
            ],
            [
                'text' => 'Удалить',
                'default' => true,
                'onclick' => 'if(confirm("Точно?")){document.location.href="?op=delete&id=' . $row['ID'] . '"}'
            ]
        ]
    ];
}

$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [
    'GRID_ID' => $list_id,
    'COLUMNS' => $columns,
    'ROWS' => $list,
    'SHOW_ROW_CHECKBOXES' => false,
    'NAV_OBJECT' => $nav,
    'AJAX_MODE' => 'Y',
    'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
    'PAGE_SIZES' => [
        ['NAME' => '20', 'VALUE' => '20'],
        ['NAME' => '50', 'VALUE' => '50'],
        ['NAME' => '100', 'VALUE' => '100']
    ],
    'AJAX_OPTION_JUMP' => 'N',
    'SHOW_CHECK_ALL_CHECKBOXES' => false,
    'SHOW_ROW_ACTIONS_MENU' => true,
    'SHOW_GRID_SETTINGS_MENU' => true,
    'SHOW_NAVIGATION_PANEL' => true,
    'SHOW_PAGINATION' => true,
    'SHOW_SELECTED_COUNTER' => true,
    'SHOW_TOTAL_COUNTER' => true,
    'SHOW_PAGESIZE' => true,
    'SHOW_ACTION_PANEL' => true,
    'ALLOW_COLUMNS_SORT' => true,
    'ALLOW_COLUMNS_RESIZE' => true,
    'ALLOW_HORIZONTAL_SCROLL' => true,
    'ALLOW_SORT' => true,
    'ALLOW_PIN_HEADER' => true,
    'AJAX_OPTION_HISTORY' => 'N'
]);
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
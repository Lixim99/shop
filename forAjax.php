<?php

use Bitrix\Main\FileTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

if ($_REQUEST['SEND'] == 'Y') {
    $rs = FileTable::query()
        ->setSelect(['SUBDIR', 'FILE_NAME'])
        ->where('ID', '<=', 9)
        ->exec();

        while ($imgProp = $rs->fetch()) {
            $dir = $imgProp['SUBDIR'];
            $fileName = $imgProp['FILE_NAME'];
         echo '<img src=' . '/upload/' .  $dir . '/' . $fileName . '>';
    }

}

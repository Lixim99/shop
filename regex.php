<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
preg_match('/(foob)(ar)/', 'foobarbaz', $matches, PREG_OFFSET_CAPTURE);
print_r('foobarbaz');
echo '<pre>';
print_r($matches);
echo '</pre>';
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Page\Asset;

echo '<pre>';
var_dump();
echo '</pre>';

Asset::getInstance()->addJs( $_SERVER['DOCUMENT_ROOT'] . '/scrp/jquery-2.1.3.min.js');
?>
<div class="som"></div>
<script>
    console.log($('.som'));
</script>

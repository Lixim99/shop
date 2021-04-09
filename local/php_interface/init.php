<?php

Bitrix\Main\Loader::registerAutoLoadClasses(null, [
    'classes\Handler' => '/local/php_interface/classes/Handler.php'
]);

\classes\Handler::handler("main", "OnBuildGlobalMenu", "onBuildGlobalMenu");


<?php

namespace classes;

Class Handler
{

    public function onBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
    {

    }

    public static function handler($modulId, $eventType, $callback)
    {
        \Bitrix\Main\EventManager::getInstance()->addEventHandler(
            $modulId,
            $eventType,
            [self::class, $callback]
        );

    }
}
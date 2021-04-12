<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
?><?$APPLICATION->IncludeComponent(
    "ml:submit.form",
    "",
    Array(
        "ENTITY_NAME" => "asd"
    )
);?><?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
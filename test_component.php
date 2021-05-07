<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
?><?$APPLICATION->IncludeComponent(
	"ml:submit.form", 
	".default", 
	array(
		"ENTITY_NAME" => "asd",
		"COMPONENT_TEMPLATE" => ".default",
		"ENTITY_VALUE" => "5"
	),
	false
);?><?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
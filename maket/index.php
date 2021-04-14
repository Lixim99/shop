<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ActiveBox");?>
<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "top_templ",
    [
        "AREA_FILE_SHOW" => "file",
        "COMPONENT_TEMPLATE" => ".default",
        "EDIT_TEMPLATE" => "",
        "PATH" => "/maket/top.php"
    ]
);?>
</section>
<?$APPLICATION->IncludeComponent(
	"ml:icons.outer",
	"",
[]
);?>
<?$APPLICATION->IncludeComponent(
	"ml:picture.outer",
	"",
[]
);?>
<?$APPLICATION->IncludeComponent(
	"ml:authors.outer",
	"",
[]
);?>
<?$APPLICATION->IncludeComponent(
	"ml:slider.outer",
	"",
[]
);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"download_templ",
	Array(
		"AREA_FILE_SHOW" => "file",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/maket/download.php"
	)
);?><?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
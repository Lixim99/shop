<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<footer class="footer">
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "footer_incl",
        [
            "AREA_FILE_SHOW" => "file",
            "COMPONENT_TEMPLATE" => ".default",
            "EDIT_TEMPLATE" => "",
            "PATH" => SITE_TEMPLATE_PATH . "/footer_incl.php"
        ]
    );?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "footer_rights",
        [
            "AREA_FILE_SHOW" => "file",
            "COMPONENT_TEMPLATE" => ".default",
            "EDIT_TEMPLATE" => "",
            "PATH" => SITE_TEMPLATE_PATH . "/footer_rights.php"
        ]
    );?>
</footer>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-XXXX-X');
    ga('send', 'pageview');
</script>
</body>
</html>
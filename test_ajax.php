<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
?>
<a href="javascript:void(0)" id="clicker">Click</a>
<div id="content" style="display: none"></div>
<script src="scrp/jquery-2.1.3.min.js"></script>
<script>

$('#clicker').click(someFunc);
function someFunc () {
    $.ajax({
        url:'/forAjax.php',
        type:'POST',
        data:'SEND=Y',
        success: function (data){
            console.log(data);
            $('#content').html(data).show();
        }
    });
}
</script>

<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CUtil::InitJSCore();
CJSCore::Init(["jquery", "ajax", "fx"]);
?>
<?if (!empty($arResult['USERS_FIELDS'])):?>
    <form id="feedForm" method="post">
        <?if (in_array('string',$arResult['UNIQUE_DATA_TYPE'])):?>
            <?foreach ($arResult['USERS_FIELDS']['string'] as $field => $usersStringField):?>
                <label for="<?=$field?>">
                    <?=(!empty($usersStringField['NAME_RU']))?$usersStringField['NAME_RU']:$field?>
                </label><br>
                <?if ($usersStringField['SETTINGS']['ROWS'] > 1):?>
                    <textarea
                        <?=($usersStringField['MUST_FILL'] == 'Y') ? 'required' : ''?>
                        name="<?=$field?>"
                        cols="<?=$usersStringField['SETTINGS']['SIZE']?>"
                        rows="<?=$usersStringField['SETTINGS']['ROWS']?>"
                    ></textarea><br>
                <?else:?>
                    <input
                        <?=($usersStringField['MUST_FILL'] == 'Y') ? 'required' : ''?>
                        type="text"
                        size="<?=$usersStringField['SETTINGS']['SIZE']?>"
                    ><br>
                <?endif;?>
            <?endforeach;?>
        <?endif;?>
        <?if (in_array('boolean',$arResult['UNIQUE_DATA_TYPE'])):?>
            <?foreach ($arResult['USERS_FIELDS']['boolean'] as $field => $usersBoolField):?>
                <label for="<?=$field?>">
                    <?=(!empty($usersBoolField['NAME_RU']))?$usersBoolField['NAME_RU']:$field?>
                </label><br>
                <input <?=($usersBoolField['MUST_FILL'] == 'Y') ? 'required' : ''?> name="<?=$field?>" type="checkbox">
                <br>
            <?endforeach;?>
        <?endif;?>
        <?if (in_array('enumeration',$arResult['UNIQUE_DATA_TYPE'])):?>
            <?foreach ($arResult['USERS_FIELDS']['enumeration'] as $field => $usersEnumField):?>
                <label for="<?=$field?>">
                    <?=(!empty($usersEnumField['NAME_RU']))?$usersEnumField['NAME_RU']:$field?>
                </label><br>
                <select name="<?=$field?>">
                    <?foreach ($usersEnumField['VALUE'] as $sectID => $sectValue):?>
                      <option value="<?=$sectID?>"><?=$sectValue?></option>
                    <?endforeach;?>
                </select></br>
            <?endforeach;?>
        <?endif;?>
        <input type="submit">
    </form>
    <div id="submitAnswer" style="display: none"></div>

    <script>

    </script>
    <script>
        fForm = $('#feedForm');
        fForm.submit((e) => {
            e.preventDefault();
            fForm.append('<input type="hidden" name="highload_value" value="' + <?=json_encode($arResult['HL_ID'])?> +'" /> ');

            // BX.ajax.runComponentAction('ml:submit.form', 'sendAnswer', {
            //     mode:'class',
            //     data: {post: fForm.serialize()},
            // }).then(function (response) {
            //     console.log(response);
            //     $('#submitAnswer').html(response).show();
            // });

            $.ajax({
                type: fForm.attr('method'),
                url: "/feedSubmit.php",
                data: fForm.serialize(),
                success: (data) => {
                    $('#submitAnswer').html(data).show();
                },
            });
        })
    </script>
<?endif;?>

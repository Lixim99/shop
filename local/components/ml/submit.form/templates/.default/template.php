<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CUtil::InitJSCore();
CJSCore::Init(["jquery", "ajax", "fx"]);
?>
<?if (!empty($arResult['USERS_FIELDS'])):?>
    <form id="feedForm" method="post">
        <?if (!empty($arResult['SIGNATURE'])):?>
            <input name="signedParams" value="<?=$arResult['SIGNATURE']?>" type="hidden">
        <?endif;?>
        <?foreach ($arResult['USERS_FIELDS'] as $userType => $arUserFieldId):
            switch ($userType) {
                case ('string'):
                    foreach ($arUserFieldId as $field):
                    ?>
                        <label for="<?=$field['FIELD_NAME']?>">
                            <?=(!empty($field["LIST_COLUMN_LABEL"]))?$field["LIST_COLUMN_LABEL"]:$field['FIELD_NAME']?>
                        </label><br>
                        <?if ($field['SETTINGS']['ROWS'] > 1):?>
                            <textarea
                                <?=($field['MANDATORY'] == 'Y') ? 'required' : ''?>
                                name="<?=$field['FIELD_NAME']?>"
                                cols="<?=$field['SETTINGS']['SIZE']?>"
                                rows="<?=$field['SETTINGS']['ROWS']?>"
                            ></textarea><br>
                        <?else:?>
                            <input
                                <?=($field['MANDATORY'] == 'Y') ? 'required' : ''?>
                                    type="text"
                                    size="<?=$field['SETTINGS']['SIZE']?>"
                            ><br>
                    <?
                        endif;
                    endforeach;
                    break;
                case ('boolean'):
                    foreach ($arUserFieldId as $field):
                    ?>
                        <label for="<?=$field['FIELD_NAME']?>">
                            <?=(!empty($field["LIST_COLUMN_LABEL"]))?$field["LIST_COLUMN_LABEL"]:$field['FIELD_NAME']?>
                        </label><br>
                        <input <?=($field['MANDATORY'] == 'Y') ? 'required' : ''?> name="<?=$field['FIELD_NAME']?>" type="checkbox">
                        <br>
                    <?
                    endforeach;
                    break;
                case ('enumeration'):
                    foreach ($arUserFieldId as $field):
                    ?>
                        <label for="<?=$field['FIELD_NAME']?>">
                            <?=(!empty($field["LIST_COLUMN_LABEL"]))?$field["LIST_COLUMN_LABEL"]:$field['FIELD_NAME']?>
                        </label><br>
                        <select name="<?=$field['FIELD_NAME']?>">
                            <?foreach ($field['LIST_VALUES'] as $sectValue):?>
                                <option value="<?=$sectValue['ID']?>"><?=$sectValue['VALUE']?></option>
                            <?endforeach;?>
                        </select></br>
                    <?
                    endforeach;
                    break;
            }
            ?>
        <?endforeach;?>
        <input type="submit">
    </form>
    <div id="submitAnswer" style="display: none"></div>
<?//$this->addExternalJS("/local/components/ml/submit.form/templates/.default/ajax.js");?>
    <script type="text/javascript">
        BX(function () {
            BX.bind(BX('feedForm'), 'submit', function (event) {
                event.preventDefault();
                let formData = new FormData(event.target),
                    signatureParams = formData.get('signedParams'),
                    hiddenDiv = formData.get('submitAnswer');

                formData.delete('signedParams');

                BX.ajax.runComponentAction('ml:submit.form', 'sendAnswer', {
                    mode:'class',
                    data: formData,
                    signedParameters: signatureParams
                }).then(function (response) {
                    hiddenDiv.innerHTML = response.data;
                    BX.show(hiddenDiv);
                });
            });
        });
    </script>

<!--
        $(function () {

        });
        fForm = $('#feedForm');
        // $.on('submit', fForm, function () {
        //
        // });
        fForm.submit((e) => {
            e.preventDefault();
            fForm.append('<input type="hidden" name="highload_value" value="' + <?/*=json_encode($arResult['HL_ID'])*/?> +'" /> ');

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
-->
<?endif;?>

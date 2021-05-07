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
            hiddenDiv.show(hiddenDiv).innerHTML = response.data;
        });
    });
});

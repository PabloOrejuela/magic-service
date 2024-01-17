$('#item').autocomplete({
    source: function(data, callback){
        $.ajax({
            url: 'get-item-cuantificable',
            method: 'GET',
            dataType: 'json',
            data: {
                name: data.term
            },
            success: function(res) {
                callback(res)
            }
        });
    }

});
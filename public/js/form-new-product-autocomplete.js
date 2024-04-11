aData = {}
    
$('#iditem').autocomplete({
    source: function(request, response){
        $.ajax({
            url: 'getItemsAutocomplete',
            method: 'GET',
            dataType: 'json',
            data: {
                item: request.term
            },
            success: function(res) {

                aData = $.map(res, function(value, key){
                    return{
                        id: value.id,
                        label: value.item + ' - ' + value.precio
                    };
                });
                let results = $.ui.autocomplete.filter(aData, request.term);
                response(results)
            }
        });
    },
    select: function(event, ui){
        //document.getElementById('idp').value = 10
        document.getElementById("idp").value = ui.item.id
        
    }
});
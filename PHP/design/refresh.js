
function refreshAjax(clas, val){
    $.ajax({
        url: "refresh.php?"+val,
        method: 'GET'
    }).done(function(json){
        let jso = JSON.parse(json);
        getDataTable(clas, jso.values);
    })
}

function getDataTable(clas, data){
    let el = $(clas+" tr");
    if(el.length > 15){
        $.each(data, function(i, va){
            let html = "<tr>" +
                "<td>"+va.value_captor+"</td>" +
                "<td>"+new Date(va.date_captor*1000)+"</td>" +
                "</tr>";
            el.prepend(html);
        });
    }else{
        el.last().remove();
        getDataTable(clas, data);
    }
}
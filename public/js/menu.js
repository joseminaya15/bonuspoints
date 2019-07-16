function goToMenu(id){
    location.href = id;
}
function cerrarCesion(){
	$.ajax({
      url  : 'menu/cerrarCesion',
      type : 'POST'
	}).done(function(data){
      try{
          data = JSON.parse(data);
          if(data.error == 0){
            location.href = 'Login';
          }else {
            return;
          }
      }catch(err){
        msj('error',err.message);
      }
	});
}
function searchPartNumber(e,element){
    if(e.keyCode === 13){
        e.preventDefault();
        var partNumber = element.val();
        var description = $("#description");
        var score = $("#score");
        $.ajax({
            url  : 'bill/searchPartNumber',
            type : 'POST',
            data : { PartNumber : partNumber }
        }).done(function(data){
            try{
                data = JSON.parse(data);
                console.log(data.error)
                if(data.error == 0){
                  description.val(data.description);
                  score.val(data.score);
                }else {
                    msj('error', data.msj);
                    return;
                }
            }catch(err){
              msj('error',err.message);
            }
        });
    }
}
function sendBill(){
    var partNumber  = $("#part_number").val();
    var description = $("#description").val();
    var score       = $("#score").val();
    var bill_number = $("#bill_number").val();
    var bill_date   = $("#bill_date").val();
    var quantity    = $("#quantity").val();
    var total       = $("#total").val();
    if(partNumber == null || partNumber == '') {
        msj('error', 'Numero de parte debe completarse');
        return;
    }
    if(description == null || description == '') {
        msj('error', 'Descripcion debe completarse');
        return;
    }
    if(score == null || score == '') {
        msj('error', 'Score debe completarse');
        return;
    }
    if(bill_number == null || bill_number == '') {
        msj('error', 'Numero de Factura debe completarse');
        return;
    }
    if(bill_date == null || bill_date == '') {
        msj('error', 'Fecha de Factura debe completarse');
        return;
    }
    if(quantity == null || quantity == '') {
        msj('error', 'Cantidad debe completarse');
        return;
    }
    if(total == null || total == '') {
        msj('error', 'Total debe completarse');
        return;
    }
    $.ajax({
        url  : 'bill/registerBill',
        type : 'POST',
        data : { PartNumber  : partNumber,
                 Description : description,
                 Score       : score,
                 BillNumber  : bill_number,
                 BillDate    : bill_date,
                 Quantity    : quantity,
                 Total       : total}
    }).done(function(data){
        try{
            data = JSON.parse(data);
            console.log(data.error)
            if(data.error == 0){
                $("#part_number").val("");
                $("#description").val("");
                $("#score").val("");
                $("#bill_number").val("");
                $("#bill_date").val("");
                $("#quantity").val("");
                $("#total").val("");
                msj('success', 'Se registro su factura correctamente');
            }else {
                msj('error', data.msj);
                return;
            }
        }catch(err){
          msj('error',err.message);
        }
    });
}
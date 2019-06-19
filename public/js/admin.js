function cerrarCesion(){
    $.ajax({
        url  : 'admin/cerrarCesion',
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
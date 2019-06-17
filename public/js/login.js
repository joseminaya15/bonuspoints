function ingresar(){
var usuario  = $('#correo').val();
var password = $('#password').val();
  var carpeta  = '';
if(usuario == null){
      msj('error', 'Ingrese su correo');
      return;
  }
  if(usuario != 'sapadmin'){
      if(usuario != 'ptadmin'){
          if (!validateEmail(usuario)){
              msj('error', 'El correo ingresado no tiene el formato correcto');
              return;
          }
      }
  }
if(password == null){
  msj('error', 'Ingrese su contraseña');
  return;
}
$.ajax({
  data : {usuario  : usuario,
      password : password,
              idioma   : idioma},
  url  : 'Login/ingresar',
  type : 'POST'
}).done(function(data){
  try{
          data = JSON.parse(data);
          if(data.error == 0){
            $('#correo').val("");
            $('#password').val("");
              location.href = data.href;
          }else {
              if(data.user == null || data.user == '' || data.user == undefined) {
                  if(data.pass == null || data.pass == '' || data.pass == undefined) {
                      msj('error', 'alguno de sus datos son incorrectos');
                  }else {
                      msj('error', data.pass);
                  }
              }else {
                  msj('error', data.user);
              }
            return;
          }
      }catch(err){
          msj('error',err.message);
      }
});
}

function validateEmail(email){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function verificarDatos(e){
    if(e.keyCode === 13){
        e.preventDefault();
        ingresar();
    }
}

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
var id_anular   = null;
var emailGlobal = null;
function anular(id, btn, user){
  $('#btnanular'+btn).prop('disabled', true);
  $('#btnaceptar'+btn).prop('disabled', true);
  $('#modalAnular').modal('show');
  id_anular   = id;
  emailGlobal = user;
}
function aceptar(id, btn){
  $('#btnanular'+btn).prop('disabled', true);
  $('#btnaceptar'+btn).prop('disabled', true);
  $.ajax({
      data : {id_serv : id},
      url  : 'admin/aceptarAnotacion',
      type : 'POST'
  }).done(function(data){
      try{
          data = JSON.parse(data);
          if(data.error == 0){
              $('#tabla').html('');
              $('#tabla').append(data.tabla);
          }else {
              return;
          }
      }catch(err){
          msj('error',err.message);
      }
  });
}
function contactar(ids, btns){
  $('#btncontactar'+btns).prop('disabled', true);
  $.ajax({
      data : {id_serv : ids},
      url  : 'admin/contactarUser',
      type : 'POST'
  }).done(function(data){
      try{
          data = JSON.parse(data);
          if(data.error == 0){
              $('#tabla').html('');
              $('#tabla').append(data.tabla);
          }else {
              return;
          }
      }catch(err){
          msj('error',err.message);
      }
  });
}
function cambiarIdioma(){
  var idioma = $('#Idioma').val();
  if(idioma == 'Español'){
      location.href = 'http://www.sap-latam.com/gana_por_goleada/es/Login';
  }else if(idioma == 'Portugués'){
      location.href = 'http://www.sap-latam.com/gana_por_goleada/pt/Login';
  } else if (idioma == 'Inglés') {
      location.href = 'http://www.sap-latam.com/gana_por_goleada/en/Login';
  }
  $.ajax({ 
      data  : {idioma : idioma},
      url   : 'Login/cambiarIdioma',
      type  : 'POST'
  }).done(function(data){
      try{
          data = JSON.parse(data);
          if(data.error == 0){
          }else{
              return;
          }
      } catch (err){
      msj('error',err.message);
      }
  });
}
function sendEmail(email){
  $.ajax({ 
      data  : {email : email},
      url   : 'Admin/sendEmail',
      type  : 'POST'
  }).done(function(data){
      try{
          data = JSON.parse(data);
          if(data.error == 0){
          }else{
            return;
          }
      } catch (err){
          msj('error',err.message);
      }
  });
}
function confirmarAnulacion(){
  var motivo = $('#empresa').val();
  if (motivo == null || motivo == '') {
      toastr.remove();
      msj('error', 'Indicar el motivo, por favor.');
      return;
  }
  $.ajax({
      data : {id_serv : id_anular,
              motivo  : motivo,
              email   : emailGlobal},
      url  : 'admin/anularAnotacion',
      type : 'POST'
  }).done(function(data){
      try{
          data = JSON.parse(data);
          if(data.error == 0){
              $('#tabla').html('');
              $('#tabla').append(data.tabla);
              $('#modalAnular').modal('hide');
          }else {
              return;
          }
      }catch(err){
          msj('error',err.message);
      }
  });
}
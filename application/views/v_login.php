<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"  content="IE=edge">
        <meta name="viewport"               content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <meta name="description"            content="Logistica S.A. | La mejor tecnología, las mejores marcas">
        <meta name="keywords"               content="Logistica S.A. | La mejor tecnología, las mejores marcas">
        <meta name="robots"                 content="Index,Follow">
        <meta name="date"                   content="March 1, 2019"/>
        <meta name="language"               content="en">
        <meta name="theme-color"            content="#FFFFFF">
        <title>Logistica S.A. | La mejor tecnología, las mejores marcas</title>
        <link rel="shortcut icon" href="<?php echo RUTA_IMG?>logo/favicon.png">
    	<link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>toaster/toastr.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>bootstrap-select/css/bootstrap-select.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>bootstrap/css/bootstrap.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>mdl/material.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_FONTS?>material-icons.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_FONTS?>opensans.css?v=<?php echo time();?>">
    	<link rel="stylesheet"    href="<?php echo RUTA_CSS?>m-p.min.css?v=<?php echo time();?>">
    	<link rel="stylesheet"    href="<?php echo RUTA_CSS?>style.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_CSS?>admin.css?v=<?php echo time();?>">
    </head>
    <body>
        <div class="js-header">
            <div class="js-header--left">
                <a href="Home"><img src="<?php echo RUTA_IMG?>logo/logo-logistica.svg"></a>
            </div>
            <div class="js-header--right">
                <p>Programa Incentivos</p>
            </div>
        </div>
        <section class="js-section js-height">
            <div class="js-fondo admin"></div>
            <div class="js-container js-flex">
                <div class="js-login">
                    <h2>Acceso a la Herramienta</h2>
                    <div class="col-xs-12 js-input m-0">
                        <label for="usuario">Usuario</label>
                        <input type="text" id="usuario" onkeyup="verificarDatos(event);">
                    </div>
                    <div class="col-xs-12 js-input m-0">
                        <label for="password">Contrase&ntilde;a</label>
                        <input type="password" id="password" onkeyup="verificarDatos(event);">
                    </div>
                    <div class="col-xs-12 js-radio">
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="remember">
                            <input type="checkbox" id="remember" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label">Remember me</span>
                        </label>
                    </div>
                    <div class="col-xs-12 p-0">
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect js-button js-button--login" onclick="ingresar()">Login</button>
                    </div>
                </div>
            </div>
        </section>
        <script src="<?php echo RUTA_JS?>jquery-3.2.1.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_JS?>jquery-1.11.2.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>bootstrap/js/bootstrap.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>bootstrap-select/js/bootstrap-select.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>bootstrap-select/js/i18n/defaults-es_ES.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>mdl/material.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>toaster/toastr.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_JS?>Utils.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_JS?>login.js?v=<?php echo time();?>"></script>
        <script type="text/javascript">
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
                $('select').selectpicker('mobile');
            } else {
                $('select').selectpicker();
            }
            $(document).ready(function(){
                let CHECK = sessionStorage.getItem('CHECK');
                let USERNAME = sessionStorage.getItem('USERNAME');
                let PASS = sessionStorage.getItem('PASS');
                if(CHECK == 1) {
                    $('#remember').prop('checked', true);
                    $('#usuario').val(USERNAME);
                    $('#password').val(PASS);
                }else {
                    $('#remember').prop('checked', false);
                    $('#usuario').val('');
                    $('#password').val('');
                }
            });
        </script>
    </body>
</html>
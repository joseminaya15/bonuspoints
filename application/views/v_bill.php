<!DOCTYPE html>
<html>
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
        <div class="js-header js-fixed">
            <div class="js-header--left">
                <img src="<?php echo RUTA_IMG?>logo/logo-logistica.svg">
            </div>
            <div class="js-header--right">
                <p class="menu">Programa Incentivos</p>
            </div>
        </div>
        <section id="menu">
            <div class="js-fondo menu"></div>
                <div class="js-container" style="margin-top: 100px;">
                    <div class="jm-menu">
                        <a href="Menu"><i class="mdi mdi-home"></i>Menu</a>
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button-login logout" onclick="cerrarCesion()">Cerrar Sesi&oacute;n</button>
                    </div>
                    <div class="jm-username">
                        <h2>Bienvenido(a) <?php echo $name == null ? '' : $name; ?> <?php echo $surname == null ? '' : $surname; ?></h2>
                        <p>Empresa <?php echo $company == null ? '' : $company; ?></p>
                    </div>
                    <div class="jm-container--cards">
                        <div id="Bill" class="jm-card jm-card-menu">
                            <div class="jm-card__title">
                                <img src="<?php echo RUTA_IMG?>menu/facturas.png">
                            </div>
                            <div class="jm-card__supporting-text">
                                <p>Nueva Factura</p>
                            </div>
                        </div>
                        <div class="jm-card__bill">
                            <div class="jm-card__title">
                                <h2>Registra tus Facturas</h2>
                            </div>
                            <div class="jm-card__content">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="texto" class="form-control" placeholder="Bucar Numero de Parte" id="part_number" onkeypress="searchPartNumber(event,$(this))">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="texto" class="form-control" placeholder="Descripción del producto" readonly id="description">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="texto" class="form-control" placeholder="Score" readonly id="score">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="texto" class="form-control" placeholder="Numero de Factura de Logistica" id="bill_number">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="texto" class="form-control" placeholder="Fecha de Factura" id="bill_date">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="texto" class="form-control" placeholder="Cantidad" id="quantity"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="texto" class="form-control" placeholder="Total de puntos" readonly id="total"> 
                                        </div>
                                    </div>
                                    <div class="col-xs-12 text-right">
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect js-button" onclick="sendBill()">Registrar Factura</button>
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="<?php echo RUTA_JS?>jquery-3.2.1.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_JS?>jquery-1.11.2.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>bootstrap/js/bootstrap.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>bootstrap-select/js/bootstrap-select.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>bootstrap-select/js/i18n/defaults-es_ES.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>toaster/toastr.js?v=<?php echo time();?>"></script>
        <script type="text/javascript" src="<?php echo RUTA_PLUGINS?>mdl/material.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_JS?>Utils.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_JS?>menu.js?v=<?php echo time();?>"></script>
    </body>
</html>
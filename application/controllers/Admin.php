<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model('M_datos');
        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
    }

	public function index(){
        if($this->session->userdata('usuario') == null){
            header("location: Login");
        }
        $datos = $this->M_datos->getDatosAdmin('Español');
        if(count($datos) == 0){
            $data['tabla'] = '';
        }else {
            $html      = null;
            $count     = 1;
            $i         = 1;
            $disabled  = '';
            $estado    = '';
            $disabled2 = '';
            foreach ($datos as $key){
                if($key->Flag == 1){
                    $disabled  = '';
                    $estado    = 'Pendiente';
                }
                if($key->Flag == 2){
                    $disabled  = '';
                    $estado    = 'Aprobado';
                }
                if($key->Flag == 3) {
                    $disabled  = '';
                    $estado    = 'Rechazado';
                }
                if($key->Flag == 4) {
                    $disabled  = '';
                    $estado    = 'Observado';
                }
                if($key->alertas == 1 || $key->Flag == 2 || $key->Flag == 3 || $key->Flag == 4){
                    $disabled2 = 'disabled';
                }else {
                    $disabled2 = '';
                }
                if($key->fecha != '0000-00-00' ) {
                    $fecha = date("d/m/Y", strtotime($key->fecha));    
                } else {
                    $fecha = '-';
                }
                $key->descripcion = ($key->descripcion != '' ) ? $key->descripcion : '-' ;
                $html .= '<tr>
                              <td class="text-center">'.$key->Deal_registration.'</td>
                              <td class="text-left">'.$key->Tipo_serv.'</td>
                              <td class="text-left">'.$key->Empresa.'</td>
                              <td class="text-left">'.$key->Nombre_canal.'</td>
                              <td class="text-left">'.$key->Nombre_capitan.'</td>
                              <td class="text-left">'.$key->Pais.'</td>
                              <td class="text-left">'.$key->descripcion.'</td>
                              <td class="text-left" width="80">'.$fecha.'</td>
                              <td class="text-left">'.$estado.'</td>
                              <td class="text-center" width="120">
                                  <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Rechazar" onclick="anular('.$key->Id.', '.$count.', &#39;'.$key->usuario.'&#39;)" id="btnanular'.$count.'" '.$disabled.'><i class="mdi mdi-close"></i></button>
                                  <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Aprobar" onclick="aceptar('.$key->Id.', '.$count.');sendEmail(&#39;'.$key->usuario.'&#39;);" id="btnaceptar'.$count.'" '.$disabled.'><i class="mdi mdi-done"></i></button>
                                  <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Contactar" onclick="contactar('.$key->Id.', '.$i.');" id="btncontactar'.$i.'" '.$disabled2.'><i class="mdi mdi-warning"></i></button>
                              </td>
                          </tr>';
                $count++;
            }
            $data['tabla'] = $html;
        }
    	$this->load->view('es/v_admin', $data);
	}

    function cerrarCesion(){
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $this->session->unset_userdata('usuario');
            $this->session->unset_userdata('Id_user');
            $data['error'] = EXIT_SUCCESS;
        } catch (Exception $e){
            $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
    }

    function anularAnotacion(){
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $id_serv   = $this->input->post('id_serv');
            $motivo    = $this->input->post('motivo');
            $email     = $this->input->post('email');
            $arrUpdt   = array('Flag'    => FLAG_RECHAZADO,
                               'alertas' => FLAG_RECHAZADO,
                               'motivo'  => $motivo);
            $datosUpdt = $this->M_datos->updateDatos($arrUpdt, $id_serv, 'anotaciones');
            $datos     = $this->M_datos->getDatosAdmin('Español');
            $count     = 1;
            $i         = 1;
            $disabled  = '';
            $estado    = '';
            $disabled2 = '';
            if(count($datos) == 0){
                $data['tabla'] = '';
            }else {
                $html = null;
                foreach ($datos as $key){
                    if($key->Flag == 1){
                        $disabled  = '';
                        $estado    = 'Pendiente';
                    }
                    if($key->Flag == 2){
                        $disabled  = '';
                        $estado    = 'Aprobado';
                    }
                    if($key->Flag == 3) {
                        $disabled  = '';
                        $estado    = 'Rechazado';
                    }
                    if($key->Flag == 4) {
                        $disabled  = '';
                        $estado    = 'Observado';
                    }
                    if($key->alertas == 1 || $key->Flag == 2 || $key->Flag == 3 || $key->Flag == 4){
                        $disabled2 = 'disabled';
                    }else {
                        $disabled2 = '';
                    }
                    if($key->fecha != '0000-00-00' ) {
                        $fecha = date("d/m/Y", strtotime($key->fecha));    
                    } else {
                        $fecha = '-';
                    }
                    $key->descripcion = ($key->descripcion != '' ) ? $key->descripcion : '-' ;
                    $html .= '<tr>
                                  <td class="text-center">'.$key->Deal_registration.'</td>
                                  <td class="text-left">'.$key->Tipo_serv.'</td>
                                  <td class="text-left">'.$key->Empresa.'</td>
                                  <td class="text-left">'.$key->Nombre_canal.'</td>
                                  <td class="text-left">'.$key->Nombre_capitan.'</td>
                                  <td class="text-left">'.$key->Pais.'</td>
                                  <td class="text-left">'.$key->descripcion.'</td>
                                  <td class="text-left" width="80">'.$fecha.'</td>
                                  <td class="text-left">'.$estado.'</td>
                                  <td class="text-center" width="120">
                                      <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Rechazar" onclick="anular('.$key->Id.', '.$count.', &#39;'.$key->usuario.'&#39;);" id="btnanular'.$count.'" '.$disabled.'><i class="mdi mdi-close"></i></button>
                                      <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Aprobar" onclick="aceptar('.$key->Id.', '.$count.');sendEmail(&#39;'.$key->usuario.'&#39;);" id="btnaceptar'.$count.'" '.$disabled.'><i class="mdi mdi-done"></i></button>
                                      <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Contactar" onclick="contactar('.$key->Id.', '.$i.');" id="btncontactar'.$i.'" '.$disabled2.'><i class="mdi mdi-warning"></i></button>
                                  </td>
                              </tr>';
                    $count++;
                }
                $data['tabla'] = $html;
            }
            $this->sendEmailAnula($motivo, $email);
            $data['error'] = EXIT_SUCCESS;
        } catch (Exception $e){
            $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
    }

    function aceptarAnotacion(){
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $id_serv   = $this->input->post('id_serv');
            $arrUpdt   = array('Flag' => FLAG_APROBADO,
                               'alertas' => FLAG_APROBADO,
                               'motivo'  => NULL);
            $datosUpdt = $this->M_datos->updateDatos($arrUpdt, $id_serv, 'anotaciones');
            $datos     = $this->M_datos->getDatosAdmin('Español');
            $count     = 1;
            $i         = 1;
            $disabled  = '';
            $estado    = '';
            $disabled2 = '';
            if(count($datos) == 0){
                $data['tabla'] = '';
            }else {
                $html = null;
                foreach ($datos as $key){
                    if($key->Flag == 1){
                        $disabled  = '';
                        $estado    = 'Pendiente';
                    }
                    if($key->Flag == 2){
                        $disabled  = '';
                        $estado    = 'Aprobado';
                    }
                    if($key->Flag == 3) {
                        $disabled  = '';
                        $estado    = 'Rechazado';
                    }
                    if($key->Flag == 4) {
                        $disabled  = '';
                        $estado    = 'Observado';
                    }
                    if($key->alertas == 1 || $key->Flag == 2 || $key->Flag == 3 || $key->Flag == 4){
                        $disabled2 = 'disabled';
                    }else if($key->alertas != 1 || $key->Flag == 1){
                        $disabled2 = '';
                    }
                    if($key->fecha != '0000-00-00' ) {
                        $fecha = date("d/m/Y", strtotime($key->fecha));    
                    } else {
                        $fecha = '-';
                    }
                    $key->descripcion = ($key->descripcion != '' ) ? $key->descripcion : '-' ;
                    $html .= '<tr>
                                  <td class="text-center">'.$key->Deal_registration.'</td>
                                  <td class="text-left">'.$key->Tipo_serv.'</td>
                                  <td class="text-left">'.$key->Empresa.'</td>
                                  <td class="text-left">'.$key->Nombre_canal.'</td>
                                  <td class="text-left">'.$key->Nombre_capitan.'</td>
                                  <td class="text-left">'.$key->Pais.'</td>
                                  <td class="text-left">'.$key->descripcion.'</td>
                                  <td class="text-left" width="80">'.$fecha.'</td>
                                  <td class="text-left">'.$estado.'</td>
                                  <td class="text-center" width="120">
                                      <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Rechazar" onclick="anular('.$key->Id.', '.$count.', &#39;'.$key->usuario.'&#39;);" id="btnanular'.$count.'" '.$disabled.'><i class="mdi mdi-close"></i></button>
                                      <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Aprobar" onclick="aceptar('.$key->Id.', '.$count.');sendEmail(&#39;'.$key->usuario.'&#39;);" id="btnaceptar'.$count.'" '.$disabled.'><i class="mdi mdi-done"></i></button>
                                      <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Contactar" onclick="contactar('.$key->Id.', '.$i.');" id="btncontactar'.$i.'" '.$disabled2.'><i class="mdi mdi-warning"></i></button>
                                  </td>
                              </tr>';
                    $count++;
                }
                $data['tabla'] = $html;
            }
            $data['error'] = EXIT_SUCCESS;
        } catch (Exception $e){
            $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
    }

    function contactarUser(){
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $id_serv   = $this->input->post('id_serv');
            $arrUpdt   = array('Flag' => FLAG_OBSERVADO,
                               'alertas' => FLAG_OBSERVADO);
            $datosUpdt = $this->M_datos->updateDatos($arrUpdt, $id_serv, 'anotaciones');
            $datos     = $this->M_datos->getDatosAdmin('Español');
            $count     = 1;
            $i         = 1;
            $disabled  = '';
            $estado    = '';
            $disabled2 = '';
            if(count($datos) == 0){
                $data['tabla'] = '';
            }else {
                $html = null;
                foreach ($datos as $key){
                    if($key->Flag == 1){
                        $disabled  = '';
                        $estado    = 'Pendiente';
                    }
                    if($key->Flag == 2){
                        $disabled  = '';
                        $estado    = 'Aprobado';
                    }
                    if($key->Flag == 3) {
                        $disabled  = '';
                        $estado    = 'Rechazado';
                    }
                    if($key->Flag == 4) {
                        $disabled  = '';
                        $estado    = 'Observado';
                    }
                    if($key->alertas == 1 || $key->Flag == 2 || $key->Flag == 3 || $key->Flag == 4){
                        $disabled2 = 'disabled';
                    }else {
                        $disabled2 = '';
                    }
                    if($key->fecha != '0000-00-00' ) {
                        $fecha = date("d/m/Y", strtotime($key->fecha));    
                    } else {
                        $fecha = '-';
                    }
                    $key->descripcion = ($key->descripcion != '' ) ? $key->descripcion : '-' ;
                    $html .= '<tr>
                                <td class="text-center">'.$key->Deal_registration.'</td>
                                <td class="text-left">'.$key->Tipo_serv.'</td>
                                <td class="text-left">'.$key->Empresa.'</td>
                                <td class="text-left">'.$key->Nombre_canal.'</td>
                                <td class="text-left">'.$key->Nombre_capitan.'</td>
                                <td class="text-left">'.$key->Pais.'</td>
                                <td class="text-left">'.$key->descripcion.'</td>
                                <td class="text-left" width="80">'.$fecha.'</td>
                                <td class="text-left">'.$estado.'</td>
                                <td class="text-center" width="120">
                                <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Rechazar" onclick="anular('.$key->Id.', '.$count.', &#39;'.$key->usuario.'&#39;);" id="btnanular'.$count.'" '.$disabled.'><i class="mdi mdi-close"></i></button>
                                <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Aprobar" onclick="aceptar('.$key->Id.', '.$count.');sendEmail(&#39;'.$key->usuario.'&#39;);" id="btnaceptar'.$count.'" '.$disabled.'><i class="mdi mdi-done"></i></button>
                                <button type="button" class="mdl-button mdl-js-button mdl-button--icon" data-toggle="tooltip" data-placement="bottom" title="Contactar" onclick="contactar('.$key->Id.', '.$i.');" id="btncontactar'.$i.'" '.$disabled2.'><i class="mdi mdi-warning"></i></button>
                                </td>
                            </tr>';
                    $count++;
                    $i++;
                }
                $data['tabla'] = $html;
            }
            $data['error'] = EXIT_SUCCESS;
        } catch (Exception $e){
            $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
    }

    function sendEmail(){
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $email_partner = $this->input->post('email');
            $this->load->library("email");
            $configGmail = array('protocol'  => 'smtp',
                                 'smtp_host' => 'smtpout.secureserver.net',
                                 'smtp_port' => 3535,
                                 'smtp_user' => 'info@marketinghpe.com',
                                 'smtp_pass' => 'h#120918Pe',
                                 'mailtype'  => 'html',
                                 'charset'   => 'utf-8',
                                 'newline'   => "\r\n");
            $this->email->initialize($configGmail);
            $this->email->from('info@sap-latam.com');
            $this->email->to($email_partner);
            $this->email->subject('Gracias por tu participación. Tu postulación ya fue evaluada en SAP Gana por Goleada.');
            $texto = '<!DOCTYPE html>
                        <html>
                            <body>
                                <table width="500px" cellpadding="0" cellspacing="0" align="center" style="border: solid 1px #ccc;">
                                    <tr>
                                        <td>
                                            <table width="500" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #000000;">
                                                <tr>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td style="padding-left: 25px;"><a href="#"><img src="http://www.sap-latam.com/gana_por_goleada/public/img/logo/logo_home.png" width="175" alt="alternative text" border="0" style="display: block;"></a></td>
                                                                <td></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="0" border="0" align="right">
                                                            <tr>
                                                                <td style="height: 80px;width: 20px;background-color: #54442E;"></td>
                                                                <td style="height: 80px;width: 20px;background-color: #8D6832;"></td>
                                                                <td style="height: 80px;width: 20px;background-color: #E29D2E;"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="400" cellspacing="0" cellpadding="0" border="0" align="center" style="padding: 30px 0">
                                                <tr>
                                                    <td style="text-align: center;padding: 0;margin: 0;padding: 20px 0 5px 0;"><img width="180" src="http://www.sap-latam.com/gana_por_goleada/public/img/logo/logo_login.png"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;padding: 0;margin: 0;padding: 10px 0 5px 0;"><font style="font-family: arial;color: #000000;font-size: 18px;font-weight: 600">Estimado Socio de Negocios:</font></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;padding-top: 10px;padding: 5px 0 30px 0;"><font style="font-family: arial;color: #757575;font-size: 14px;">Muchas gracias por tu participación.  Tu postulación ya fue evaluada. Conoce el resultado ingresando al portal con tu contraseña.</font></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;padding: 2px 0;line-height: 16px;"><font style="font-family: arial;color: #757575;font-size: 14px;">Saludos,</font></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;padding: 2px 0;line-height: 16px;"><font style="font-family: arial;color: #757575;font-size: 14px;">Team SAP</font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </body>
                        </html>';
            $this->email->message($texto);
            $this->email->send();
            $data['error'] = EXIT_SUCCESS;
        }catch (Exception $e){
            $data['msj'] = $e->getMessage();
        }
        echo json_encode(array_map('utf8_encode', $data));
    }

    function sendEmailAnula($motivo = null, $email = null){
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $email_partner =  $email;
            $texto1 = 'Lamentamos informarles que su postulación ha sido rechazada. La razón te lo explicamos aquí: '.$motivo ;
            $this->load->library("email");
            $configGmail = array('protocol'  => 'smtp',
                                 'smtp_host' => 'smtpout.secureserver.net',
                                 'smtp_port' => 3535,
                                 'smtp_user' => 'info@marketinghpe.com',
                                 'smtp_pass' => 'h#120918Pe',
                                 'mailtype'  => 'html',
                                 'charset'   => 'utf-8',
                                 'newline'   => "\r\n");
            $this->email->initialize($configGmail);
            $this->email->from('info@sap-latam.com');
            $this->email->to('pyf136@gmail.com'/*$email_partner*/);
            $this->email->subject('Gracias por tu participación. Tu postulación ya fue evaluada en SAP Gana por Goleada.');
            $texto = '<!DOCTYPE html>
                        <html>
                            <body>
                                <table width="500px" cellpadding="0" cellspacing="0" align="center" style="border: solid 1px #ccc;">
                                    <tr>
                                        <td>
                                            <table width="500" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #000000;">
                                                <tr>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td style="padding-left: 25px;"><a href="#"><img src="http://www.sap-latam.com/gana_por_goleada/public/img/logo/logo_home.png" width="175" alt="alternative text" border="0" style="display: block;"></a></td>
                                                                <td></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="0" border="0" align="right">
                                                            <tr>
                                                                <td style="height: 80px;width: 20px;background-color: #54442E;"></td>
                                                                <td style="height: 80px;width: 20px;background-color: #8D6832;"></td>
                                                                <td style="height: 80px;width: 20px;background-color: #E29D2E;"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="400" cellspacing="0" cellpadding="0" border="0" align="center" style="padding: 30px 0">
                                                <tr>
                                                    <td style="text-align: center;padding: 0;margin: 0;padding: 20px 0 5px 0;"><img width="180" src="http://www.sap-latam.com/gana_por_goleada/public/img/logo/logo_login.png"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;padding: 0;margin: 0;padding: 10px 0 5px 0;"><font style="font-family: arial;color: #000000;font-size: 18px;font-weight: 600">Estimado Socio de Negocios:</font></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;padding-top: 10px;padding: 5px 0 30px 0;"><font style="font-family: arial;color: #757575;font-size: 14px;">'.$texto1.'</font></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;padding: 2px 0;line-height: 16px;"><font style="font-family: arial;color: #757575;font-size: 14px;">Saludos,</font></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;padding: 2px 0;line-height: 16px;"><font style="font-family: arial;color: #757575;font-size: 14px;">Team SAP</font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </body>
                        </html>';
            $this->email->message($texto);
            $this->email->send();
            $data['error'] = EXIT_SUCCESS;
        }catch (Exception $e){
            $data['msj'] = $e->getMessage();
        }
        return json_encode(array_map('utf8_encode', $data));
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper("url");
        // $this->load->model('M_datos');
        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
    }
	public function index(){
        if($this->session->userdata('usuario') == null){
            header("location: Login");
        }
        $data['name'] = ucwords($this->session->userdata('Nombre'));
        $data['surname'] = ucwords($this->session->userdata('Apellido'));
        $data['company']   = ucwords($this->session->userdata('Empresa'));
		$this->load->view('v_bill', $data);
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
    // function nuevaAnotacion(){
    //     $data['error'] = EXIT_ERROR;
    //     $data['msj']   = null;
    //     try {
    //         $empresa  = $this->input->post('empresa');
    //         $deal_reg = $this->input->post('deal_regis');
    //         $descrip  = $this->input->post('descripcion');
    //         $pais     = $this->input->post('pais');
    //         $fecha    = $this->input->post('fecha');
    //         $goles    = $this->input->post('goles');
    //         $servicio = $this->input->post('servicio');
    //         $id_serv  = null;
    //         $arr_fecha = explode("/", $fecha);
    //         $fechaServidor = date("Y-m-d");
    //         if(checkdate($arr_fecha[1], $arr_fecha[0], $arr_fecha[2]) == false){
    //             $data['msj'] = 'La fecha ingresada no es correcta';
    //         }else {
    //             $id_serv = $this->M_datos->getIdServicioByNombre($servicio);
    //             /*if($servicio == 'Cuentas nuevas (NNN)'){
    //                 $id_serv = 1;
    //             }else if($servicio == 'Oportunidades generadas de Social Selling'){
    //                 $id_serv = 2;
    //             }else if($servicio == 'Oportunidades generadas para Cloud'){
    //                 $id_serv = 3;
    //             }else if($servicio == 'Casos de éxitos de clientes aprobados'){
    //                 $id_serv = 4;
    //             }else if($servicio == 'Won & Booked (W/B)'){
    //                 $id_serv = 5;
    //             }*/
    //             $dataInsert = array('Empresa'           => $empresa,
    //                                 'Deal_registration' => $deal_reg,
    //                                 'descripcion'       => $descrip,
    //                                 'Pais'              => $pais,
    //                                 'Flag'              => FLAG_PENDIENTE,
    //                                 'Goles'             => $goles,
    //                                 'Id_serv'           => $id_serv,
    //                                 'id_user'           => $this->session->userdata('Id_user'),
    //                                 'flg_pais'          => 1,
    //                                 'fecha'             => $fechaServidor,
    //                                 'lenguaje'          => $this->session->userdata('idioma'));
    //             $datosInsert = $this->M_datos->insertarDatos($dataInsert, 'anotaciones');
    //             $this->sendEmailAnotacion($this->session->userdata('usuario'));
    //             $this->sendEmailAdmin();
    //         }
    //         $data['error'] = EXIT_SUCCESS;
    //     }catch(Exception $e){
    //         $data['msj'] = $e->getMessage();
    //     }
    //     echo json_encode($data);
    // }
    // function sendEmailAnotacion($email){
    //     $data['error'] = EXIT_ERROR;
    //     $data['msj']   = null;
    //     try {  
    //         $this->load->library("email");
    //         $configGmail = array('protocol' => 'smtp',
    //                             'smtp_host' => 'smtpout.secureserver.net',
    //                             'smtp_port' => 3535,
    //                             'smtp_user' => 'info@marketinghpe.com',
    //                             'smtp_pass' => 'h#120918Pe',
    //                             'mailtype'  => 'html',
    //                             'charset'   => 'utf-8',
    //                             'newline'   => "\r\n");
    //         $this->email->initialize($configGmail);
    //         $this->email->from('info@sap-latam.com');
    //         $this->email->to($email);
    //         $this->email->subject('Gracias por tu participación en SAP Gana por Goleada');
    //         $texto = '<!DOCTYPE html>
    //                     <html>
    //                         <body>
    //                             <table width="500px" cellpadding="0" cellspacing="0" align="center" style="border: solid 1px #ccc;">
    //                                 <tr>
    //                                     <td>
    //                                         <table width="500" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #000000;">
    //                                             <tr>
    //                                                 <td>
    //                                                     <table>
    //                                                         <tr>
    //                                                             <td style="padding-left: 25px;"><a href="#"><img src="http://www.sap-latam.com/gana_por_goleada/public/img/logo/logo_home.png" width="175" alt="alternative text" border="0" style="display: block;"></a></td>
    //                                                             <td></td>
    //                                                         </tr>
    //                                                     </table>
    //                                                 </td>
    //                                                 <td>
    //                                                     <table cellspacing="0" cellpadding="0" border="0" align="right">
    //                                                         <tr>
    //                                                             <td style="height: 80px;width: 20px;background-color: #54442E;"></td>
    //                                                             <td style="height: 80px;width: 20px;background-color: #8D6832;"></td>
    //                                                             <td style="height: 80px;width: 20px;background-color: #E29D2E;"></td>
    //                                                         </tr>
    //                                                     </table>
    //                                                 </td>
    //                                             </tr>
    //                                         </table>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>
    //                                         <table width="400" cellspacing="0" cellpadding="0" border="0" align="center" style="padding: 30px 0">
    //                                             <tr>
    //                                                 <td style="text-align: center;padding: 0;margin: 0;padding: 20px 0 5px 0;"><img width="180" src="http://www.sap-latam.com/gana_por_goleada/public/img/logo/logo_login.png"></td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td style="text-align: center;padding: 0;margin: 0;padding: 10px 0 5px 0;"><font style="font-family: arial;color: #000000;font-size: 18px;font-weight: 600">¡Gracias por participar!</font></td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td style="text-align: center;padding-top: 10px;padding: 5px 0 30px 0;"><font style="font-family: arial;color: #757575;font-size: 14px;">En breve su puntuaci&oacute;n se reflejar&aacute; en la tabla de anotaciones.</font></td>
    //                                             </tr>
    //                                         </table>
    //                                     </td>
    //                                 </tr>
    //                             </table>
    //                         </body>
    //                     </html>';
    //         $this->email->message($texto);
    //         $this->email->send();
    //         $data['error'] = EXIT_SUCCESS;
    //     }catch (Exception $e){
    //         $data['msj'] = $e->getMessage();
    //     }
    //     return json_encode(array_map('utf8_encode', $data));
    // }
    // function sendEmailAdmin(){
    //     $data['error'] = EXIT_ERROR;
    //     $data['msj']   = null;
    //     try {  
    //         $this->load->library("email");
    //         $configGmail = array('protocol' => 'smtp',
    //                             'smtp_host' => 'smtpout.secureserver.net',
    //                             'smtp_port' => 3535,
    //                             'smtp_user' => 'info@marketinghpe.com',
    //                             'smtp_pass' => 'h#120918Pe',
    //                             'mailtype'  => 'html',
    //                             'charset'   => 'utf-8',
    //                             'newline'   => "\r\n");
    //         $this->email->initialize($configGmail);
    //         $this->email->from('info@sap-latam.com');
    //         $this->email->to('jhonatanibericom@gmail.com');
    //         $this->email->subject('Un nuevo registro ha sido ingresado para evaluación en SAP Gana por Goleada.');
    //         $texto = '<!DOCTYPE html>
    //                     <html>
    //                         <body>
    //                             <table width="500px" cellpadding="0" cellspacing="0" align="center" style="border: solid 1px #ccc;">
    //                                 <tr>
    //                                     <td>
    //                                         <table width="500" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #000000;">
    //                                             <tr>
    //                                                 <td>
    //                                                     <table>
    //                                                         <tr>
    //                                                             <td style="padding-left: 25px;"><a href="#"><img src="http://www.sap-latam.com/gana_por_goleada/public/img/logo/logo_home.png" width="175" alt="alternative text" border="0" style="display: block;"></a></td>
    //                                                             <td></td>
    //                                                         </tr>
    //                                                     </table>
    //                                                 </td>
    //                                                 <td>
    //                                                     <table cellspacing="0" cellpadding="0" border="0" align="right">
    //                                                         <tr>
    //                                                             <td style="height: 80px;width: 20px;background-color: #54442E;"></td>
    //                                                             <td style="height: 80px;width: 20px;background-color: #8D6832;"></td>
    //                                                             <td style="height: 80px;width: 20px;background-color: #E29D2E;"></td>
    //                                                         </tr>
    //                                                     </table>
    //                                                 </td>
    //                                             </tr>
    //                                         </table>
    //                                     </td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>
    //                                         <table width="400" cellspacing="0" cellpadding="0" border="0" align="center" style="padding: 30px 0">
    //                                             <tr>
    //                                                 <td style="text-align: center;padding: 0;margin: 0;padding: 20px 0 5px 0;"><img width="180" src="http://www.sap-latam.com/gana_por_goleada/public/img/logo/logo_login.png"></td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td style="text-align: center;padding: 0;margin: 0;padding: 10px 0 5px 0;"><font style="font-family: arial;color: #000000;font-size: 18px;font-weight: 600">Estimado Administrador:</font></td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td style="text-align: center;padding-top: 10px;padding: 5px 0 30px 0;"><font style="font-family: arial;color: #757575;font-size: 14px;">Una nueva nominación ha sido subida al sistema para su evaluación.</font></td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td style="text-align: center;padding: 2px 0;line-height: 16px;"><font style="font-family: arial;color: #757575;font-size: 14px;">Saludos,</font></td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td style="text-align: center;padding: 2px 0;line-height: 16px;"><font style="font-family: arial;color: #757575;font-size: 14px;">Team SAP</font></td>
    //                                             </tr>
    //                                         </table>
    //                                     </td>
    //                                 </tr>
    //                             </table>
    //                         </body>
    //                     </html>';
    //         $this->email->message($texto);
    //         $this->email->send();
    //         $data['error'] = EXIT_SUCCESS;
    //     }catch (Exception $e){
    //         $data['msj'] = $e->getMessage();
    //     }
    //     return json_encode(array_map('utf8_encode', $data));
    // }
}
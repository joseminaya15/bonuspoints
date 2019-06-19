<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('M_login');
        $this->load->helper("url");
        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
    }

	public function index(){
		$this->session->unset_userdata('user');
	    $this->session->unset_userdata('Id_user');
		$this->load->view('v_login');
    }
    
	function ingresar(){
		$data['error'] = EXIT_ERROR;
        $data['msj']   = null;
         try {
			$usuario  = $this->input->post('Usuario');
			$password = $this->input->post('Password');
			if($usuario == 'logisticaadmin' && $password == 'admin'){
				$data['href'] = 'Admin';
				$session = array('usuario' => $usuario);
			    $this->session->set_userdata($session);
				$data['error'] = EXIT_SUCCESS;
			}else {
				$username = $this->M_login->verificarUsuario($usuario);
				if(count($username) == 0) {
					$data['user'] = 'Este usuario no existe';
				}else {
					if($password == base64_decode($username[0]->password)){
					if(count($username) != 0){
						if(strtolower($username[0]->email) == strtolower($usuario)){
							$session = array('usuario'   => $usuario,
											 'Nombre'    => $username[0]->name,
											 'Apellido'  => $username[0]->surname,
											 'Empresa'   => $username[0]->company,
											 'Id_user' 	 => $username[0]->Id);
			          		$this->session->set_userdata($session);
			          		$data['href'] = 'Menu';
			          		$data['error'] = EXIT_SUCCESS;
							}
						}
					}else {
						$data['pass'] = 'La contraseña es incorrecta';
					}
				}
			}
        }catch(Exception $e) {
           $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
	}
}
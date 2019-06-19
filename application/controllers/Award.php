<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Award extends CI_Controller {

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
		$this->load->view('v_award', $data);
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
}
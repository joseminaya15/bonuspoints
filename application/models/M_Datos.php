<?php

class M_Datos extends  CI_Model{
    function __construct(){
        parent::__construct();
    }

    function insertarDatos($insertParticipante, $tabla){
        $this->db->insert($tabla, $insertParticipante);
        $sql = $this->db->insert_id();
        if($this->db->affected_rows() != 1) {
            throw new Exception('Error al insertar');
            $data['error'] = EXIT_ERROR;
        }
        return array("error" => EXIT_SUCCESS, "msj" => MSJ_INS, "Id" => $sql);
    }

    function insertarFactura($insertBill, $tabla){
        $this->db->insert($tabla, $insertBill);
        $sql = $this->db->insert_id();
        if($this->db->affected_rows() != 1) {
            throw new Exception('Error al insertar');
            $data['error'] = EXIT_ERROR;
        }
        return array("error" => EXIT_SUCCESS, "msj" => MSJ_INS, "Id" => $sql);
    }

    function existCorreo($correo){
        $sql = "SELECT email
                  FROM users
                  WHERE email = ?";
        $result = $this->db->query($sql, array($correo));
        return $result->result();
    }

    function existPartNumber($partnumber){
        $sql = "SELECT * 
                    FROM bill 
                    WHERE part_number = '".$partnumber."'";
        $result = $this->db->query($sql);
        return $result->result();
    }
}
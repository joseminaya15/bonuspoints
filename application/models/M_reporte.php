<?php

class M_reporte extends  CI_Model{
    function __construct(){
        parent::__construct();
    }

    function getDatosAdmin(){
        $sql = "SELECT b.Id,
                       b.bill_number,
                       b.part_number,
                       b.description,
                       b.flag_status,
                       b.score,
                       b.bill_date,
                       b.alertas,
                       b.register_date,
                       u.name,
                       u.surname,
                       u.company,
                       u.email
                  FROM bill b,
                       users u
                 WHERE b.id_user = u.Id
                   AND b.flag_status IN (1,2,3)
              ORDER BY b.flag_status, b.bill_number ASC";
        $result = $this->db->query($sql);
        return $result->result();
    }
}
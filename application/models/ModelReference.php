<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ModelReference extends CI_model {

    public function getCodeReference($kode) {
        $this->db->where("kode_ref", $kode);
        $this->db->where("is_active", 1);
        $query = $this->db->get("mst_reference");
        
        return $query;
    }
    
    public function getHistoryAll(){
        $this->db->order_by('tgl','DESC');
        $result = $this->db->get('history_akses');
        return $result->result();
    }
}
<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ModelCustomer extends CI_model {

    public function getCustomerBy($key, $val){
        $criteria = array('mst_customer.is_active' => 1);
        if($key == "id"){ $criteria = array('mst_customer.id_customer' => $val); }
        if($key == "name"){ $criteria = array('mst_customer.name_cust' => $val); }
        if($key == "find"){ $criteria = 'name_cust LIKE "%'.$val.'%"'; }
        $this->db->where($criteria);
        $this->db->order_by('id_customer DESC'); 
        $this->db->from('mst_customer');
        $this->db->select('mst_customer.*');
        $query = $this->db->get()->result();      
        return $query;
    }
    
    public function InsertCust($pushdata, $kode){
        $this->db->trans_begin();        
        $save = $this->db->insert('mst_customer', $pushdata);
         if($save){
             $history = inserthistory("input data pelanggan", $kode, "mst_item",$this->session->userdata('useradminlog'));
         }
         
        if (!isset($save) || !isset($history)) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        }         
    }
    
    public function updateCust($pushdata, $idkey, $act){
        $this->db->trans_begin(); 
        $this->db->where("id_customer", $idkey);
        $this->db->update('mst_customer', $pushdata);
        if($this->db->affected_rows() > 0){
            if($act === "edit"){
                inserthistory("mengubah data pelanggan", $idkey, "mst_item",$this->session->userdata('useradminlog'));
            }else{
                inserthistory("menghapus data pelanggan", $idkey, "mst_item",$this->session->userdata('useradminlog'));
            }
         }
         
        if ($this->db->trans_status === FALSE) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        }         
    }
}
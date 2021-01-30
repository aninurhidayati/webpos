<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ModelDataUser extends CI_model {
    
    public function getDataUserAdmin(){     
        $this->db->where("is_active", 1);
        $this->db->order_by('username ASC'); 
        $query = $this->db->get("mst_user");        
        return $query->result();
    }
    
    public function getUserAdminByID($id){     
        $this->db->where("iduser", $id);
        $this->db->order_by('username ASC'); 
        $query = $this->db->get("mst_user");        
        return $query->result();
    }
    
    public function checkUsername($us){
        $this->db->select("mst_user.*")
        ->from("mst_user")
        ->where("mst_user.username", $us);        
        $query = $this->db->get();        
        return $query->num_rows();
    }
    
    public function insertDataUser($pushdata){
        $this->db->trans_begin();  
        $qsave = $this->db->insert('mst_user', $pushdata);        
        $idkey = $this->db->insert_id();
         if($idkey > 0){
            $qhistory = inserthistory("tambah(input) data user login pegawai", $idkey, "mst_user",$this->session->userdata('useradminlog'));
         }
         
         if ($this->db->trans_status === FALSE || !isset($qsave) || !isset($qhistory)) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        } 
    }
    
    public function updateDataUser($idkey, $pushdata, $msg){
        $this->db->trans_begin();  
        $qsave = $this->db->where("iduser", $idkey)
                ->update('mst_user', $pushdata);
        $qhistory = inserthistory("".$msg." data user login pegawai", $idkey, "mst_user",$this->session->userdata('useradminlog'));
         
         if ($this->db->trans_status === FALSE || !isset($qsave) || !isset($qhistory)) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        } 
    }
}
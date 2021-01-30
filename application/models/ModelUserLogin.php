<?php
if (!defined('BASEPATH')){  exit('No direct script access allowed'); }

class ModelUserLogin extends CI_model {
    public function getLoginAdmin($user, $pass){
        $this->db->where("username", $user);
        $this->db->where("password", $pass);
        $this->db->where("is_active", 1);
        $query = $this->db->get("mst_user");
        if($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $resdata = array(
                    "adminID" => $row->iduser,
                    "useradminlog" =>$row->username,  
                    "namapegawai" =>$row->fullname);
                $this->session->set_userdata($resdata);
                redirect("DataBarang");
            }
        }else{
            $this->session->set_flashdata('infologin', "Username atau Password tidak sesuai!!");
            redirect("");
        }
    }  
}
<?php 
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Model_Security extends CI_model {
    public function __construct(){
        parent::__construct();
    }   
    
    public function getSecurityAdmin()
    {
        $username = $this->session->userdata('useradminlog');
        if(empty($username)){
            $arrsession = array('useradminlog','namapegawai');
            $this->session->unset_userdata($arrsession);
            redirect('');
        }
    }
}
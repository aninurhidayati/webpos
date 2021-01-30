<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->Model_Security->getSecurityAdmin();
        //$this->load->model("ModelUserLogin");
    }

    public function index()
    {
        $item['page_content'] = "v_dashboard";
        $item['page_title'] = "Data User Login";
        $item['modul'] = $this->uri->segment(1);
        $item['action'] = $this->uri->segment(2);
        $item['breadcrumb1'] = "Home";
        //$item['menulist'] = $this->ModelHakAkses->getMenuByAkses($this->session->userdata('levelakses'));
        return $this->load->view('v_home', $item);
    }
    
    public function logout(){
        $arrsession = array('adminID','useradminlog','namapegawai');
        $this->session->unset_userdata($arrsession);
        redirect('');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminLogin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("ModelUserLogin");
    }
    
    public function index()
    {
        $data['titlehead'] = "Login Pegawai ( Admin ) ";
        $data['modul'] = $this->uri->segment(1);
        $data['action'] = $this->uri->segment(2);
        return $this->load->view('admin/AdminLoginView', $data);
    }
    
    public function ceklogin(){
        $user = $this->input->post("username");
        $pass = md5($this->input->post("password"));
        $this->ModelUserLogin->getLoginAdmin($user, $pass);
    }
    
    public function logout(){
        $arrsession = array('adminID'=>'', 'namapegawai'=>'', 'divisi'=>'','useradminlog'=>'','levelakses'=>'');
        $this->session->unset_userdata($arrsession);
        redirect('AdminLogin');
    }
    
    public function ForgotPassword(){
        $data['titlehead'] = "Reset Password ";
        $data['modul'] = $this->uri->segment(1);
        $data['action'] = $this->uri->segment(2);
        return $this->load->view('admin/AdminLoginView', $data);
    }
    
}
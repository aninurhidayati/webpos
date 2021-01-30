<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataUser extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->Model_Security->getSecurityAdmin();
        $this->load->model("ModelDataUser"); 
    }
    
    private function headload($pushdata){
        $item = array(
            'page_content' => "v_user",
            'page_title' => "Data User Login Pegawai",
            'modul' => $this->uri->segment(1),
            'action' => $this->uri->segment(2),
            'breadcrumb1' => "Home"
            );
        return $this->load->view('v_home', array_merge($item, $pushdata));
    }
    
    public function index(){
        $data = array(
            'breadcrumb2' => "",
            'listdatauser' => $this->ModelDataUser->getDataUserAdmin() 
        );
        $this->headload($data);
    }
    
    public function input(){
        $data = array(
            'breadcrumb2' => '', 'titleform' => 'Form Data User Login Pegawai',
            'iduser' => 0, 'username' => '', 'nama' => '', 
            'idlevel' => 0, 'password' => ''
        );
        $this->headload($data);
    }
    
    public function detail(){
        $idkey = base64_decode($this->uri->segment(3));
        $qry = $this->ModelDataUser->getUserAdminByID($idkey);
        $data = array(
            'breadcrumb2' => 'Data User Login Pegawai', 'titleform' => 'Form Data User Login Pegawai',
            'iduser' => $idkey, 'username' => $qry[0]->username, 
            'nama' =>  $qry[0]->fullname, 'password' =>  $qry[0]->password
        );
        $this->headload($data);
    }
    
    public function save(){        
        
        $idkey = $this->input->post('idkey');
        $data = array(
            'fullname' => $this->input->post('nmlengkap'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('pass_newus')),
            'is_active' => 1
        );
        if($idkey > 0){
            //echo 'update'.$idkey;
            $qsave = $this->ModelDataUser->updateDataUser($idkey, $data, "Ubah(edit)");
        } else {
            //username sudah ada belum
            $qcek = $this->ModelDataUser->checkUsername($this->input->post('username'));
            if($qcek > 0){
                $this->session->set_flashdata('msg_saveuser', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                        <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                        <b>Username sudah digunakan!! silahkan gunakan username yg lain </b>
                        </div>');
                redirect('DataUser/input');
            }else{
            $qsave = $this->ModelDataUser->insertDataUser($data); }
        }
        if ($qsave === TRUE){
            $this->session->set_flashdata('msg_saveuser', '<div class="alert alert-success alert-st-one" role="alert">
                    <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <b>Simpan Data Hak Akses Berhasil</b>
                    </div>');
            redirect('DataUser');
        } else {
            $this->session->set_flashdata('msg_saveuser', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                    <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <b> Gagal Simpan Data Hak Akses </b>
                    </div>');
            redirect('DataUser/input');
        }   
    }
    
    public function delete(){
        $data = array('is_active' => 0);
        $qsave = $this->ModelDataUser->updateDataUser(base64_decode($this->uri->segment(3)), $data, "Hapus(NonAktif)");
        if ($qsave === TRUE){
            $this->session->set_flashdata('msg_saveuser', '<div class="alert alert-success alert-st-one" role="alert">
                    <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <b>Data Berhasil di hapus</b>
                    </div>');            
        } else {
            $this->session->set_flashdata('msg_saveuser', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                    <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    Gagal Hapus Data 
                    </div>');
        }   
        redirect('DataUser');
    }
    
}
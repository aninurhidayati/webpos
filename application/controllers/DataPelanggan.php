<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataPelanggan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->Model_Security->getSecurityAdmin();
        $this->load->model('ModelCustomer');
    }
    
    private function headload($pushdata){
        $item = array(
            'page_content' => "v_pelanggan",            
            'modul' => $this->uri->segment(1),
            'action' => $this->uri->segment(2),
            'breadcrumb1' => "Home",
            'breadcrumb2' => "Data Pelanggan"            
        );
        return $this->load->view('v_home', array_merge($item, $pushdata));
    }
    
    public function index()
    {
        $query = $this->ModelCustomer->getCustomerBy("","");
        $data = array( 'titleform' => "", 'page_title' => "Master Data Pelanggan");
        $data['list_item'] = $query;
        $this->headload($data);
    }
    
    public function input(){
        $data = array( 
            'titleform' => "", 
            'page_title' => "Tambah Data Pelanggan",
            'nama_p' => "",
            'alamat' => "",
            'cp_cust' => "",
            'telp' => "",
            'email_p' => "",
            'idcust' => 0);
        $this->headload($data);
    }
    
    public function edit(){
        $qdata = $this->ModelCustomer->getCustomerBy("id", $this->uri->segment(3));
        $data = array( 
            'titleform' => "", 
            'page_title' => "Ubah Data Barang",
            'nama_p' => $qdata[0]->name_cust,
            'alamat' => $qdata[0]->addr_cust,
            'cp_cust' => $qdata[0]->cp_cust,
            'telp' => $qdata[0]->no_telp,
            'email_p' => $qdata[0]->email,
            'idcust' => $qdata[0]->id_customer
            );
        $this->headload($data);
    }
    
    public function save() {
        $idcust = $this->input->post('idcust');
        $dataform = array(
            'name_cust' => $this->input->post('nama_p'),
            'addr_cust' => $this->input->post('alamat_p'),
            'cp_cust' => $this->input->post('kontak_p'),
            'no_telp' => $this->input->post('telp_p'),
            'email' => $this->input->post('email_p'),
            'is_active' => 1
        );
        
        if($idcust > 0 ){
           $save = $this->ModelCustomer->UpdateCust($dataform, $idcust, "edit");
        }else{
           $save = $this->ModelCustomer->InsertCust($dataform, $idcust);
        }   
        
        if ($save === TRUE){
            $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-success alert-st-one" role="alert">
                    <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <b>Simpan Data pelanggan Berhasil</b>
                    </div>');
            redirect('DataPelanggan');
        } else {
            $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                    <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <p class="message-mg-rt message-alert-none">Gagal Simpan Data Barang</p>
                    </div>');
            redirect('DataPelanggan/input');
        }
    }
    
    public function delete(){
       $idkey = $this->uri->segment(3); 
       $dataform = array('is_active' => 0);
       $save = $this->ModelCustomer->updateCust($dataform, $idkey, "delete");
     
       if ($save === TRUE){
            $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-success alert-st-one" role="alert">
                    <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <b>Hapus Data Barang Berhasil</b>
                    </div>');
            redirect('DataPelanggan');
        } else {
            $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                    <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    Gagal Simpan Data Barang
                    </div>');
            redirect('DataPelanggan/input');
        }
    }
}

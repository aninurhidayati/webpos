<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataBarang extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->Model_Security->getSecurityAdmin();
        $this->load->model('ModelBarang');
        $this->load->model('ModelReference');
        $this->load->model('ModelTransaksi');
    }
    
    private function headload($pushdata){
        $item = array(
            'page_content' => "v_barang",            
            'modul' => $this->uri->segment(1),
            'action' => $this->uri->segment(2),
            'breadcrumb1' => "Home",
            'breadcrumb2' => "Master Barang"            
        );
        return $this->load->view('v_home', array_merge($item, $pushdata));
    }
    
    public function index()
    {
        $query = $this->ModelBarang->getAllItems();
        $data = array( 'titleform' => "", 'page_title' => "Master Data Barang");
        $data['list_item'] = $query->result();
        $this->headload($data);
    }
    
    public function generateCode(){
        $kode=$this->input->post('kode');
        $listkab = $this->ModelBarang->getLastKode($kode);
        echo $listkab;
    }

    public function input(){
        $data = array( 
            'titleform' => "", 
            'page_title' => "Tambah Data Barang",
            'kode_b' => "",
            'nama_b' => "",
            'is_new' => 1,
            'listjenis' => $this->ModelReference->getCodeReference("JENISBRG")
            );
        $this->headload($data);
    }
    
    public function edit(){
        $qdata = $this->ModelBarang->getItemsBy("kode", $this->uri->segment(3));
        $data = array( 
            'titleform' => "", 
            'page_title' => "Ubah Data Barang",
            'kode_b' => $qdata[0]->code_item,
            'nama_b' => $qdata[0]->name_item,
            'is_new' => 0);
        $this->headload($data);
    }
    
    public function save() {
        $is_new = $this->input->post('is_new');
        $dataform = array(
            'code_item' => $this->input->post('kodeb'),
            'name_item' => $this->input->post('namab'),
            'totalstock' => 0,
            'createddate' => date("Y-m-d H:i:s"),
            'createdby' => $this->session->userdata('useradminlog'),
            'is_active' => 1
        );
        
        $dataedit = array(
            'code_item' => $this->input->post('kodeb'),
            'name_item' => $this->input->post('namab'),
            'is_active' => 1
        );
        
        if($is_new < 1 ){
           $save = $this->ModelBarang->UpdateItem($dataedit, $this->input->post('kodeb'), "edit");
       }else{
           $save = $this->ModelBarang->InsertItem($dataform, $this->input->post('kodeb'));
       }       
       if ($save === TRUE){
            $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-success alert-st-one" role="alert">
                    <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <b>Simpan Data Barang Berhasil</b>
                    </div>');
            redirect('DataBarang');
        } else {
            $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                    <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    Gagal Simpan Data Barang
                    </div>');
            redirect('DataBarang/input');
        }
    }
    
    public function delete(){
       $idkey = $this->uri->segment(3); 
       $cek_barangmasuk = $this->ModelBarang->getDetailItems("code", $idkey);
       $cek_barangkeluar = $this->ModelTransaksi->cekBarangKeluar("codebrg", $idkey);
       $cek_bm = count($cek_barangmasuk); $cek_bk = count($cek_barangkeluar);
       if(($cek_bm > 0) || ($cek_bk > 0)){
           $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-danger alert-st-one" role="alert">
                    <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <b>Data Barang tidak bisa dihapus, karena data barang ini sudah digunakan untuk
                    transaksi barang masuk atau barang keluar!!</b>
                    </div>');
            redirect('DataBarang');
       }else{
            $dataform = array('is_active' => 0);
            $save = $this->ModelBarang->updateItem($dataform, $idkey, "delete");

            if ($save === TRUE){
                 $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-success alert-st-one" role="alert">
                         <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                         <b>Hapus Data Barang Berhasil</b>
                         </div>');
                 redirect('DataBarang');
             } else {
                 $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                         <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                         <b>Gagal Hapus Data Barang </b>
                         </div>');
                 redirect('DataBarang/input');
             }
           
           
       }
       
    }
}

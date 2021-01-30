<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataBarangMasuk extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->Model_Security->getSecurityAdmin();
        $this->load->model('ModelBarang');
        $this->load->model('ModelReference');
        $this->load->model('ModelTransaksi');
    }
    
    private function headload($pushdata){
        $item = array(
            'page_content' => "v_barangmasuk",            
            'modul' => $this->uri->segment(1),
            'action' => $this->uri->segment(2),
            'breadcrumb1' => "Home",
            'breadcrumb2' => "Data Barang Masuk"  ,
            'listsatuan' => $this->ModelReference->getCodeReference("SATUANBRG")
        );
        return $this->load->view('v_home', array_merge($item, $pushdata));
    }
    
    public function index()
    {
        $query = $this->ModelBarang->getFakturtems("",0);
        $data = array( 'titleform' => "", 'page_title' => "Data Barang Masuk",
            'list_item' => $query);        
        $this->headload($data);
    }
    
    public function detail()
    {
        $query = $this->ModelBarang->getDetailItems("code",$this->uri->segment(3));
        if(count($query) > 0){
            $namebrg = $query[0]->name_item; 
        }else{ $namebrg = ""; } 
        $data = array( 'titleform' => "", 
            'page_title' => "Detail Data Barang : <span class='text-purple'>".$namebrg."</span>",
            'list_item' => $query);        
        $this->headload($data);
    }
    
    public function input(){
        $query = $this->ModelBarang->getAllItems();
        $data = array( 'titleform' => "",
            'page_title' => "Tambah Data Barang Masuk",
            'list_item' => $query->result(),
            'satuan' => 'Pcs',
            'subtotal' => 0,
            'ppn' => 10
            );
        $this->headload($data);
    }
    
    public function cekFakturBM() {
        $kodefak = $this->input->post('kodefak');
        $qcek = $this->ModelBarang->cekNoFakturBM($kodefak);
        echo $qcek;
    }

    public function edit(){
        $qbrg = $this->ModelBarang->getAllItems();
        $query = $this->ModelBarang->getDetailItems("id",$this->uri->segment(3));
        $data = array( 'titleform' => "",
            'page_title' => "Ubah Data Barang Masuk",
            'list_item' => $qbrg->result(),
            'dtitem' => $query[0],
            'iddetail' => $this->uri->segment(3));
        $this->headload($data);
    }
    
    public function detailFaktur(){
        $query = $this->ModelBarang->getDetailItems("idhead", base64_decode($this->uri->segment(3)));
        $data = array( 'titleform' => "",
            'page_title' => "Detail Faktur Barang Masuk",
            'dtitem' => $query,
            'nofaktur' => base64_decode($this->uri->segment(3))
        );
        $this->headload($data);
    }
    
    public function save(){
        $nofak = $this->input->post('nofaktur_bm');
        $tglmasuk = $this->input->post('tgl_masuk');
        $sales = $this->input->post('sales');
        $subtotal = $this->input->post('subtotal');
        $totalbayar = $this->input->post('totalbayar');
        $jmlbayar = $this->input->post('jmlbayar');
        $ppn = $this->input->post('txt_ppn');
        $tgl_tempo = $this->input->post('tgl_tempo');
        if($jmlbayar==$totalbayar){
            $status = "Lunas";
        }else{
            $status = "Belum Lunas";
        }
        $push_head = array(
            'no_faktur' => $nofak,
            'sales' => $sales,
            'entrydate' =>  TglWaktu1($tglmasuk),
            'tgl_jatuhtempo' => TglWaktu1($tgl_tempo),
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'total_payment' => $totalbayar,
            'jml_bayar' => $jmlbayar,
            'status' => $status,
            'createddate' => date("Y-m-d H:i:s"),
            'createdby' => $this->session->userdata('useradminlog'),
            'is_active' => 1
        );
        
        //print_r($push_head);
        $kodebarang = $this->input->post('v_kodebarang');
        $hpp = $this->input->post('v_hpp');
        $hpp_ppn = $this->input->post('v_hpp_ppn');
        $jmlstok = $this->input->post('v_jmlstok');
        $satuan = $this->input->post('v_satuan');
        $total = $this->input->post('v_total');
        if (isset($kodebarang) && isset($nofak)) {
            $totalstock = 0;
            for ($i=0; $i < sizeof($kodebarang); $i++) { 
                               
                $push_detail[] = array(
                    'code_item' => $kodebarang[$i],
                    'hpp' => $hpp[$i],
                    'hpp_ppn' => $hpp_ppn[$i],
                    'qty_stock' => $jmlstok[$i],
                    'real_stock' => $jmlstok[$i],
                    'total' =>  $total[$i],
                    'no_faktur' => $nofak,
                    'satuan' => $satuan[$i],
                    'is_active' => 1
                );
                $totalstock = $totalstock+$jmlstok[$i];
            }
            $qry = $this->ModelBarang->InsertItemDetail($push_head, $push_detail, $totalstock);
            if ($qry === TRUE){
                $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-success alert-st-one" role="alert">
                        <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                        <b>Simpan Data Barang Berhasil</b>
                        </div>');
                redirect('DataBarangMasuk');
            } else {
                $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                        <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                        Gagal Simpan Data Barang
                        </div>');
                redirect('DataBarangMasuk/input');
            }
        }
    }
    
    public function update() {
        $stokbaru = $this->input->post('jml_stok');
        $stoklama = $this->input->post('stoklama');
        $kodebaru = $this->input->post('barang');
        $push_detail = array(
            'code_item' => $kodebaru,
            'hpp' => $this->input->post('hpp'),
            'qty_stock' => $stokbaru,
            'entrydate' => TglWaktu1($this->input->post('tgl_masuk')),
            'satuan' => $this->input->post('satuan')
        );
        $kodelama = $this->input->post('exkodebarang');
        $iddetail = $this->input->post('iddetail');
        $qupdate = $this->ModelBarang->updateDetail($push_detail, $iddetail,"edit");
        if($qupdate){
            if(($kodelama != $kodebaru) || ($stokbaru != $stoklama)){
                $this->ModelBarang->updateTstock($kodelama, $stoklama, $kodebaru, $stokbaru);
            }
            $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-success alert-st-one" role="alert">
                    <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <b>Simpan Data Barang Berhasil</b>
                    </div>');
            redirect('DataBarangMasuk');
        }else{
            $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                    <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    Gagal Simpan Data Barang
                    </div>');
            redirect('DataBarangMasuk/input');
        }
    }

    public function caridata() {
        $txt_key = $this->input->post('kodebarang');
        $query = $this->ModelBarang->getCmbItems($txt_key);
        echo $query;
    }
    
    public function  updatebayar(){
        $txt_byr = $this->input->post('jml_bayar');
        $id = $this->input->post('id');
        $total = $this->input->post('total');
        if($txt_byr==$total){
            $status = "Lunas";
        }else{
            $status = "Belum Lunas";
        }
        $data = array('jml_bayar' => $txt_byr, 'status' => $status);
        echo $id."-";
        print_r($data);
        $query = $this->ModelBarang->updateBayar($data, $id, "edit");
        redirect('DataBarangMasuk/detailFaktur/'.base64_encode($id).'');
    }
    
    public function delete(){
       $idkey = base64_decode($this->uri->segment(3)); 
       $cek_barangkeluar = $this->ModelBarang->getDetailItems("idhead", $idkey);
       //print_r($cek_barangkeluar);
       foreach ($cek_barangkeluar as $bk) {
           $kode_arr[] = $bk->id_det_item;    
           echo $bk->code_item.":".$bk->real_stock."<br/>";
           $update_stok[] = array(
               'code_item' => $bk->code_item,
               'qty_stock' => $bk->real_stock
           );
       }
       //print_r($kode_arr);
       $cek = $this->ModelTransaksi->cekBKfromBM('iddetail_brg', $kode_arr);
       ///echo count($cek);
       $cek_bk = count($cek);

       if(($cek_bk > 0)){
           $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-danger alert-st-one" role="alert">
                    <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <b>Data Faktur tidak bisa dihapus, karena data detail barang ini sudah digunakan untuk
                    transaksi barang masuk atau barang keluar!!</b>
                    </div>');
            redirect('DataBarangMasuk');
       }else{
            $dataform = array('is_active' => 0);
            
            $save = $this->ModelBarang->updateNonAktif($dataform, $idkey, $update_stok);

            if ($save === TRUE){
                 $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-success alert-st-one" role="alert">
                         <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                         <b>Hapus Data Barang Berhasil</b>
                         </div>');
                 redirect('DataBarangMasuk');
             } else {
                 $this->session->set_flashdata('msg_saveitem', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                         <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                         <b>Gagal Hapus Data Barang </b>
                         </div>');
                 redirect('DataBarangMasuk');
             }
           
       }
       
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataBarangKeluar extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->Model_Security->getSecurityAdmin();
        $this->load->model('ModelReference');
        $this->load->model('ModelBarang');
        $this->load->model('ModelTransaksi');
        $this->load->model('ModelCustomer');
    }
    
    private function headload($pushdata){
        $item = array(
            'page_content' => "v_barangkeluar",            
            'modul' => $this->uri->segment(1),
            'action' => $this->uri->segment(2),
            'breadcrumb1' => "Home",
            'breadcrumb2' => "Data Barang Keluar"            
        );
        return $this->load->view('v_home', array_merge($item, $pushdata));
    }
    
    public function index(){
        $qdata_tst = $this->ModelTransaksi->getDataTransaksi("","");
        $data = array( 'titleform' => "",
            'page_title' => "Data Barang Keluar",
            'list_bk' => $qdata_tst);
        $this->headload($data);
    }
    
    public function input(){
        $qbarang = $this->ModelBarang->getDetailItems("",0);
        $data = array( 'titleform' => "", 
            'page_title' => "Tambah Data Barang Keluar",
            'list_cust' => $this->ModelCustomer->getCustomerBy("",0),
            'list_item' => $qbarang);
        $this->headload($data);
    }
    
    public function detail(){
        $qbarang = $this->ModelTransaksi->getDataTransaksi("id", base64_decode($this->uri->segment(3)));
        $qdetail = $this->ModelTransaksi->getDetailTst($qbarang[0]->no_invoice);
        $data = array( 'titleform' => "", 
            'page_title' => "Detail Data Barang Keluar",
            'list_cust' => $this->ModelCustomer->getCustomerBy("",0),
            'item' => $qbarang[0],
            'qdetail' => $qdetail->result()
        );
        $this->headload($data);
    }
    
    
    public function cekFakturBK() {
        $kodefak = $this->input->post('kodefak');
        $qcek = $this->ModelBarang->cekNoFakturBK($kodefak);
        echo $qcek;
    }
    
    public function save(){
        //head transaksi
        $nofaktur = $this->input->post('nofaktur_bk');
        $tgl_faktur = $this->input->post('tgl_faktur');
        $nm_customer = $this->input->post('nmcustomer');
        $subtotal = $this->input->post('subtotalbk');
        $totalbayar = $this->input->post('totalbayarbk');
        //detail transaksi
        $iddetbrg = ($this->input->post('v_iddetbarang'));
        $kodebrg = $this->input->post('v_kodebarang');
        $namabrg = $this->input->post('v_namabarang');
        $hpp = ($this->input->post('v_hpp'));
        $hargajual = ($this->input->post('v_harga'));
        $jumlahbrg = ($this->input->post('v_jumlah'));
        $total = $this->input->post('v_totalbk');
        if($subtotal==$totalbayar){
            $status = "Lunas";
        }else{
            $status = "Belum Lunas";
        }
        
        $push_head = array(
            'no_invoice' => $nofaktur,
            'id_cust' =>  $nm_customer,
            'date_invoice' => TglWaktu1($tgl_faktur),
            'total_payment' => $totalbayar,
            'subtotal' => $subtotal,
            'created_by' => $this->session->userdata('useradminlog'),
            'createddate' => date("Y-m-d H:i:s"),
            'is_active' => 1,
            'status_payment' => $status
        );
        
        if (isset($kodebrg)) {
            for ($i=0; $i < sizeof($kodebrg); $i++) { 
                $push_detail[] = array(
                    'no_invoice' => $nofaktur,
                    'iddetail_brg' => intval($iddetbrg[$i]),
                    'kode_brg' => $kodebrg[$i],
                    'nama_brg' => $namabrg[$i],
                    'hpp' => intval($hpp[$i]),
                    'hrg_jual' => intval($hargajual[$i]),
                    'jumlah' => intval($jumlahbrg[$i]),
                    'total' => intval($total[$i]),
                    'is_active' => 1
                );
                $updatestok[] = array(
                    'id_det_item' => intval($iddetbrg[$i]),
                    'code_item' => $kodebrg[$i],
                    'qty_stock' => intval($jumlahbrg[$i])
                ); 
            }
        }
        $save_tst = $this->ModelTransaksi->saveTransaksi($push_head, $push_detail, $updatestok);
        if ($save_tst){
            $this->session->set_flashdata('msg_saveitemout', '<div class="alert alert-success alert-st-one" role="alert">
                    <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    <b>Simpan Data Barang Keluar Berhasil</b>
                    </div>');
            redirect('DataBarangKeluar');
        } else {
            $this->session->set_flashdata('msg_saveitemout', '<div class="alert alert-danger alert-mg-b alert-st-four" role="alert">
                    <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    Gagal Simpan Data Barang Keluar
                    </div>');
            redirect('DataBarangKeluar/input');
        }
    }
    
    public function  updatebayar(){
        $txt_byr = $this->input->post('jml_bayar_utang');
        $id = $this->input->post('id');
        $total = $this->input->post('subtotal');
        if($txt_byr==$total){
            $status = "Lunas";
        }else{
            $status = "Belum Lunas";
        }
        $data = array('total_payment' => $txt_byr, 'status_payment' => $status);
        $query = $this->ModelTransaksi->updateBayar($data, $id, "edit");
        echo $id;
        redirect('DataBarangKeluar/detail/'.base64_encode($id).'');
    }
    
    public function delete(){
       $idkey = $this->uri->segment(3); 

        $dataform = array('is_active' => 0);
        $save = $this->ModelTransaksi->updateNonAktif($dataform, $idkey);

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
    
    public function cetakInvoiceBK() {
        $key = base64_decode($this->uri->segment(3));
        $qbarang = $this->ModelTransaksi->getDataTransaksi("id", base64_decode($this->uri->segment(3)));
        $qdetail = $this->ModelTransaksi->getDetailTst($qbarang[0]->no_invoice);
        $data = array( 'titleform' => "", 
            'page_title' => "Detail Data Barang Keluar",
            'list_cust' => $this->ModelCustomer->getCustomerBy("",0),
            'item' => $qbarang[0],
            'qdetail' => $qdetail->result(),
            'idkey' => $key
        );
        return $this->load->view('v_invoice', $data);
    }
}

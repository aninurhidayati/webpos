<?php
if (!defined('BASEPATH')) {  exit('No direct script access allowed');
}

class ModelBarang extends CI_model {
    //var $table          = 'mst_item';
    public function getLastKode($jenis) {
        $this->db->select('*');
        $this->db->order_by('createddate','DESC')->limit(1);  
        $qdata = $this->db->get('mst_item');
        $cekdata = $qdata->num_rows();
        $qlastcode = $qdata->row('code_item');
        $lastjenis =  substr($qlastcode, 0, 2);
        $nourut = substr($qlastcode, -3);
        $thn_lama = substr($qlastcode, 2, 2);
        $thn_sekarang = date("y");
        if($cekdata >  0 && ($thn_sekarang ==  $thn_lama) && ($jenis == $lastjenis)){
            $nourut_new = $nourut + 1;
            $nourutkode = "001";
            if($nourut_new < 10){ $nourutkode = "00".$nourut_new; }
            else if($nourut_new < 100){ $nourutkode = "0".$nourut_new; }
            else if($nourut < 1000){ $nourutkode = $nourut_new; }
            $newkode = $jenis.$thn_lama.$nourutkode;
        }else{
            $newkode = $jenis.$thn_sekarang."001";
        }
        return $newkode;
    }
    
    public function InsertItem($pushdata, $kode){
        $this->db->trans_begin();        
        $save = $this->db->insert('mst_item', $pushdata);
         if($save){
             $history = inserthistory("input data barang", $kode, "mst_item",$this->session->userdata('useradminlog'));
         }
         
        if (!isset($save) || !isset($history)) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        }         
    }
    
    public function InsertItemDetail($pushhead, $pushdetail, $totalstock){
        $kode = $pushdetail[0]['code_item'];
        $this->db->trans_begin();      
        $saveHead = $this->db->insert('faktur_item', $pushhead);
        if($saveHead){
            $savedetail = $this->db->insert_batch('detail_item', $pushdetail);
            if($savedetail){  
                for($i=0; $i< sizeof($pushdetail); $i++){                    
                    $this->db->query("update mst_item set "
                         . "totalstock = (totalstock + ".$pushdetail[$i]['qty_stock'].") "
                         . "where code_item='".$pushdetail[$i]['code_item']."'");
                }                
//             $this->db->query("update mst_item set "
//                    . "totalstock = (totalstock+(".$totalstock.")) "
//                    . "where code_item= '".$kode."'");          
                inserthistory("input data barang masuk", $kode, "detail_item",$this->session->userdata('useradminlog'));
            }
        }            
         
        if (!isset($saveHead)) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        }         
    }
    
    public function updateItem($pushdata, $idkey, $act){
        $this->db->trans_begin(); 
        $this->db->where("code_item", $idkey);
        $this->db->update('mst_item', $pushdata);
        if($this->db->affected_rows() > 0){
            if($act === "edit"){
                inserthistory("mengubah data barang", $idkey, "mst_item",$this->session->userdata('useradminlog'));
            }else{
                inserthistory("menghapus data barang", $idkey, "mst_item",$this->session->userdata('useradminlog'));
            }
         }
         
        if ($this->db->trans_status === FALSE) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        }         
    }
    
    public function getAllItems() {
        $this->db->where("is_active", 1);
        $this->db->order_by('createddate DESC'); 
        $query = $this->db->get("mst_item");        
        return $query;
    }
    
    public function getItemsBy($key, $val){
        $criteria = array('mst_item.code_item' => $val);
        if($key == "name"){ $criteria = array('mst_item.name_item' => $val); }
        if($key == "find"){ $criteria = 'code_item LIKE "%'.$val.'%" OR name_item LIKE "%'.$val.'%"'; }
        $this->db->where($criteria);
        $this->db->from('mst_item');
        $this->db->select('mst_item.*');
        $query = $this->db->get()->result();      
        return $query;
    }
    
    public function getCmbItems($val) {
        $this->db->where('code_item LIKE "%'.$val.'%" OR name_item LIKE "%'.$val.'%" AND is_active=1');
        $query = $this->db->get("mst_item");
        foreach ($query->result_array() as $data ){
            $nama = $data['name_item'];
            $barang.= "<option value='$data[code_item]'>$nama</option>";
        }
        return $barang;
    }
    
    public function cekNoFakturBM($param) {
        $this->db->where("no_faktur", $param);
        $query = $this->db->get("faktur_item");        
        return $query->num_rows();
    }
    
    public function cekNoFakturBK($param) {
        $this->db->where("no_invoice", $param);
        $query = $this->db->get("tst_selling");        
        return $query->num_rows();
    }
    
    public function getFakturtems($key, $val){
        if($key == "code"){ $criteria = array('code_item' => $val); }
        if($key == "id"){ $criteria = array('id_det_item' => $val); }
        if(!empty($key)){
            $this->db->where($criteria);
        }
        $this->db->where(array('is_active' => 1));
        $this->db->from('faktur_item');
        $this->db->order_by('createddate','DESC');
        $query = $this->db->get()->result();      
        return $query;
    }
    
    public function getDetailItems($key, $val){
        if($key == "idhead"){ $criteria = array('idhead' => $val); }
        if($key == "code"){ $criteria = array('code_item' => $val); }
        if($key == "id"){ $criteria = array('id_det_item' => $val); }
        if(!empty($key)){
            $this->db->where($criteria);
        }
        $this->db->where(array('is_active' => 1));
        $this->db->from('barangmasuk_view');
        $this->db->order_by('createddate','DESC');
        $query = $this->db->get()->result();      
        return $query;
    }
    
    public function updateDetail($param, $idkey, $act) {
        $this->db->trans_begin(); 
        $this->db->where("id_det_item", $idkey);
        $this->db->update('detail_item', $param);
        
        if($this->db->affected_rows() > 0){
            if($act === "edit"){
                inserthistory("mengubah data barang masuk", $idkey, "mst_item",$this->session->userdata('useradminlog'));
            }else{
                inserthistory("menghapus data barang", $idkey, "mst_item",$this->session->userdata('useradminlog'));
            }
         }
         
        if ($this->db->trans_status === FALSE) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        }         
    }
    
    public function updateTstock($kodelama, $stoklama, $kodebaru, $stokbaru) {
        $this->db->trans_begin(); 
        if(($kodelama == $kodebaru) && ($stokbaru != $stoklama)){
            $this->db->query("update mst_item set "
                     . "totalstock = (totalstock - (".$stoklama.")+(".$stokbaru.")) "
                     . "where code_item= '".$kodelama."'"); 
        } else if(($kodelama != $kodebaru) && ($stokbaru == $stoklama)){
            $this->db->query("update mst_item set "
                     . "totalstock = (totalstock - (".$stoklama.")) "
                     . "where code_item= '".$kodelama."'"); 
            $this->db->query("update mst_item set "
                     . "totalstock = (totalstock + (".$stokbaru.")) "
                     . "where code_item= '".$kodebaru."'"); 
        }
        
        if ($this->db->trans_status === FALSE) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        }         
    }
    
    public function exportReportBM($brg, $date1, $date2, $status){
        if(empty($brg) && empty($status)){
            $criteria = 'is_active > 0 AND entrydate >= "'.$date1.'" AND entrydate <= "'.$date2.'"';
        } else if(!empty($brg) && empty($status)){
            $criteria = 'is_active > 0 AND entrydate >= "'.$date1.'" AND entrydate <= "'.$date2.'"'
                    . ' AND code_item = "'.$brg.'"';
        } else if(empty($brg) && !empty($status) && $status == 'Lunas'){
            $criteria = 'is_active > 0 AND entrydate >= "'.$date1.'" AND entrydate <= "'.$date2.'"'
                    . ' AND jml_bayar >= total_payment ';
        } else if(empty($brg) && !empty($status) && $status == 'Belum Lunas'){
            $criteria = 'is_active > 0 AND entrydate >= "'.$date1.'" AND entrydate <= "'.$date2.'"'
                    . ' AND jml_bayar < total_payment ';
        } else if(!empty($brg) && !empty($status) && $status == 'Lunas'){
            $criteria = 'is_active > 0 AND entrydate >= "'.$date1.'" AND entrydate <= "'.$date2.'"'
                    . ' AND code_item = "'.$brg.'" AND jml_bayar >= total_payment';
        } else if(!empty($brg) && !empty($status) && $status == 'Belum Lunas'){
            $criteria = 'is_active > 0 AND entrydate >= "'.$date1.'" AND entrydate <= "'.$date2.'"'
                    . ' AND code_item = "'.$brg.'" AND jml_bayar < total_payment';
        }
        $this->db->where($criteria);
        $result = $this->db->get('barangmasuk_view');
        return $result->result();
    }    
    
    public function updateBayar($param, $idkey, $act) {
        $this->db->trans_begin(); 
        $this->db->where("idhead", $idkey);
        $qry = $this->db->update('faktur_item', $param);
        
        if($qry){
            if($act === "edit"){
                inserthistory("mengubah data pelunasan barang masuk", $idkey, "faktur_item",$this->session->userdata('useradminlog'));
            }else{
                inserthistory("menghapus data pelunasan barang", $idkey, "faktur_item",$this->session->userdata('useradminlog'));
            }
         }
         
        if (!isset($qry)) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        }         
    }
    
    public function updateNonAktif($param, $idkey, $updatestok) {
        $this->db->trans_begin(); 
        $this->db->where("idhead", $idkey);
        $qry = $this->db->update('faktur_item', $param);
        
        if($qry){
            for($i=0; $i< sizeof($updatestok); $i++){
                $this->db->query("update mst_item set "
                     . "totalstock = (totalstock - ".$updatestok[$i]['qty_stock'].") "
                     . "where code_item= '".$updatestok[$i]['code_item']."'");
            }
            inserthistory("Menghapus faktur barang masuk", $idkey, "faktur_item",$this->session->userdata('useradminlog'));
            
         }
         
        if (!isset($qry)) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        }         
    }
}
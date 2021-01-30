<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class ModelTransaksi extends CI_model {

    public function getCustomerBy($key, $val){
        $criteria = array('mst_customer.is_active' => 1);
        if($key == "name"){ $criteria = array('mst_customer.name_cust' => $val); }
        if($key == "find"){ $criteria = 'name_cust LIKE "%'.$val.'%"'; }
        $this->db->where($criteria);
        $this->db->from('mst_customer');
        $this->db->select('mst_customer.*');
        $query = $this->db->get()->result();      
        return $query;
    }
    
    public function getNoFaktur() {
        return 0;
    }
    
    public function saveTransaksi($datahead, $datadetail, $updatestok){
        $this->db->trans_begin(); 
        $nofak = $datahead[0]['no_invoice'];
        $save_head = $this->db->insert('tst_selling', $datahead);
        if($save_head){
            $save_det = $this->db->insert_batch('det_tst_selling', $datadetail);
        }
        if($save_det && $save_head){
            for($i=0; $i< sizeof($updatestok); $i++){
                $this->db->query("update detail_item set "
                     . "qty_stock = (qty_stock - ".$updatestok[$i]['qty_stock'].") "
                     . "where id_det_item= '".$updatestok[$i]['id_det_item']."'");
                $this->db->query("update mst_item set "
                     . "totalstock = (totalstock - ".$updatestok[$i]['qty_stock'].") "
                     . "where code_item= '".$updatestok[$i]['code_item']."'");
            }
            inserthistory("input data barang keluar", $nofak, "tst_selling",$this->session->userdata('useradminlog'));
        }
        
        if (!$save_det || !$save_head) {
        	$this->db->trans_rollback();
        	return FALSE;
        } else {
        	$this->db->trans_commit();
            return TRUE;
        }   
    }
    
    public function getDataTransaksi($key, $val) {
        $criteria = array('is_active' => 1);
        if($key == "id"){ $criteria = array('id_invoice' => $val); }
        if($key == "nofaktur"){ $criteria = array('no_invoice' => $val); }
        if($key == "find"){ $criteria = 'code_item LIKE "%'.$val.'%" OR name_item LIKE "%'.$val.'%"'; }
        if($key == "cust"){ $criteria = array('id_cust' => $val); }

        $this->db->where($criteria);
        $this->db->order_by('createddate DESC'); 
        $this->db->from('tst_barangkeluar_view');
        $this->db->select('tst_barangkeluar_view.*');
        $query = $this->db->get()->result();      
        return $query;
        
    }
    
    public function getDetailTst($key) {
        $this->db->where("no_invoice", $key);
        $query = $this->db->get("det_tst_selling");        
        return $query;
    }
    
    public function exportReportBK($brg, $date1, $date2, $status, $cekdetail){
        if(empty($brg) && empty($status)){
            $criteria = 'is_active > 0 AND date_invoice >= "'.$date1.'" AND date_invoice <= "'.$date2.'"';
        } else if(!empty($brg) && empty($status)){
            $criteria = 'is_active > 0 AND date_invoice >= "'.$date1.'" AND date_invoice <= "'.$date2.'"'
                    . ' AND kode_brg = "'.$brg.'"';
        } else if(empty($brg) && !empty($status)){
            $criteria = 'is_active > 0 AND date_invoice >= "'.$date1.'" AND date_invoice <= "'.$date2.'"'
                    . ' AND status_payment="'.$status.'" ';
        } else if(!empty($brg) && !empty($status)){
            $criteria = 'is_active > 0 AND date_invoice >= "'.$date1.'" AND date_invoice <= "'.$date2.'"'
                    . ' AND kode_brg = "'.$brg.'" AND  status_payment="'.$status.'"';
        } 
        
        $this->db->where($criteria);
        if($cekdetail < 1){
            $this->db->group_by('no_invoice');
        }
        $result = $this->db->get('tst_selling_view');
        return $result->result();
    }    
    
    public function getDetailBK($key) {
        $this->db->where(array('is_active' => 1));
        $this->db->where("iddetail_brg", $key);
        $query = $this->db->get("tst_selling_view");        
        return $query->result();
    }
    
    public function updateBayar($param, $idkey, $act) {
        $this->db->trans_begin(); 
        $this->db->where("id_invoice", $idkey);
        $qry = $this->db->update('tst_selling', $param);
        
        if($qry){
            if($act === "edit"){
                inserthistory("mengubah data pelunasan barang keluar", $idkey, "faktur_item",$this->session->userdata('useradminlog'));
            }else{
                inserthistory("menghapus data pelunasan barang keluar", $idkey, "faktur_item",$this->session->userdata('useradminlog'));
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
    
    public function cekBarangKeluar($key, $val) {
        if($key == "codebrg"){ $criteria = array('kode_brg' => $val); }
        if($key == "id"){ $criteria = array('id_det_item' => $val); }
        if(!empty($key)){
            $this->db->where($criteria);
        }
        $queryx = $this->db->get("det_tst_selling");        
        $query = $queryx->result();      
        return $query;
    }
    
    public function cekBKfromBM($key, $param) {
        $this->db->where_in(''.$key.'',$param);
        $queryx = $this->db->get("det_tst_selling");        
        $query = $queryx->result();      
        return $query;
    }
    
    public function updateNonAktif($param, $idkey) {
        $this->db->trans_begin(); 
        $this->db->where("id_invoice", $idkey);
        $qry = $this->db->update('tst_selling', $param);
        if($qry){
            $this->db->where("id_invoice", $idkey);
            $queryx = $this->db->get("tst_selling_view");        
            $qry_detail = $queryx->result();      
        
            for($i=0; $i< sizeof($qry_detail); $i++){
                $this->db->query("update detail_item set "
                     . "qty_stock = (qty_stock - ".$qry_detail[$i]->jumlah.") "
                     . "where id_det_item= '".$qry_detail[$i]->iddetail_brg."'");
                $this->db->query("update mst_item set "
                     . "totalstock = (totalstock - ".$qry_detail[$i]->jumlah.") "
                     . "where code_item= '".$qry_detail[$i]->kode_brg."'");
            }
            inserthistory("Menghapus faktur barang keluar", $idkey, "faktur_item",$this->session->userdata('useradminlog'));
            
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
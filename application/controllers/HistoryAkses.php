<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HistoryAkses extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->Model_Security->getSecurityAdmin();
        $this->load->model("ModelReference");  
    }
    private function headload($pushdata){
        $item = array(
            'page_content' => "v_history",            
            'modul' => $this->uri->segment(1),
            'action' => $this->uri->segment(2),
            'breadcrumb1' => "Home",
            'breadcrumb2' => "History Akses User"            
        );
        return $this->load->view('v_home', array_merge($item, $pushdata));
    }
    
    public function index()
    {
        $query = $this->ModelReference->getHistoryAll();
        $data = array( 'titleform' => "", 'page_title' => "Data History Akses");
        $data['list_akses'] = $query;
        $this->headload($data);
    }
}
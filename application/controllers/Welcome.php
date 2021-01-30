<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function __construct() {
        parent::__construct();
        //$this->load->model("ModelUserLogin");
    }
    
    public function index()
    {
        $data['titlehead'] = "Login (Admin) ";
        $data['modul'] = $this->uri->segment(1);
        $data['action'] = $this->uri->segment(2);
        return $this->load->view('v_adminlogin', $data);
    }

}

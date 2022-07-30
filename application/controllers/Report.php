<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Report extends CI_Controller {
  private $nama_menu  = "Laporan";     
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_main');
    $this->load->model('Report_m');
    must_login();
  }
  
  public function index()
  {
    $data['title'] = 'Laporan | Akunting';
    $data['content'] = "report/index.php";    
    $this->parser->parse('sistem/template', $data);
  }
}

/* End of file Report.php */

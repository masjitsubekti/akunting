<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Posting extends CI_Controller {
  private $nama_menu  = "Posting Jurnal";     
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_main');
    $this->load->model('Posting_m');
    must_login();
  }
  
  public function index()
  {
    $data['title'] = 'Posting Jurnal | Akunting';
    $data['content'] = "posting/index.php";    
    $this->parser->parse('sistem/template', $data);
  }
  
  public function fetch_data(){
    $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
    $key	  = ($this->input->get("q") != "") ? strtoupper(quotes_to_entities($this->input->get("q"))) : "";
    $limit	= $this->input->get("limit");
    $offset = ($limit*$pg)-$limit;

    $filter = array(
      'q' => $key,
      'sortby' => $this->input->get("sortby"),
      'sorttype' => $this->input->get("sorttype"),
      'offset' => $offset,
      'limit' => $limit,
      'startdate' => format_date($this->input->get("startdate"), 'Y-m-d'),
      'enddate' => format_date($this->input->get("enddate"), 'Y-m-d'),
    );
    
    $page              = array();
    $page['limit']     = $limit;
    $page['count_row'] = $this->Posting_m->get_list_count($filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Posting_m->get_list_data($filter);
 
    $this->load->view('sistem/posting/list_data',$data);
  }
}

/* End of file Posting.php */

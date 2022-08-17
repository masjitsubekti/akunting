<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Jenis_barang extends CI_Controller {
  private $nama_menu  = "Jenis Barang";     
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_main');
    $this->load->model('Jenis_barang_m');
    must_login();
  }
  
  public function index()
  {
    $data['title'] = 'Jenis Barang | Akunting';
    $data['content'] = "jenis_barang/index.php";    
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
    );
    
    $page              = array();
    $page['limit']     = $limit;
    $page['count_row'] = $this->Jenis_barang_m->get_list_count($filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Jenis_barang_m->get_list_data($filter);
 
    $this->load->view('sistem/jenis_barang/list_data',$data);
  }

  public function load_modal(){
    $id = $this->input->post('id');
    if ($id!=""){
        $data['mode'] = "UPDATE";
        $data['data'] = $this->M_main->get_where('m_jenis_barang','id',$id)->row_array();
    }else{
        $data['mode'] = "ADD";
    }
    $this->load->view('sistem/jenis_barang/form_modal',$data);
  }

  public function save(){
    $id = $this->input->post('id');
    $nama = strip_tags(trim($this->input->post('nama')));

    if($id!=""){
        // Handle Update
        $data_object = array(
            'nama'=>$nama,
            'updated_at'=>date('Y-m-d H:i:s')
        );
    
        $this->Jenis_barang_m->update($data_object, array(
          'id' => $id
        )); 

        $response['success'] = true;
        $response['message'] = "Data Berhasil Diubah !";     
    }else{
        // Handle Save
        $data_object = array(
            'nama'=>$nama,
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s')
        );
        $this->Jenis_barang_m->save($data_object);//insert untuk menambahkan data
        $response['success'] = TRUE;
        $response['message'] = "Data Berhasil Disimpan";
    }
    echo json_encode($response);   
  }

  public function delete($id){
    if($id){
      $object = array(
        'status' => '0', 
        'updated_at'=>date('Y-m-d H:i:s')
      );

      $this->Jenis_barang_m->update($object, array(
        'id' => $id
      )); 
      
      $response['success'] = true;
      $response['message'] = "Data berhasil dihapus !";
    }else{
      $response['success'] = false;
      $response['message'] = "Data tidak ditemukan !";
    }
    echo json_encode($response);
  }

}

/* End of file Jenis_barang.php */
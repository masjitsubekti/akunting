<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Akun extends CI_Controller {
  private $nama_menu  = "Akun";     
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_main');
    $this->load->model('Akun_m');
    must_login();
  }
  
  public function index()
  {
    $data['title'] = 'Akun | Akunting';
    $data['content'] = "akun/index.php";    
    $this->parser->parse('sistem/template', $data);
  }
  
  public function fetch_data(){
    $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
    $key	  = ($this->input->get("search") != "") ? strtoupper(quotes_to_entities($this->input->get("search"))) : "";
    $limit	= $this->input->get("limit");
    $offset = ($limit*$pg)-$limit;
    $column = $this->input->get("sortby");
    $sort   = $this->input->get("sorttype");
    
    $page              = array();
    $page['limit']     = $limit;
    $page['count_row'] = $this->Akun_m->get_list_count($key)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Akun_m->get_list_data($key, $limit, $offset, $column, $sort);
 
    $this->load->view('sistem/akun/list_data',$data);
  }

  public function create(){
    $data['title'] = 'Tambah Akun | Akunting';
    $data['kelompok_akun'] = $this->Akun_m->get_kelompok_akun();
    $data['content'] = "akun/form.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function edit($id){
    $data['title'] = 'Edit Akun | Akunting';
    $data['kelompok_akun'] = $this->Akun_m->get_kelompok_akun();
    $data['data'] = $this->M_main->get_where('acc_akun','id',$id)->row_array();
    $data['content'] = "akun/form.php";    
    $this->load->view('sistem/akun/form',$data);
  }

  public function save(){
      $id = $this->input->post('id');
      $kode = strip_tags(trim($this->input->post('kode')));
      $nama = strip_tags(trim($this->input->post('nama')));
      $id_kelompok = strip_tags(trim($this->input->post('id_kelompok')));
      $id_parent = strip_tags(trim($this->input->post('id_parent')));
      $keterangan = strip_tags(trim($this->input->post('katerangan')));
      $aktif = strip_tags(trim($this->input->post('aktif')));
      if($id!=""){
          $data_object = array(
              'kode'=>$kode,
              'nama'=>$nama,
              'keterangan'=>$keterangan,
              'id_kelompok'=>$id_kelompok,
              'id_parent'=>$id_parent,
              'aktif'=>$aktif,
              'updated_at'=>date('Y-m-d H:i:s')
          );
      
          $this->Akun_m->update($data_object, array(
            'id' => $id
          )); 

          $response['success'] = true;
          $response['message'] = "Data Berhasil Diubah !";     
      }else{
          $data_object = array(
              'kode'=>$kode,
              'nama'=>$nama,
              'keterangan'=>$keterangan,
              'id_kelompok'=>$id_kelompok,
              'id_mata_uang'=>'1',
              'id_parent'=>$id_parent,
              'expanded'=>'1',
              'aktif'=>$aktif,
              'status'=>'1',
              'created_at'=>date('Y-m-d H:i:s')
          );
          $this->Akun_m->save($data_object);//insert untuk menambahkan data
          $response['success'] = TRUE;
          $response['message'] = "Data Berhasil Disimpan";
      }
      echo json_encode($response);   
  }

  public function delete($id){
    if($id){
      $object = array(
        'status' => '0', 
      );

      $this->Akun_m->update($data_object, array(
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

  /**
   * Lookup Akun
   * Digunakan Untuk Melookup / Pencarian / Menampilkan Daftar Akun
   */

  public function lookup_akun(){
    $this->load->view('sistem/lookup/lookup_akun');
  }

  public function get_data_lookup(){
    $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
    $key	  = ($this->input->get("search") != "") ? strtoupper(quotes_to_entities($this->input->get("search"))) : "";
    $limit	= $this->input->get("limit");
    $offset = ($limit*$pg)-$limit;
    $column = $this->input->get("sortby");
    $sort   = $this->input->get("sorttype");
    $funcName = $this->input->post('function_name');
    
    $page              = array();
    $page['function_name'] = $funcName;
    $page['limit']     = $limit;
    $page['count_row'] = $this->Akun_m->get_list_count($key)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Akun_m->get_list_data($key, $limit, $offset, $column, $sort);

    $this->load->view('sistem/lookup/data_akun', $data);
  }
}

/* End of file Akun.php */

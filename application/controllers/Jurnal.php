<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Jurnal extends CI_Controller {
  private $nama_menu  = "Akun";     
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_main');
    $this->load->model('Jurnal_m');
    must_login();
  }
  
  public function index()
  {
    $data['title'] = 'Jurnal Umum | Akunting';
    $data['content'] = "jurnal/index.php";    
    $this->parser->parse('sistem/template', $data);
  }
  
  public function fetch_data(){
    $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
    $key	  = ($this->input->get("q") != "") ? strtoupper(quotes_to_entities($this->input->get("q"))) : "";
    $limit	= $this->input->get("limit");
    $offset = ($limit*$pg)-$limit;
    $column = $this->input->get("sortby");
    $sort   = $this->input->get("sorttype");
    
    $page              = array();
    $page['limit']     = $limit;
    $page['count_row'] = $this->Jurnal_m->get_list_count($key)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Jurnal_m->get_list_data($key, $limit, $offset, $column, $sort);
 
    $this->load->view('sistem/jurnal/list_data',$data);
  }

  public function create(){
    $data['title'] = 'Tambah Jurnal Umum | Akunting';
    $data['content'] = "jurnal/form.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function edit($id){
    $data['title'] = 'Edit Jurnal Umum | Akunting';
    $data['data'] = $this->Jurnal_m->get_by_id($id)->row_array();
    $data['content'] = "jurnal/form.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function save(){
      $id = $this->input->post('id');
      $kode = strip_tags(trim($this->input->post('kode')));
      $nama = strip_tags(trim($this->input->post('nama')));
      $id_kelompok = strip_tags(trim($this->input->post('kelompok_akun')));
      $id_parent = ($this->input->post('id_parent')!="") ? $this->input->post('id_parent') : null;
      $keterangan = strip_tags(trim($this->input->post('keterangan')));
      $aktif = ($this->input->post('aktif')!="") ? $this->input->post('aktif') : '0';

      if($id!=""){
          // Handle Update
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
          // Handle Save
          $id_akun = $this->uuid->v4(false);
          $data_object = array(
              'id'=>$id_akun,
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
        'updated_at'=>date('Y-m-d H:i:s')
      );

      $this->Jurnal_m->update($object, array(
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

/* End of file Jurnal.php */

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Supplier extends CI_Controller {
  private $nama_menu  = "Supplier";     
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_main');
    $this->load->model('Supplier_m');
    must_login();
  }
  
  public function index()
  {
    $data['title'] = 'Supplier | Akunting';
    $data['content'] = "supplier/index.php";    
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
    $page['count_row'] = $this->Supplier_m->get_list_count($filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Supplier_m->get_list_data($filter);
 
    $this->load->view('sistem/supplier/list_data',$data);
  }

  public function load_modal(){
    $id = $this->input->post('id');
    $data['kode'] = $this->M_main->get_kode_master_v4('SP', 'kode', 'm_supplier');
    if ($id!=""){
        $data['mode'] = "UPDATE";
        $data['data'] =  $this->M_main->get_where('m_supplier','id',$id)->row_array();
    }else{
        $data['mode'] = "ADD";
    }
    $this->load->view('sistem/supplier/form_modal',$data);
  }

  public function save(){
    $id = $this->input->post('id');
    $kode = strip_tags(trim($this->input->post('kode')));
    $nama = strip_tags(trim($this->input->post('nama')));
    $no_telp = strip_tags(trim($this->input->post('no_telp')));
    $alamat = strip_tags(trim($this->input->post('alamat')));
    $keterangan = strip_tags(trim($this->input->post('keterangan')));

    if($id!=""){
        // Handle Update
        $data_object = array(
            'nama'=>$nama,
            'no_telp'=>$no_telp,
            'alamat'=>$alamat,
            'keterangan'=>$keterangan,
            'updated_at'=>date('Y-m-d H:i:s')
        );
    
        $this->Supplier_m->update($data_object, array(
          'id' => $id
        )); 

        $response['success'] = true;
        $response['message'] = "Data Berhasil Diubah !";     
    }else{
        // Handle Save
        $uuid_v4 = $this->uuid->v4(false);
        $data_object = array(
            'id'=>$uuid_v4,
            'kode'=>$kode,
            'nama'=>$nama,
            'no_telp'=>$no_telp,
            'alamat'=>$alamat,
            'keterangan'=>$keterangan,
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s')
        );
        $this->Supplier_m->save($data_object);//insert untuk menambahkan data
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

      $this->Supplier_m->update($object, array(
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

/* End of file Supplier.php */
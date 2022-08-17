<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Barang extends CI_Controller {
  private $nama_menu  = "Barang";     
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_main');
    $this->load->model('Barang_m');
    $this->load->model('Satuan_m');
    $this->load->model('Jenis_barang_m');
    $this->load->model('Akun_m');
    must_login();
  }
  
  public function index()
  {
    $data['title'] = 'Barang | Akunting';
    $data['content'] = "barang/index.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function create(){
    $data['title'] = 'Tambah Barang | Akunting';
    $data['jenis_barang'] = $this->Jenis_barang_m->get_all();
    $data['satuan'] = $this->Satuan_m->get_all();
    $data['akun_persediaan'] = $this->Akun_m->get_all('3'); // akun persediaan
    $data['content'] = "barang/form.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function edit($id){
    $data['title'] = 'Edit Barang | Akunting';
    $data['jenis_barang'] = $this->Jenis_barang_m->get_all();
    $data['satuan'] = $this->Satuan_m->get_all();
    $data['akun_persediaan'] = $this->Akun_m->get_all('3'); // akun persediaan
    $data['data'] = $this->Barang_m->get_by_id($id)->row_array();
    $data['content'] = "barang/form.php";    
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
    $page['count_row'] = $this->Barang_m->get_list_count($filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Barang_m->get_list_data($filter);
 
    $this->load->view('sistem/barang/list_data',$data);
  }

  public function save(){
    $id = $this->input->post('id');
    $kode = $this->M_main->get_kode_master_v7('B', 'kode', 'm_barang');
    $nama = strip_tags(trim($this->input->post('nama')));
    $id_jenis = strip_tags(trim($this->input->post('jenis_barang')));
    $id_satuan = strip_tags(trim($this->input->post('satuan')));
    $id_akun_persediaan = strip_tags(trim($this->input->post('akun_persediaan')));
    $harga_jual = strip_tags(trim($this->input->post('harga_jual')));
    $harga_beli = strip_tags(trim($this->input->post('harga_beli')));
    $stok = strip_tags(trim($this->input->post('stok')));
    $keterangan = strip_tags(trim($this->input->post('keterangan')));

    if($id!=""){
        // Handle Update
        $data_object = array(
            'nama'=>$nama,
            'id_jenis'=>$id_jenis,
            'id_satuan'=>$id_satuan,
            'id_akun_persediaan'=>$id_akun_persediaan,
            'harga_jual'=>$harga_jual,
            'harga_beli'=>$harga_beli,
            'stok'=>$stok,
            'keterangan'=>$keterangan,
            'updated_at'=>date('Y-m-d H:i:s')
        );
    
        $this->Barang_m->update($data_object, array(
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
            'id_jenis'=>$id_jenis,
            'id_satuan'=>$id_satuan,
            'id_akun_persediaan'=>$id_akun_persediaan,
            'harga_jual'=>$harga_jual,
            'harga_beli'=>$harga_beli,
            'stok'=>$stok,
            'keterangan'=>$keterangan,
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s')
        );
        $this->Barang_m->save($data_object);//insert untuk menambahkan data
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

      $this->Barang_m->update($object, array(
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

/* End of file Barang.php */
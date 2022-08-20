<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Pembelian extends CI_Controller {
  private $nama_menu  = "Pembelian";     
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_main');
    $this->load->model('Pembelian_m');
    $this->load->model('Supplier_m');
    must_login();
  }
  
  public function index()
  {
    $data['title'] = 'Pembelian | Akunting';
    $data['content'] = "pembelian/index.php";    
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
    $page['count_row'] = $this->Pembelian_m->get_list_count($filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Pembelian_m->get_list_data($filter);
 
    $this->load->view('sistem/pembelian/list_data',$data);
  }

  public function create(){
    $data['title'] = 'Tambah Pembelian | Akunting';
    $data['supplier'] = $this->Supplier_m->get_all();
    $data['nomor_transaksi'] = $this->M_main->get_nomor_transaksi('PBL', 'nomor', 'pembelian');    
    $data['modeform'] = "ADD";
    $data['content'] = "pembelian/form.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function edit($id){
    $data['title'] = 'Edit Pembelian | Akunting';
    $data['supplier'] = $this->Supplier_m->get_all();
    $data['data'] = $this->Pembelian_m->get_by_id($id)->row_array();
    $data['details'] = $this->Pembelian_m->get_pembelian_detail($id)->result();
    $data['nomor_transaksi'] = "";    
    $data['modeform'] = "UPDATE";
    $data['content'] = "pembelian/form.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function save(){
      $no_transaksi =  $this->M_main->get_nomor_transaksi('PBL', 'nomor', 'pembelian');
      $tanggal = $this->input->post('tanggal');
      $tanggal = format_date($tanggal, 'Y-m-d');
      $keterangan = $this->input->post('keterangan');
      $pembayaran = $this->input->post('pembayaran');
      $id_supplier = $this->input->post('id_supplier');
      $id_user = $this->session->userdata("auth_id_user");

      // Details
      $barang = $this->input->post('barang');
      $qty = $this->input->post('qty');
      $harga = $this->input->post('harga');
      $ppn = $this->input->post('ppn');
      
      if(isset($barang)){
        $jml = count($barang);
        
        $id = $this->uuid->v4(false);
        $details = array();
        $total = 0;
        for ($i=0; $i < $jml; $i++) {
          // Sum Total
          $total = 0;
          $details[] = array(
              'id'           => $this->uuid->v4(false),
              'id_pembelian' => $id,
              'id_barang'    => $barang[$i], 
              'jumlah'       => $qty,
              'harga'        => ($harga[$i]!="") ? $harga[$i] : 0,
              'ppn'          => ($ppn[$i]!="") ? $ppn[$i] : 0,
          );
        }

        $data_object = array(
          'id'=>$id,
          'nomor'=>$no_transaksi,
          'tanggal'=>$tanggal,
          'id_supplier'=>$id_supplier,
          'total'=>$total,
          'keterangan'=>$keterangan,
          'pembayaran'=>$pembayaran,
          'status'=>'1',
          'created_by'=>$id_user,
          'created_at'=>date('Y-m-d H:i:s')
        );
        
        // Save Header
        $this->Pembelian_m->save($data_object);
        // Save Detail        
        $this->db->insert_batch('pembelian_detail', $details);
  
        $response['success'] = true;
        $response['message'] = "Data berhasil disimpan";
      }else{
        $response['success'] = false;
        $response['message'] = "Rincian transaksi tidak boleh kosong !";
      }

      echo json_encode($response);   
  }

  public function update(){
    $id = $this->input->post('id');
    $tanggal = $this->input->post('tanggal');
    $tanggal = format_date($tanggal, 'Y-m-d');
    $keterangan = $this->input->post('keterangan');
    $pembayaran = $this->input->post('pembayaran');
    $id_supplier = $this->input->post('id_supplier');
    $id_user = $this->session->userdata("auth_id_user");

    // Details
    $id_pembelian_detail = $this->input->post('id_pembelian_detail');
    $barang = $this->input->post('barang');
    $qty = $this->input->post('qty');
    $harga = $this->input->post('harga');
    $ppn = $this->input->post('ppn');

    if(isset($barang)){
      $jml = count($barang);
      
      $details = array();
      $total = 0;
      for ($i=0; $i < $jml; $i++) {
        // Sum Total
        $total = 0;
        $details[] = array(
            'id'           => ($id_pembelian_detail[$i]!="") ? $id_pembelian_detail[$i] : $this->uuid->v4(false),
            'id_pembelian' => $id,
            'id_barang'    => $barang[$i], 
            'jumlah'       => $qty,
            'harga'        => ($harga[$i]!="") ? $harga[$i] : 0,
            'ppn'          => ($ppn[$i]!="") ? $ppn[$i] : 0,
        );
      }

      $data_object = array(
        'tanggal'=>$tanggal,
        'id_supplier'=>$id_supplier,
        'keterangan'=>$keterangan,
        'pembayaran'=>$pembayaran,
        'total'=>$total,
        'updated_by'=>$id_user,
        'updated_at'=>date('Y-m-d H:i:s')
      );
      
      // Delete Pembelian Detail
      $this->db->delete('pembelian_detail', array('id_pembelian' => $id));
      // Update Header
      $this->Pembelian_m->update($data_object, array(
        'id' => $id
      )); 
      // Save Detail         
      $this->db->insert_batch('pembelian_detail', $details);

      $response['success'] = true;
      $response['message'] = "Data berhasil diupdate";
    }else{
      $response['success'] = false;
      $response['message'] = "Rincian transaksi tidak boleh kosong !";
    }

    echo json_encode($response);   
  }

  public function delete($id){
    if($id){
      $object = array(
        'status' => '0', 
        'updated_at'=>date('Y-m-d H:i:s')
      );

      $this->Pembelian_m->update($object, array(
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

/* End of file Pembelian.php */

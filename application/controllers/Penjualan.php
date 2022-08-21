<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Penjualan extends CI_Controller {
  private $nama_menu  = "Penjualan";     
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_main');
    $this->load->model('Penjualan_m');
    $this->load->model('Pelanggan_m');
    must_login();
  }
  
  public function index()
  {
    $data['title'] = 'Penjualan | Akunting';
    $data['content'] = "penjualan/index.php";    
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
    $page['count_row'] = $this->Penjualan_m->get_list_count($filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Penjualan_m->get_list_data($filter);
 
    $this->load->view('sistem/penjualan/list_data',$data);
  }

  public function create(){
    $data['title'] = 'Tambah Penjualan | Akunting';
    $data['pelanggan'] = $this->Pelanggan_m->get_all();
    $data['nomor_transaksi'] = $this->M_main->get_nomor_transaksi('PJL', 'nomor', 'penjualan');    
    $data['modeform'] = "ADD";
    $data['content'] = "penjualan/form.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function edit($id){
    $data['title'] = 'Edit Penjualan | Akunting';
    $data['pelanggan'] = $this->Pelanggan_m->get_all();
    $data['data'] = $this->Penjualan_m->get_by_id($id)->row_array();
    $data['details'] = $this->Penjualan_m->get_penjualan_detail($id)->result();
    $data['nomor_transaksi'] = "";    
    $data['modeform'] = "UPDATE";
    $data['content'] = "penjualan/form.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function save(){
      $no_transaksi =  $this->M_main->get_nomor_transaksi('PJL', 'nomor', 'penjualan');
      $tanggal = $this->input->post('tanggal');
      $tanggal = format_date($tanggal, 'Y-m-d');
      $keterangan = $this->input->post('keterangan');
      $pembayaran = $this->input->post('pembayaran');
      $id_pelanggan = $this->input->post('id_pelanggan');
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
        $pajak = 0;
        for ($i=0; $i < $jml; $i++) {
          // Sum Total
          $t_qty = ($qty[$i]!="") ? $qty[$i] : 0;
          $t_harga = ($harga[$i]!="") ? $harga[$i] : 0;
          $t_ppn = ($ppn[$i]!="") ? $ppn[$i] : 0;
          $pajak = ($t_qty*$t_harga) * $t_ppn/100;
          $total += ($t_qty*$t_harga) + $pajak;
          $details[] = array(
              'id'           => $this->uuid->v4(false),
              'id_penjualan' => $id,
              'id_barang'    => $barang[$i], 
              'qty'          => $t_qty,
              'harga'        => $t_harga,
              'ppn'          => $t_ppn,
          );
        }

        $data_object = array(
          'id'=>$id,
          'nomor'=>$no_transaksi,
          'tanggal'=>$tanggal,
          'id_pelanggan'=>$id_pelanggan,
          'total'=>$total,
          'keterangan'=>$keterangan,
          'pembayaran'=>$pembayaran,
          'status'=>'1',
          'created_by'=>$id_user,
          'created_at'=>date('Y-m-d H:i:s')
        );
        
        // Save Header
        $this->Penjualan_m->save($data_object);
        // Save Detail        
        $this->db->insert_batch('penjualan_detail', $details);
  
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
    $id_pelanggan = $this->input->post('id_pelanggan');
    $id_user = $this->session->userdata("auth_id_user");

    // Details
    $id_penjualan_detail = $this->input->post('id_penjualan_detail');
    $barang = $this->input->post('barang');
    $qty = $this->input->post('qty');
    $harga = $this->input->post('harga');
    $ppn = $this->input->post('ppn');

    if(isset($barang)){
      $jml = count($barang);
      
      $details = array();
      $total = 0;
      $pajak = 0;
      for ($i=0; $i < $jml; $i++) {
        // Sum Total
        $t_qty = ($qty[$i]!="") ? $qty[$i] : 0;
        $t_harga = ($harga[$i]!="") ? $harga[$i] : 0;
        $t_ppn = ($ppn[$i]!="") ? $ppn[$i] : 0;
        $pajak = ($t_qty*$t_harga) * $t_ppn/100;
        $total += ($t_qty*$t_harga) + $pajak;
        $details[] = array(
            'id'           => ($id_penjualan_detail[$i]!="") ? $id_penjualan_detail[$i] : $this->uuid->v4(false),
            'id_penjualan' => $id,
            'id_barang'    => $barang[$i], 
            'qty'          => $t_qty,
            'harga'        => $t_harga,
            'ppn'          => $t_ppn,
        );
      }

      $data_object = array(
        'tanggal'=>$tanggal,
        'id_pelanggan'=>$id_pelanggan,
        'keterangan'=>$keterangan,
        'pembayaran'=>$pembayaran,
        'total'=>$total,
        'updated_by'=>$id_user,
        'updated_at'=>date('Y-m-d H:i:s')
      );
      
      // Delete Pembelian Detail
      $this->db->delete('penjualan_detail', array('id_penjualan' => $id));
      // Update Header
      $this->Penjualan_m->update($data_object, array(
        'id' => $id
      )); 
      // Save Detail         
      $this->db->insert_batch('penjualan_detail', $details);

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

      $this->Penjualan_m->update($object, array(
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

/* End of file Penjualan.php */

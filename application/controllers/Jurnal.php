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
    $page['count_row'] = $this->Jurnal_m->get_list_count($filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Jurnal_m->get_list_data($filter);
 
    $this->load->view('sistem/jurnal/list_data',$data);
  }

  public function create(){
    $data['title'] = 'Tambah Jurnal Umum | Akunting';
    $data['nomor_transaksi'] = $this->M_main->get_nomor_transaksi('JUM', 'nomor', 'acc_jurnal');    
    $data['modeform'] = "ADD";
    $data['content'] = "jurnal/form.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function edit($id){
    $data['title'] = 'Edit Jurnal Umum | Akunting';
    $data['data'] = $this->Jurnal_m->get_by_id($id)->row_array();
    $data['details'] = $this->Jurnal_m->get_jurnal_detail($id)->result();
    $data['nomor_transaksi'] = "";    
    $data['modeform'] = "UPDATE";
    $data['content'] = "jurnal/form.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function save(){
      $no_transaksi =  $this->M_main->get_nomor_transaksi('JUM', 'nomor', 'acc_jurnal');
      $tanggal = $this->input->post('tanggal');
      $tanggal = format_date($tanggal, 'Y-m-d');
      $keterangan = $this->input->post('keterangan');

      // Details
      $akun = $this->input->post('akun');
      $uraian = $this->input->post('ket');
      $debet = $this->input->post('debet');
      $kredit = $this->input->post('kredit');

      if(isset($akun)){
        $jml = count($akun);
        
        $id = $this->uuid->v4(false);
        $details = array();
        $total = 0;
        for ($i=0; $i < $jml; $i++) {
          // Sum Total
          $t_debet = ($debet[$i]!="") ? $debet[$i] : 0;
          $total += $t_debet;
          $details[] = array(
              'id'         => $this->uuid->v4(false),
              'id_jurnal'  => $id,
              'id_akun'    => $akun[$i], 
              'akun_kb'    => 0,
              'debet'      => ($debet[$i]!="") ? $debet[$i] : 0,
              'kredit'     => ($kredit[$i]!="") ? $kredit[$i] : 0,
              'keterangan' => $uraian[$i],
              'rate'       => 1,
              'urut'       => $i+1,
          );
        }

        $data_object = array(
          'id'=>$id,
          'nomor'=>$no_transaksi,
          'tanggal'=>$tanggal,
          'id_kelompok_jurnal'=>1, //Jurnal Umum
          'keterangan'=>$keterangan,
          'total'=>$total,
          'multi_currency'=>1,
          'status'=>'1',
          'created_at'=>date('Y-m-d H:i:s')
        );
        
        // Save Header
        $this->Jurnal_m->save($data_object);
        // Save Detail        
        $this->db->insert_batch('acc_jurnal_detail', $details);
  
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

    // Details
    $id_jurnal_detail = $this->input->post('id_jurnal_detail');
    $akun = $this->input->post('akun');
    $uraian = $this->input->post('ket');
    $debet = $this->input->post('debet');
    $kredit = $this->input->post('kredit');

    if(isset($akun)){
      $jml = count($akun);
      
      $details = array();
      $total = 0;
      for ($i=0; $i < $jml; $i++) {
        // Sum Total
        $t_debet = ($debet[$i]!="") ? $debet[$i] : 0;
        $total += $t_debet;
        $details[] = array(
            'id'         => ($id_jurnal_detail[$i]!="") ? $id_jurnal_detail[$i] : $this->uuid->v4(false),
            'id_jurnal'  => $id,
            'id_akun'    => $akun[$i], 
            'akun_kb'    => 0,
            'debet'      => ($debet[$i]!="") ? $debet[$i] : 0,
            'kredit'     => ($kredit[$i]!="") ? $kredit[$i] : 0,
            'keterangan' => $uraian[$i],
            'rate'       => 1,
            'urut'       => $i+1,
        );
      }

      $data_object = array(
        'tanggal'=>$tanggal,
        'keterangan'=>$keterangan,
        'total'=>$total,
        'updated_at'=>date('Y-m-d H:i:s')
      );
      
      // Delete Jurnal Detail
      $this->db->delete('acc_jurnal_detail', array('id_jurnal' => $id));
      // Update Header
      $this->Jurnal_m->update($data_object, array(
        'id' => $id
      )); 
      // Save Detail         
      $this->db->insert_batch('acc_jurnal_detail', $details);

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

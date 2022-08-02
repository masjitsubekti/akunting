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

  public function buku_besar() {
    $data['title'] = "Laporan Buku Besar"; 
    $tanggal_awal = $this->input->get("tanggal_awal");
    $tanggal_akhir = $this->input->get("tanggal_akhir");
    
    $filter = array(
      'tanggal_awal' => format_date($tanggal_awal, 'Y-m-d'),
      'tanggal_akhir' => format_date($tanggal_akhir, 'Y-m-d'),
      'nomor_akun' => ($this->input->get("nomor_akun")!="") ? $this->input->get("nomor_akun") : "",
      'hidden_nol' => ($this->input->get("hidden_nol")!="") ? $this->input->get("hidden_nol") : "1",
    );

    $report = $this->Report_m->get_report_buku_besar($filter)->result();
    $data['tanggal_awal'] = $tanggal_awal;
    $data['tanggal_akhir'] = $tanggal_akhir;
    
    $group = array();
    // Group
    foreach ($report as $row) {
      $key = $row->kode .' '. $row->nama_akun;
      $group [$key][] = $row;
    }

    // Set child
    $result = array();
    $index = 0;
    foreach ($group as $key => $value) {
      $saldo_awal = 0;
      $total_debet = 0;
      $total_kredit = 0;
      $details = array();
      $saldo_awal = (count($value)>0) ? $value[0]->saldo_awal : 0;
      for ($i=0; $i<count($value); $i++) {
        $total_debet += $value[$i]->debet;
        $total_kredit += $value[$i]->kredit;
        
        $details [] = (object) array(
          "kode"=> $value[$i]->kode,
          "nama_akun"=> $value[$i]->nama_akun,
          "tanggal"=> $value[$i]->tanggal,
          "nomor"=> $value[$i]->nomor,
          "keterangan"=> $value[$i]->keterangan,
          "urut"=> $value[$i]->urut,
          "debet"=> $value[$i]->debet,
          "kredit"=> $value[$i]->kredit,
          "saldo" => ((count($details)==0) ? $saldo_awal : $details[count($details)-1]->saldo) + $value[$i]->debet - $value[$i]->kredit,
        );
      }
      
      $result [] = (object) array(
        "nama_akun" => $key, 
        "saldo_awal" => $saldo_awal, 
        "total_debet" => $total_debet, 
        "total_kredit" => $total_kredit, 
        "details" => $details, 
      );

      $index++;
    }

    $data['report'] = $result;

    // echo json_encode($result);
    $this->load->library('pdf');
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "Laporan Buku Besar.pdf";
    $this->pdf->load_view('sistem/report/cetak_laporan_buku_besar.php', $data);
  }
}

/* End of file Report.php */

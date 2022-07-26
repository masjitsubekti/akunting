<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Report extends CI_Controller {

  private $nama_menu  = "Laporan";
  private $kelompokHPP  = "HARGA POKOK PENJUALAN";
  private $grupPendapatan  = "PENDAPATAN";
  private $grupBeban  = "BEBAN";
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
      'hidden_nol' => ($this->input->get("hidden_nol")!="") ? $this->input->get("hidden_nol") : "0",
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

  public function laba_rugi() {
    $data['title'] = "Laporan Laba Rugi"; 
    $tanggal_awal = $this->input->get("tanggal_awal");
    $tanggal_akhir = $this->input->get("tanggal_akhir");
    
    $filter = array(
      'tanggal_awal' => format_date($tanggal_awal, 'Y-m-d'),
      'tanggal_akhir' => format_date($tanggal_akhir, 'Y-m-d'),
      'hidden_nol' => ($this->input->get("hidden_nol")!="") ? $this->input->get("hidden_nol") : "0",
    );

    $report = $this->Report_m->get_report_laba_rugi($filter)->result();
    $data['tanggal_awal'] = $tanggal_awal;
    $data['tanggal_akhir'] = $tanggal_akhir;
    
    /**
     * Akun yang ada pada laporan laba rugi : akun pendapatan dan beban
     * Rumus 
     * Laba kotor = pendapatan - HPP (Harga pokok penjualan)
     * Laba bersih = laba kotor - beban 
     */
    $totalPendapatan = 0;
    $totalHPP = 0;
    $totalBeban = 0;
    $totalBebanSelainHPP = 0;
    $labaKotor = 0;
    foreach ($report as $row) {
      $kel = $row->kelompok_akun;
      $grup = $row->grup;
      // Pendapatan
      if(strtoupper($grup)==$this->grupPendapatan){
        $totalPendapatan += ($row->is_det==1) ? $row->total : 0;
      }
      
      // HPP
      if(strtoupper($kel)==$this->kelompokHPP){
        $totalHPP += ($row->is_det==1) ? $row->total : 0;
      }

      // Beban
      if(strtoupper($grup)==$this->grupBeban){
        $totalBeban += ($row->is_det==1) ? $row->total : 0;
      }
    }

    $totalBebanSelainHPP = $totalBeban - $totalHPP;
    $labaKotor = $totalPendapatan + $totalHPP;
    $labaBersih = $labaKotor + $totalBebanSelainHPP;
    $bebanPajak = $labaBersih*25/100;
    $labaBersihPajak = $labaBersih - $bebanPajak;

    $data['report'] = $report;
    $data['laba_kotor'] = $labaKotor;
    $data['laba_bersih'] = $labaBersih;
    $data['beban_pajak'] = $bebanPajak;
    $data['laba_bersih_pajak'] = $labaBersihPajak;

    // echo json_encode($result);
    $this->load->library('pdf');
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "Laporan Laba Rugi.pdf";
    $this->pdf->load_view('sistem/report/cetak_laporan_laba_rugi.php', $data);
  }

  public function neraca_saldo() {
    $data['title'] = "Laporan Neraca Percobaan (Saldo)"; 
    $tanggal_awal = $this->input->get("tanggal_awal");
    $tanggal_akhir = $this->input->get("tanggal_akhir");
    
    $filter = array(
      'tanggal_awal' => format_date($tanggal_awal, 'Y-m-d'),
      'tanggal_akhir' => format_date($tanggal_akhir, 'Y-m-d'),
      'nomor_akun' => ($this->input->get("nomor_akun")!="") ? $this->input->get("nomor_akun") : "",
      'hidden_nol' => ($this->input->get("hidden_nol")!="") ? $this->input->get("hidden_nol") : "0",
    );

    $report = $this->Report_m->get_report_neraca_saldo($filter)->result();
    $data['tanggal_awal'] = $tanggal_awal;
    $data['tanggal_akhir'] = $tanggal_akhir;

    $saw_debit = 0;
    $saw_kredit = 0;
    $mut_debit = 0;
    $mut_kredit = 0;
    $sak_debit = 0;
    $sak_kredit = 0;
    
    foreach ($report as $row) {
      $saw_debit += $row->saldo_awal_debit;
      $saw_kredit += $row->saldo_awal_kredit;
      $mut_debit += $row->mutasi_debit;
      $mut_kredit += $row->mutasi_kredit;
      $sak_debit += $row->saldo_akhir_debit;
      $sak_kredit += $row->saldo_akhir_kredit;
    }
    
    $data['report'] = $report;
    $data['saw_debit'] = $saw_debit;
    $data['saw_kredit'] = $saw_kredit;
    $data['mut_debit'] = $mut_debit;
    $data['mut_kredit'] = $mut_kredit;
    $data['sak_debit'] = $sak_debit;
    $data['sak_kredit'] = $sak_kredit;
    // echo json_encode($report);
    $this->load->library('pdf');
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "Laporan Neraca Percobaan (Saldo).pdf";
    $this->pdf->load_view('sistem/report/cetak_laporan_neraca_saldo.php', $data);
  }

  public function posisi_keuangan() {
    // Laporan Neraca Detail
    $data['title'] = "Laporan Posisi Keuangan"; 
    $tanggal_awal = $this->input->get("tanggal_awal");
    $tanggal_akhir = $this->input->get("tanggal_akhir");
    
    $filter = array(
      'tanggal_awal' => format_date($tanggal_awal, 'Y-m-d'),
      'tanggal_akhir' => format_date($tanggal_akhir, 'Y-m-d'),
      'hidden_nol' => ($this->input->get("hidden_nol")!="") ? $this->input->get("hidden_nol") : "0",
    );

    $report = $this->Report_m->get_report_neraca_detail($filter)->result();
    $data['tanggal_awal'] = $tanggal_awal;
    $data['tanggal_akhir'] = $tanggal_akhir;
    
    $group = array();
    // Group key
    foreach ($report as $row) {
      $key = $row->kelompok_neraca;
      $group [$key][$row->kelompok_akun_tree][] = $row;
    }

    $result = array();
    foreach ($group as $key => $value) {
      $total_kelompok_neraca = 0;
      $kelompok = array();
      foreach ($value as $kelompok_key => $kelompok_value) {
        $total_kelompok_akun = 0;
        // Get total
        $details = array();
        for ($i=0; $i<count($kelompok_value); $i++) { 
          // Jika sama dengan kelompok akun
          if($kelompok_key!=$kelompok_value[$i]->nama){
            $total_kelompok_neraca += $kelompok_value[$i]->total;
            $total_kelompok_akun += $kelompok_value[$i]->total;

            $details [] = (object) array(
              "grup" => $kelompok_value[$i]->grup,
              "kelompok_neraca" =>  $kelompok_value[$i]->kelompok_neraca,
              "kelompok_akun" => $kelompok_value[$i]->kelompok_akun_tree,
              "kode" =>  $kelompok_value[$i]->kode,
              "nama" => $kelompok_value[$i]->nama,
              "total" => $kelompok_value[$i]->total,
            );
          }
        }

        $kelompok [] = (object) array(
          "kelompok_akun" => $kelompok_key, 
          "total" => $total_kelompok_akun,
          "details" => $details 
        );
      }

      $result [] = (object) array(
        "kelompok_neraca" => $key,
        "kelompok_akun" => $kelompok, 
        "total" => $total_kelompok_neraca 
      );
    }

    // echo json_encode($result);
    $data['report'] = $result;
    $this->load->library('pdf');
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "Laporan Posisi Keuangan.pdf";
    $this->pdf->load_view('sistem/report/cetak_laporan_posisi_keuangan.php', $data);
  }
}

/* End of file Report.php */

<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Report_m extends CI_Model {
      function get_report_buku_besar($filter=array())
      {   
          $tgl_awal = $filter['tanggal_awal'];
          $tgl_akhir = $filter['tanggal_akhir'];
          $nomor_akun = $filter['nomor_akun'];
          $hidden_nol = $filter['hidden_nol'];

          $query = $this->db->query("CALL fn_report_buku_besar('$tgl_awal', '$tgl_akhir', '$nomor_akun', '$hidden_nol')");
          return $query;
      }
    }
?>
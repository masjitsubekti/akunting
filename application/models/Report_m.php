<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Report_m extends CI_Model {
      function get_lap_buku_besar($q)
      {   
          $query = $this->db->query(" 
              SELECT * FROM vw_akun_tree
              WHERE CONCAT(kode, nama, kelompok_akun) LIKE '%$q%'
          ");
          return $query;
      }
    }
?>
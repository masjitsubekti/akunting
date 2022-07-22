<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Akun_m extends CI_Model {
      function get_list_count($key=""){
          $query = $this->db->query("
              select count(*) as jml from acc_akun 
              where concat(kode, nama) like '%$key%' and status = '1'
          ")->row_array();
          return $query;
      }

      function get_list_data($key="",  $limit="", $offset="", $column="", $sort=""){
          $query = $this->db->query("
              select * from acc_akun
              where concat(kode, nama) like '%$key%' and status = '1'
              order by $column $sort
              limit $limit offset $offset
          ");
          return $query;
      }

      function get_all(){
          $query = $this->db->select('id, nama')
                  ->where('status', '1')
                  ->order_by('nama', 'asc')
                  ->get('acc_akun');
          return $query;
      }
    }
?>
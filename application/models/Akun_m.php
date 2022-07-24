<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Akun_m extends CI_Model {
      private $table = 'acc_akun';

      public function save($data)
      {
        $this->db->insert($table, $data);
      }
      
      public function update($data, $where)
      {
        $this->db->update($table, $data, $where);
      }

      function get_kelompok_akun()
      {
        $query = $this->db->select('id, nama')
                ->order_by('urut', 'asc')
                ->get('acc_kelompok_akun');
        return $query->result();
      }
      
      function get_list_count($key="")
      {
          $query = $this->db->query("
              select count(*) as jml from acc_akun 
              where concat(kode, nama) like '%$key%' and status = '1'
          ")->row_array();
          return $query;
      }

      function get_list_data($key="",  $limit="", $offset="", $column="", $sort="")
      {
          $query = $this->db->query("
              select * from acc_akun
              where concat(kode, nama) like '%$key%' and status = '1'
              order by $column $sort
              limit $limit offset $offset
          ");
          return $query;
      }
    }
?>
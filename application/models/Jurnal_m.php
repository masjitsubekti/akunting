<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Jurnal_m extends CI_Model {
      private $table = 'acc_jurnal';
      private $table_detail = 'acc_jurnal_detail';
      private $column_map = array(
        'no_bukti' => 'no_bukti',
        'tanggal' => 'tanggal',
        'keterangan' => 'keterangan',
        'created_at' => 'created_at',
      );

      public function save($data)
      {
        $this->db->insert($this->table, $data);
      }

      public function save_detail($data)
      {
        $this->db->insert($this->table_detail, $data);
      }
      
      public function update($data, $where)
      {
        $this->db->update($this->table, $data, $where);
      }

      function get_list_count($key="")
      { 
          $query = $this->db->query("
              SELECT count(*) as jml FROM acc_jurnal 
              WHERE concat(no_bukti, tanggal, keterangan, total) like '%$key%' and status = '1'
          ")->row_array();
          return $query;
      }

      function get_list_data($key="",  $limit="", $offset="", $column="", $sort="")
      {   
          $sortby = $this->column_map[$column];
          $query = $this->db->query("
              SELECT * FROM acc_jurnal
              WHERE concat(no_bukti, tanggal, keterangan, total) like '%$key%' and status = '1'
              order by $sortby $sort
              limit $limit offset $offset
          ");
          return $query;
      }

      function get_by_id($id)
      {   
          $query = $this->db->query("
              SELECT * FROM acc_jurnal WHERE id = '$id'
          ");
          return $query;
      }
    }
?>
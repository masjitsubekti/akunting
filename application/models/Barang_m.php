<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Barang_m extends CI_Model {
      private $table = 'm_barang';
      private $column_map = array(
        'kode' => 'b.kode',
        'nama' => 'b.nama',
        'jenis_barang' => 'jp.nama',
        'satuan' => 's.nama',
        'created_at' => 'b.created_at',
      );

      public function save($data)
      {
          $this->db->insert($this->table, $data);
      }
      
      public function update($data, $where)
      {
          $this->db->update($this->table, $data, $where);
      }

      function get_by_id($id)
      {   
          $query = $this->db->query(" SELECT * FROM m_barang WHERE id = '$id'");
          return $query;
      }

      function get_list_count($filter)
      { 
          $key = $filter['q'];
          $q = "
            SELECT count(*) as jml FROM m_barang b
            LEFT JOIN m_jenis_barang jp ON b.id_jenis = jp.id 
            LEFT JOIN m_satuan s ON b.id_satuan = s.id
            WHERE CONCAT(b.kode, b.nama, jp.nama, s.nama, b.keterangan) LIKE '%$key%' 
            AND b.status = '1'
          ";
          
          $query = $this->db->query($q)->row_array();
          return $query;
      }

      function get_list_data($filter)
      {   
          $sortby = $filter['sortby'];
          $sorttype = $filter['sorttype'];
          $offset = $filter['offset'];
          $limit = $filter['limit'];
          $key = $filter['q']; 
          $sortby = $this->column_map[$sortby];

          $q = "
              SELECT b.*, jp.nama AS jenis_produk, s.nama AS nama_satuan FROM m_barang b
              LEFT JOIN m_jenis_barang jp ON b.id_jenis = jp.id 
              LEFT JOIN m_satuan s ON b.id_satuan = s.id
              WHERE CONCAT(b.kode, b.nama, jp.nama, s.nama, b.keterangan) LIKE '%$key%' 
              AND b.status = '1'
          ";

          $q .= " order by $sortby $sorttype limit $limit offset $offset";

          $query = $this->db->query($q);
          return $query;
      }
    }
?>
<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Penjualan_m extends CI_Model {
      private $table = 'penjualan';
      private $table_detail = 'penjualan_detail';
      private $column_map = array(
        'nomor' => 'p.nomor',
        'tanggal' => 'p.tanggal',
        'keterangan' => 'p.keterangan',
        'pelanggan' => 'pl.nama',
        'created_at' => 'p.created_at',
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

      function get_list_count($filter)
      { 
          $key = $filter['q'];
          $startdate = $filter['startdate'];
          $enddate = $filter['enddate'];

          $q = "
            SELECT count(*) as jml FROM penjualan p 
            LEFT JOIN m_pelanggan pl ON p.id_pelanggan = pl.id
            WHERE concat(p.nomor, p.tanggal, p.keterangan, pl.nama, p.total) like '%$key%' AND p.status = '1'
          ";

          if($startdate!="" && $enddate!=""){
            $q .= " AND p.tanggal BETWEEN '$startdate' AND '$enddate'";
          }
          
          $query = $this->db->query($q)->row_array();
          return $query;
      }

      function get_list_data($filter)
      {   
          $startdate = $filter['startdate'];
          $enddate = $filter['enddate'];
          $sortby = $filter['sortby'];
          $sorttype = $filter['sorttype'];
          $offset = $filter['offset'];
          $limit = $filter['limit'];
          $key = $filter['q']; 
          $sortby = $this->column_map[$sortby];

          $q = "
              SELECT p.*, pl.nama as nama_pelanggan FROM penjualan p
              LEFT JOIN m_pelanggan pl ON p.id_pelanggan = pl.id
              WHERE concat(p.nomor, p.tanggal, p.keterangan, pl.nama, p.total) like '%$key%' AND p.status = '1'
          ";

          if($startdate!="" && $enddate!=""){
            $q .= " AND p.tanggal BETWEEN '$startdate' AND '$enddate'";
          }

          $q .= " order by $sortby $sorttype limit $limit offset $offset";

          $query = $this->db->query($q);
          return $query;
      }

      function get_by_id($id)
      {   
          $query = $this->db->query("
              SELECT * FROM penjualan WHERE id = '$id'
          ");
          return $query;
      }

      function get_penjualan_detail($id)
      {   
          $query = $this->db->query("
              SELECT pd.*, b.kode AS kode_barang, b.nama AS nama_barang FROM penjualan_detail pd
              LEFT JOIN m_barang b ON pd.id_barang = b.id 
              WHERE pd.id_penjualan = '$id'
              ORDER BY pd.created_at ASC
          ");
          return $query;
      }
    }
?>
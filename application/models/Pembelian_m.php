<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Pembelian_m extends CI_Model {
      private $table = 'pembelian';
      private $table_detail = 'pembelian_detail';
      private $column_map = array(
        'nomor' => 'p.nomor',
        'tanggal' => 'p.tanggal',
        'keterangan' => 'p.keterangan',
        'supplier' => 's.nama',
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
            SELECT count(*) as jml FROM pembelian p 
            LEFT JOIN m_supplier s ON p.id_supplier = s.id
            WHERE concat(p.nomor, p.tanggal, p.keterangan, s.nama, p.total) like '%$key%' AND p.status = '1'
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
              SELECT p.*, s.nama as nama_supplier FROM pembelian p
              LEFT JOIN m_supplier s ON p.id_supplier = s.id
              WHERE concat(p.nomor, p.tanggal, p.keterangan, s.nama, p.total) like '%$key%' AND p.status = '1'
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
              SELECT * FROM pembelian WHERE id = '$id'
          ");
          return $query;
      }

      function get_pembelian_detail($id)
      {   
          $query = $this->db->query("
              SELECT p.*, s.nama AS nama_supplier FROM pembelian_detail pd
              LEFT JOIN pembelian p ON pd.id_akun = p.id 
              WHERE pd.id_pembelian = '$id'
              ORDER BY pd.created_at ASC
          ");
          return $query;
      }
    }
?>
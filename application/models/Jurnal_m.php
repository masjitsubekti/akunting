<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Jurnal_m extends CI_Model {
      private $table = 'acc_jurnal';
      private $table_detail = 'acc_jurnal_detail';
      private $column_map = array(
        'nomor' => 'nomor',
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

      function get_list_count($filter)
      { 
          $key = $filter['q'];
          $startdate = $filter['startdate'];
          $enddate = $filter['enddate'];

          $q = "
            SELECT count(*) as jml FROM acc_jurnal 
            WHERE concat(nomor, tanggal, keterangan, total) like '%$key%' and status = '1' ";

          if($startdate!="" && $enddate!=""){
            $q .= " AND tanggal BETWEEN '$startdate' AND '$enddate'";
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
              SELECT * FROM acc_jurnal
              WHERE concat(nomor, tanggal, keterangan, total) like '%$key%' and status = '1'
          ";

          if($startdate!="" && $enddate!=""){
            $q .= " AND tanggal BETWEEN '$startdate' AND '$enddate'";
          }

          $q .= " order by $sortby $sorttype limit $limit offset $offset";

          $query = $this->db->query($q);
          return $query;
      }

      function get_by_id($id)
      {   
          $query = $this->db->query("
              SELECT * FROM acc_jurnal WHERE id = '$id'
          ");
          return $query;
      }

      function get_jurnal_detail($id)
      {   
          $query = $this->db->query("
              SELECT jd.*, a.kode as kode_akun, a.nama AS nama_akun FROM acc_jurnal_detail jd
              LEFT JOIN acc_akun a ON jd.id_akun = a.id 
              WHERE jd.id_jurnal = '$id'
              ORDER BY jd.urut ASC
          ");
          return $query;
      }
    }
?>
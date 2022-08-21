<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Posting_m extends CI_Model {

      /**
       * List Outstanding untuk diposting ke jurnal
       * 
       */
      private $column_map = array(
        'nomor' => 'nomor',
        'tanggal' => 'tanggal',
        'keterangan' => 'keterangan',
        'created_at' => 'created_at',
      );
      
      private $selectOutstanding = "
          SELECT 'PEMBELIAN' AS sumber_transaksi, pb.id, pb.nomor, pb.tanggal, pb.keterangan, pb.total, pb.pembayaran, pb.created_at FROM pembelian pb
          WHERE pb.STATUS = '1'
          AND pb.posted_at IS NULL
          UNION ALL
          SELECT 'PENJUALAN' AS sumber_transaksi, pj.id, pj.nomor, pj.tanggal, pj.keterangan, pj.total, pj.pembayaran, pj.created_at FROM penjualan pj
          WHERE pj.STATUS = '1'
          AND pj.posted_at IS NULL
      ";

      function get_list_count($filter)
      { 
          $key = $filter['q'];
          $startdate = $filter['startdate'];
          $enddate = $filter['enddate'];

          $q = "
            SELECT count(*) as jml FROM ($this->selectOutstanding)x
            WHERE concat(nomor, tanggal, keterangan, total) like '%$key%' ";

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
              SELECT * FROM ($this->selectOutstanding)x
              WHERE concat(nomor, tanggal, keterangan, total) like '%$key%'
          ";

          if($startdate!="" && $enddate!=""){
            $q .= " AND tanggal BETWEEN '$startdate' AND '$enddate'";
          }

          $q .= " order by $sortby $sorttype limit $limit offset $offset";

          $query = $this->db->query($q);
          return $query;
      }

    }
?>
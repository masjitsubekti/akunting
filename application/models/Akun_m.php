<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Akun_m extends CI_Model {
      private $table = 'acc_akun';
      private $column_map = array(
        'kode' => 'a.kode',
        'nama' => 'a.nama',
        'kelompok_akun' => 'ka.nama',
        'created_at' => 'a.created_at',
      );

      public function save($data)
      {
        $this->db->insert($this->table, $data);
      }
      
      public function update($data, $where)
      {
        $this->db->update($this->table, $data, $where);
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
              SELECT count(*) as jml FROM acc_akun a
              LEFT JOIN acc_kelompok_akun ka ON a.id_kelompok = ka.id 
              WHERE concat(a.kode, a.nama, ka.nama) like '%$key%' and status = '1'
          ")->row_array();
          return $query;
      }

      function get_list_data($key="",  $limit="", $offset="", $column="", $sort="")
      {   
          $sortby = $this->column_map[$column];
          $query = $this->db->query("
              SELECT a.*, ka.nama AS nama_kelompok_akun FROM acc_akun a
              LEFT JOIN acc_kelompok_akun ka ON a.id_kelompok = ka.id 
              WHERE concat(a.kode, a.nama, ka.nama) like '%$key%' and status = '1'
              order by $sortby $sort
              limit $limit offset $offset
          ");
          return $query;
      }

      function get_by_id($id)
      {   
          $query = $this->db->query("
              SELECT a.*, ka.nama AS nama_kelompok_akun, aa.nama as nama_parent_akun FROM acc_akun a
              LEFT JOIN acc_kelompok_akun ka ON a.id_kelompok = ka.id
              LEFT JOIN acc_akun aa ON a.id_parent = aa.id 
              WHERE a.id = '$id'
          ");
          return $query;
      }

      function get_akun_tree($q)
      {   
          $query = $this->db->query(" 
              SELECT a.*, (
                SELECT COUNT(*) AS jml FROM acc_akun
                WHERE STATUS = '1' AND id_parent = a.id
              )have_child FROM vw_akun_tree a
              WHERE CONCAT(a.kode, a.nama, a.kelompok_akun) LIKE '%$q%'
          ");
          return $query;
      }
    }
?>
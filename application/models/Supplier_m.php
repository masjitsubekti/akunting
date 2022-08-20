<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Supplier_m extends CI_Model {
      private $table = 'm_supplier';
      private $column_map = array(
        'kode' => 'kode',
        'nama' => 'nama',
        'alamat' => 'alamat',
        'created_at' => 'created_at',
      );

      public function save($data)
      {
          $this->db->insert($this->table, $data);
      }
      
      public function update($data, $where)
      {
          $this->db->update($this->table, $data, $where);
      }

      function get_all()
      {   
        $this->db->select('id, kode, nama');
        $this->db->where('status', '1');
        return $this->db->get($this->table)->result();
      }

      function get_by_id($id)
      {   
          $query = $this->db->query(" SELECT * FROM m_supplier WHERE id = '$id'");
          return $query;
      }

      function get_list_count($filter)
      { 
          $key = $filter['q'];
          $q = "
            SELECT count(*) as jml FROM m_supplier 
            WHERE concat(kode, nama, keterangan) like '%$key%' and status = '1' ";
          
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
              SELECT * FROM m_supplier
              WHERE concat(kode, nama, keterangan) like '%$key%' and status = '1'
          ";

          $q .= " order by $sortby $sorttype limit $limit offset $offset";

          $query = $this->db->query($q);
          return $query;
      }
    }
?>
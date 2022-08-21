<?php
    $x = ($paging['limit']*$paging['current'])-$paging['limit'];
    $no = ($x<=0) ? 0 : $x;
    $no++;
?>
<div class="table-responsive">
  <table class="table table-bordered">
    <thead class="tr-head">
      <tr>
        <th width="3%" class="text-center">No. </th>
        <th width="10%" class="text-center sortable" id="column_kode" data-sort="" onclick="sort_table('#column_kode','kode')">Kode </th>
        <th width="30%" class="sortable" id="column_nama" data-sort="" onclick="sort_table('#column_nama','nama')">Nama </th>
        <th width="15%" class="sortable" id="column_jenis" data-sort="" onclick="sort_table('#column_jenis','jenis_barang')">Jenis Barang </th>
        <th width="10%" class="text-center sortable" id="column_satuan" data-sort="" onclick="sort_table('#column_satuan','satuan')">Satuan </th>
        <th width="10%" class="text-center">Stok </th>
      </tr>
      </thead>
      <tbody>
      <?php 
        if($list->num_rows()!=0){
        $no=($paging['current']-1)*$paging['limit']; 
        foreach ($list->result() as $row) { $no++; ?>
          <tr style="cursor: pointer;" onclick='selectRow(<?php echo json_encode($row) ?>)'>
            <td class="text-center"><?= $no ?>.</td>
            <td class="text-center"><?= $row->kode ?></td>
            <td><?= $row->nama ?></td>
            <td><?= $row->jenis_barang ?></td>
            <td class="text-center"><?= $row->nama_satuan ?></td>
            <td class="text-center"><?= $row->stok ?></td>
          </tr>
        <?php 
          }
        }else{
        ?>
        <tr>
          <td colspan="6">Data tidak ditemukan!</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php 
  if($list->num_rows()>0){
?>
<div class="row">
  <br>
  <div class="col-xs-12 col-md-6" style="padding-top:5px; color:#333;">
    Menampilkan data
    <?php $batas_akhir = (($paging['current'])*$paging['limit']);
    if ($batas_akhir > $paging['count_row']) {
        $batas_akhir = $paging['count_row'];
    }
    echo ((($paging['current']-1)*$paging['limit'])+1).' - '.$batas_akhir.' dari total '.$paging['count_row']; ?>
    data
  </div>
  <br>
  <div class="col-xs-12 col-md-6">
    <div style="float:right;">  
      <?php echo $paging['list']; ?>
    </div>
  </div>
</div>
<?php } ?>
<?php
    $x = ($paging['limit']*$paging['current'])-$paging['limit'];
    if($x<=0)
    {
        $no=0;
    }
    else
    {
        $no = $x;
    }
    $no++;
?>
<div class="table-responsive">
  <table class="table table-bordered">
    <thead class="tr-head">
      <tr>
        <th width="3%" class="text-center">No. </th>
        <th width="10%" class="sortable" id="column_nomor" data-sort="" onclick="sort_table('#column_nomor','nomor')">Nomor </th>
        <th width="10%" class="sortable text-center" id="column_tanggal" data-sort="" onclick="sort_table('#column_tanggal','tanggal')">Tanggal </th>
        <th width="10%" class="sortable" id="column_pelanggan" data-sort="" onclick="sort_table('#column_pelanggan','pelanggan')">Pelanggan </th>
        <th width="20%" class="sortable" id="column_keterangan" data-sort="" onclick="sort_table('#column_keterangan','keterangan')">Keterangan/Uraian </th>
        <th width="10%" class="text-end">Total (Rp)</th>
        <th class="text-center" width="10%">Aksi</th>
      </tr>
      </thead>
      <tbody>
      <?php 
        if($list->num_rows()!=0){
        $no=($paging['current']-1)*$paging['limit']; 
        foreach ($list->result() as $row) { $no++; ?>
          <tr>
            <td class="text-center"><?= $no ?>.</td>
            <td><?= $row->nomor ?></td>
            <td class="text-center"><?= format_date($row->tanggal, 'd/m/Y') ?></td>
            <td><?= $row->nama_pelanggan ?></td>
            <td><?= $row->keterangan ?></td>
            <td class="text-end"><?= rupiah($row->total, "") ?></td>
            <td class="text-center">
              <a href="<?= site_url('Penjualan/edit/'.$row->id) ?>" data-id="<?=$row->id?>" data-name="<?=$row->nomor?>" class="btn btn-sm btn-warning btn-edit" data-toggle="tooltip" title="Edit Jurnal"><i style="color:#fff;" class="fa fa-edit"></i></a>
              <a href="javascript:;" data-id="<?=$row->id?>" data-name="<?=$row->nomor?>" class="btn btn-sm btn-danger btn-delete" data-toggle="tooltip" title="Hapus Jurnal"><i class="fa fa-trash"></i></a>	    
            </td>
          </tr>
        <?php 
          }
        }else{
        ?>
        <tr>
          <td colspan="7">Data tidak ditemukan!</td>
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
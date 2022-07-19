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
        <th width="15%" class="sortable" id="column_nama" data-sort="" onclick="sort_table('#column_nama','nama')">Nama </th>
        <th width="15%" class="sortable" id="column_username" data-sort="" onclick="sort_table('#column_username','username')">Username </th>
        <th width="15%" class="sortable" id="column_email" data-sort="" onclick="sort_table('#column_email','email')">Email </th>
        <th width="15%" class="sortable" id="column_role" data-sort="" onclick="sort_table('#column_role','r.nama')">Role </th>
        <th class="text-center" width="10%">Status </th>
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
            <td><?= $row->nama ?></td>
            <td><?= $row->username ?></td>
            <td><?= $row->email ?></td>
            <td><?= $row->nama_role ?></td>
            <td class="text-center">
              <?php 
              $status = $row->status;
              if($status=='1'){ ?>
                <span class="badge badge-pill badge-success">Aktif</span>
              <?php }else if($status=='2'){ ?>
                <span class="badge badge-pill badge-warning">Belum Diverifikasi</span>
              <?php }else if($status=='3'){ ?>
                <span class="badge badge-pill badge-danger">Diblokir</span>
              <?php } ?>
            </td>
            <td class="text-center">
              <a href="javascript:;" data-id="<?=$row->id?>" data-name="<?=$row->nama?>" class="btn btn-sm btn-warning btn-edit" data-toggle="tooltip" title="Edit Tipe Hafalan"><i style="color:#fff;" class="fa fa-edit"></i></a>
              <a href="javascript:;" data-id="<?=$row->id?>" data-name="<?=$row->nama?>" class="btn btn-sm btn-danger btn-delete" data-toggle="tooltip" title="Hapus Tipe Hafalan"><i class="fa fa-trash"></i></a>	    
            </td>
          </tr>
        <?php 
          }}else{
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
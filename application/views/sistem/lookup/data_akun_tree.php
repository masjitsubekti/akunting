<div class="table-responsive">
  <table class="table table-bordered">
    <thead class="tr-head">
      <tr>
        <th width="3%" class="text-center">No. </th>
        <th width="30%">Nama </th>
        <th width="10%" class="text-center">Kode </th>
        <th width="20%">Kelompok Akun </th>
        <th width="10%" class="text-center">Aksi </th>
      </tr>
      </thead>
      <tbody>
      <?php 
        if($list->num_rows()!=0){
        $no=0; 
        foreach ($list->result() as $row) { 
          $no++; 
          $path = explode(">", $row->path);
          $tree = (count($path)>1) ? count($path) * 15 : 10;
        ?>
          <tr style="cursor: pointer;">
            <td class="text-center"><?= $no ?>.</td>
            <td
              style="padding-left:<?= $tree ?>px;"
            ><?= $row->nama ?></td>
            <td class="text-center"><?= $row->kode ?></td>
            <td><?= $row->kelompok_akun ?></td>
            <td class="text-center">
              <?php if($row->have_child==0){ ?>
                <a class="btn btn-sm btn-success" href="javascript:;" onclick='selectRowAkun(<?php echo json_encode($row) ?>)'><i class="fa fa-check"></i></a>
              <?php } ?>
            </td>
          </tr>
        <?php 
          }
        }else{
        ?>
        <tr>
          <td colspan="5">Data tidak ditemukan!</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
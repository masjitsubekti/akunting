<?php
  // $path_logo = base_url('assets/images/logo---.png');
  // $type = pathinfo($path_logo, PATHINFO_EXTENSION);
  // $data = file_get_contents($path_logo);
  // $image_base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>

<!DOCTYPE html>
<html>

<head>
  <title><?=$title?></title>
  <style>
  .table {
    border-collapse: collapse;
    border-color: black;
    font-family: TimesNewRoman, Times New Roman, Times, Baskerville, Georgia, serif;
    width: 100%;
  }

  .head-table th {
    padding: 5px;
    border: 1px solid black;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
  }

  .body-table td,
  th {
    padding: 4px;
    border: 1px solid black;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
  }

  .head-lap td {
    padding: 1px;
    font-family: Arial, Helvetica, sans-serif;
  }

  .text-center {
    text-align: center;
  }

  .text-left {
    text-align: left;
  }

  .text-right {
    text-align: right;
  }

  .line-title {
    border: 0;
    border-style: inset;
    border-top: 2px solid #000;
  }

  .line-title-child {
    border: 0;
    margin-top: -7px;
    border-top: 1px solid #000;
  }

  .page_break {
    page-break-before: always;
  }
  </style>
</head>

<body>
  <div style="margin:-20px;">
    <table class="table" style="text-align:left;">
      <tbody class="head-lap">
        <tr>
          <td width="100%" class="text-center">
            <span style="font-size:15px">LAPORAN BUKU BESAR</span> <br>
            <span style="font-size:12px;">Tanggal : <?= format_date($tanggal_awal, 'd/m/Y') ?> s/d
              <?= format_date($tanggal_akhir, 'd/m/Y') ?></span> <br>
          </td>
        </tr>
      </tbody>
    </table>
    <hr class="line-title">
    <hr class="line-title-child">
    <?php 
        $total = 0;
        if(count($report)>0){
        foreach ($report as $row) { 
    ?>
    <table class="table" style="margin-top:30px;">
      <thead class="head-table">
        <tr>
          <th rowspan="2" width="9%" class="text-center">Tanggal</th>
          <th rowspan="2" width="10%" class="text-center">Nomor Jurnal</th>
          <th rowspan="2" width="40%">Keterangan</th>
          <th colspan="3" width="33%" class="text-center">Jumlah (Rp.)</th>
        </tr>
        <tr>
          <th width="11%">Debet</th>
          <th width="11%">Kredit</th>
          <th width="11%">Saldo</th>
        </tr>
      </thead>
      <tbody class="body-table">
        <tr>
          <td colspan="3" style="border-right: 1px solid #fff !important;"><?= $row->nama_akun ?></td>
          <td colspan="2" class="text-right">Saldo Awal</td>
          <td class="text-right"><?= format_number($row->saldo_awal) ?></td>
        </tr>
        <?php 
          $index2 = 0;
          foreach ($row->details as $d) {
          $style=($index2 != count($row->details)-1) ? "border-bottom: 1px solid #fff" : ""; 
        ?>
        <tr>
          <td style="<?= $style ?>"><?= format_date($d->tanggal, 'd/m/Y') ?></td>
          <td style="<?= $style ?>"><?= $d->nomor ?></td>
          <td style="<?= $style ?>"><?= $d->keterangan ?></td>
          <td style="<?= $style ?>" class="text-right"><?= format_number($d->debet) ?></td>
          <td style="<?= $style ?>" class="text-right"><?= format_number($d->kredit) ?></td>
          <td style="<?= $style ?>" class="text-right"><?= format_number($d->saldo) ?></td>
        </tr>
        <?php 
          $index2++;
        } ?>
        <tr>
          <td colspan="3" class="text-right"><b>TOTAL</b></td>
          <td class="text-right"><b><?= format_number($row->total_debet) ?></b></td>
          <td class="text-right"><b><?= format_number($row->total_kredit) ?></b></td>
          <td class="text-right"></td>
        </tr>
      </tbody>
    </table>
    <?php }}else{ ?>
    <!-- No Action -->
    <?php } ?>
  </div>
</body>

</html>
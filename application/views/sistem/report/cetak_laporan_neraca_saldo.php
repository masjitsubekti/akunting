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
  <div style="margin:-25px;">
    <table class="table" style="text-align:left;">
      <tbody class="head-lap">
        <tr>
          <td width="100%" class="text-center">
            <span style="font-size:15px">LAPORAN NERACA PERCOBAAN (SALDO)</span> <br>
            <span style="font-size:12px;">Tanggal : <?= format_date($tanggal_awal, 'd/m/Y') ?> s/d
              <?= format_date($tanggal_akhir, 'd/m/Y') ?></span> <br>
          </td>
        </tr>
      </tbody>
    </table>
    <hr class="line-title">
    <hr class="line-title-child">
    <table class="table" style="margin-top:30px;">
      <thead class="head-table">
        <tr>
          <th rowspan="2" width="8%" class="text-center">Kode</th>
          <th rowspan="2" width="30%" class="text-center">Nama Akun</th>
          <th colspan="2" width="20%">Saldo Awal</th>
          <th colspan="2" width="20%" class="text-center">Transaksi Periode Ini</th>
          <th colspan="2" width="20%" class="text-center">Saldo Akhir</th>
        </tr>
        <tr>
          <th width="10%">Debit</th>
          <th width="10%">Kredit</th>

          <th width="10%">Debit</th>
          <th width="10%">Kredit</th>

          <th width="10%">Debit</th>
          <th width="10%">Kredit</th>
        </tr>
      </thead>
      <tbody class="body-table">
      <?php 
        $total = 0;
        if(count($report)>0){
        foreach ($report as $row) { 
      ?>
        <tr>
          <td><?= $row->kode ?></td>
          <td><?= $row->nama ?></td>
          <td class="text-right"><?= format_number($row->saldo_awal_debit) ?></td>
          <td class="text-right"><?= format_number($row->saldo_awal_kredit) ?></td>
          <td class="text-right"><?= format_number($row->mutasi_debit) ?></td>
          <td class="text-right"><?= format_number($row->mutasi_kredit) ?></td>
          <td class="text-right"><?= format_number($row->saldo_akhir_debit) ?></td>
          <td class="text-right"><?= format_number($row->saldo_akhir_kredit) ?></td>
        </tr>
      <?php }}else{ ?>
        <!-- No Action -->
      <?php } ?>
        <tr>
          <td colspan="2" class="text-right"><b>TOTAL</b></td>
          <td class="text-right"><b><?= format_number($saw_debit) ?></b></td>
          <td class="text-right"><b><?= format_number($saw_kredit) ?></b></td>

          <td class="text-right"><b><?= format_number($mut_debit) ?></b></td>
          <td class="text-right"><b><?= format_number($mut_kredit) ?></b></td>
          
          <td class="text-right"><b><?= format_number($sak_debit) ?></b></td>
          <td class="text-right"><b><?= format_number($sak_kredit) ?></b></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
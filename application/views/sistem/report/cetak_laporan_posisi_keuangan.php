<!DOCTYPE html>
<html>

<head>
  <title><?=$title?></title>
  <style>
  .table {
    border-collapse: collapse;
    border-color: black;
    /* font-family: TimesNewRoman, Times New Roman, Times, Baskerville, Georgia, serif; */
    width: 100%;
  }

  .body-table td,
  th {
    padding: 4px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
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
            <span style="font-size:15px">LAPORAN POSISI KEUANGAN</span> <br>
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
    if(count($report)>0){ ?>
      <?php foreach ($report as $row) { ?>
      <div>
        <table class="table" style="margin-top:20px;">
          <tbody class="body-table">
            <tr>
              <td colspan="2" style="color:blue;"><b><?= $row->kelompok_neraca ?></b></td>
            </tr>
            <?php foreach ($row->kelompok_akun as $k) { ?>
            <tr>
              <td style="width:80%; padding-left:15px;"><b><?= $k->kelompok_akun ?></b></td>
              <td style="width:20%;"></td>
            </tr>
            <?php 
              $index2 = 0;
              foreach ($k->details as $d) {
            ?>
            <tr>
              <td style="padding-left:30px;"><?= $d->nama ?></td>
              <td class="text-right"><?= format_number($d->total) ?></td>
            </tr>
            <?php 
              $index2++;
            } ?>
            <tr>
              <td class="text-right"><b>Total <?= $k->kelompok_akun ?> : &nbsp;</b></td>
              <td style="text-align: right; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid #ffffff;">
                <?= format_number($k->total) ?>
              </td>
            </tr>
            <?php } ?>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td style="text-align: right; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid #ffffff; color:blue;"><b>Total <?= $d->kelompok_neraca ?> : &nbsp;</b></td>
              <td style="text-align: right; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid #ffffff; color:blue;">
                <?= format_number($row->total) ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    <?php }}else{ ?>
    <!-- No Action -->
    <?php } ?>
  </div>
</body>

</html>
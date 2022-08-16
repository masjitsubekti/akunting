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
  <!-- 
  Catatan : 
  idDet = False -> nominal disebelah kiri
  idDet = true -> nominal disebelah kanan
  idParent = null -> Header
  idParent = not null -> Sub 
  -->

  <div style="margin:-20px;">
    <table class="table" style="text-align:left;">
      <tbody class="head-lap">
        <tr>
          <td width="100%" class="text-center">
            <span style="font-size:15px">LAPORAN LABA RUGI</span> <br>
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
    <table class="table">
      <tbody class="body-table">
        <tr>
          <td style="width:50%;"></td>
          <td style="width:30%;"></td>
          <td style="width:20%;"></td>
        </tr>
        <?php 
          foreach ($report as $d) {
          $path = explode(">", $d->path);
          $tree = (count($path)>1) ? (count($path)) * 15 : 15;
          $boldheader = ($d->level==1) ? '<b>'. $d->nama .'</b>' : $d->nama;
          $pheader = ($d->id_parent=="") ? 'padding-top:15px;' : '';
        ?>
        <tr>
          <td style="padding-left:<?= $tree ?>px; <?= $pheader ?>">
            <?= $boldheader ?>
          </td>
          <td class="text-right" style="<?= $pheader ?>"><?= ($d->is_det==0 && $d->id_parent!="") ? '<b>'.format_number($d->total).'</b>' : '' ?></td>
          <td class="text-right" style="<?= $pheader ?>"><?= ($d->is_det==1) ? format_number($d->total) : '' ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr style="text-align: right; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid #ffffff;">
          <td class="text-right" colspan="2">
            <b>Total Laba Kotor : &nbsp;</b>
          </td>
          <td>
            <?= format_number($laba_kotor) ?>
          </td>
        </tr>
        <tr style="text-align: right; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid #ffffff;">
          <td class="text-right" colspan="2"><b>Total Laba Bersih Sebelum Pajak : &nbsp;</b></td>
          <td>
            <?= format_number($laba_bersih) ?>
          </td>
        </tr>
        <tr style="text-align: right; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid #ffffff;">
          <td class="text-right" colspan="2"><b>Total Beban Pajak (25% Laba Bersih) : &nbsp;</b></td>
          <td>
            <?= format_number($beban_pajak) ?>
          </td>
        </tr>
        <tr style="text-align: right; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid #ffffff;">
          <td class="text-right" colspan="2"><b>Total Laba Bersih Setelah Pajak : &nbsp;</b></td>
          <td>
            <?= format_number($laba_bersih_pajak) ?>
          </td>
        </tr>
      </tbody>
    </table>
    <?php }else{ ?>
    <!-- No Action -->
    <?php } ?>
  </div>
</body>

</html>
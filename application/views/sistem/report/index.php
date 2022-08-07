<style>
   .datepicker {z-index:1200 !important;}  
</style>    
<div class="row">
  <div class="col-12">
    <div class="card mt-4">
      <div class="card-header card-header-blue">
        <span class="card-title">Laporan</span>
      </div>
      <div class="card-body">
        <div class="row mb-1">
          <label for="nomor_transaksi" class="col-sm-2 col-form-label">Jenis Laporan</label>
          <div class="col-sm-6">
            <select name="jenis_laporan" id="jenis_laporan" onchange="changeReportType()" class="form-control">
              <option value="">- Pilih Jenis Laporan -</option>
              <option value="1">Laporan Buku Besar</option>
              <option value="2">Laporan Laba Rugi</option>
              <option value="3">Laporan Posisi Keuangan</option>
              <option value="4">Laporan Neraca Saldo</option>
            </select>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-8" style="padding-right:20px !important;">
            <h6 class="mb-3">Periode Laporan</h6>
            <div class="row mb-3">
              <div class="col-sm-3">
                <div class="form-check">
                  <input class="form-check-input check-mode" type="radio" name="periode" id="byTanggal"
                    value="by_tanggal">
                  <label class="form-check-label" for="byTanggal">
                    Pertanggal
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input class="form-control date-picker" id="tgl_awal" name="tgl_awal" data-date-format='dd-mm-yyyy'
                  autocomplete="off" onkeypress="return false;" value="<?= date('d-m-Y') ?>">
              </div>
              <div class="col-sm-1" style="text-align:center; padding:0px !important;">s/d</div>
              <div class="col-sm-4">
                <input class="form-control date-picker" id="tgl_akhir" name="tgl_akhir" data-date-format='dd-mm-yyyy'
                  autocomplete="off" onkeypress="return false;" value="<?= date('d-m-Y') ?>">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3">
                <div class="form-check">
                  <input class="form-check-input check-mode" type="radio" name="periode" id="byBulan" value="by_bulan">
                  <label class="form-check-label" for="byBulan">
                    Perbulan
                  </label>
                </div>
              </div>
              <div class="col-sm-5">
                <select class="form-control" id="bulan" name="bulan" required>
                  <option value="">Pilih Bulan</option>
                  <?php 
                $bulan = date('m');
                $array_bulan=array(
                    '01'=>'Januari',
                    '02'=>'Februari',
                    '03'=>'Maret',
                    '04'=>'April',
                    '05'=>'Mei',
                    '06'=>'Juni',
                    '07'=>'Juli',
                    '08'=>'Agustus',
                    '09'=>'September',
                    '10'=>'Oktober',
                    '11'=>'November',
                    '12'=>'Desember'
                );
                foreach ($array_bulan as $key => $value) { ?>
                  <option <?php if($bulan==$key){
                        echo " selected";
                    } ?> value="<?= $key ?>"><?= $value ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-sm-4">
                <input type="number" class="form-control" name="tahun" id="tahun" value="<?= date('Y') ?>">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3">
                <div class="form-check">
                  <input class="form-check-input check-mode" type="radio" name="periode" id="byTahun" value="by_tahun">
                  <label class="form-check-label" for="byTahun">
                    Pertahun
                  </label>
                </div>
              </div>
              <div class="col-sm-5">
                <input type="number" class="form-control" name="tahunan" id="tahunan" value="<?= date('Y') ?>">
              </div>
            </div>
          </div>
          <div class="col-md-4" style="border-left:1px solid #dedede;">
            <div style="padding-left:10px !important;">
              <h6 class="mb-3">Opsi</h6>
              <div class="form-group mb-2" id="select-akun" style="display: none;">
                <label for="akun" class="form-label">Per Nomor Akun</label>
                <select class="form-control" name="akun" id="akun" required>
                  <option value="">Pilih Akun</option>
                </select>
              </div>

              <!-- Sembunyikan nilai nol -->
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                  Sembunyikan detail yang bernilai 0 (Nol)
                </label>
              </div>
            </div>
          </div>
        </div>
        <hr class="mt-4">
        <div>
          <a href="javascript:;" onclick="printReport()" class="btn btn-success"><i class="fa fa-print"></i>&nbsp; Cetak
            PDF</a>
          <a href="javascript:;" onclick="reset()" class="btn btn-warning"><i class="fa fa-undo"></i>&nbsp; Reset</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="div_modal"></div>
<script>
$('.date-picker').datepicker({
  autoclose: true,
})
$('.date-picker').datepicker('setDate', new Date());

function changeReportType() {
  const jenis_lap = $('#jenis_laporan').val();
  if (jenis_lap == '1') {
    $('#select-akun').show()
  } else {
    $('#select-akun').hide();
  }
}

function printReport() {
  var periode = $('.check-mode:checked').val();
  var tahun = $('#tahun').val();
  const bulan = $('#bulan').val();
  const tahunan = $('#tahunan').val();
  const jenis_lap = $('#jenis_laporan').val();
  const barang = $('#barang').val();
  var link = ""

  if (jenis_lap == "") {
    Swal.fire({
      icon: 'warning',
      title: 'Maaf',
      text: 'Harap pilih jenis laporan !'
    });
    return
  }

  if (periode === undefined) {
    Swal.fire({
      icon: 'warning',
      title: 'Maaf',
      text: 'Harap pilih periode laporan !'
    });
    return
  }

  tahun = (periode == 'by_tahun') ? tahunan : tahun;
  var rentangTanggal = getDateReport(periode, bulan, tahun);
  // Report
  if (jenis_lap == '1') {
    link = "<?= site_url('Report/buku_besar') ?>" + "?tanggal_awal=" + rentangTanggal.tglAwal + "&tanggal_akhir=" +
      rentangTanggal.tglAkhir;
  } else if (jenis_lap == '2') {
    link = "<?= site_url('Report/laba_rugi') ?>" + "?tanggal_awal=" + rentangTanggal.tglAwal + "&tanggal_akhir=" +
      rentangTanggal.tglAkhir;
  } else if (jenis_lap == '3') {
    link = "<?= site_url('Report/posisi_keuangan') ?>" + "?tanggal_awal=" + rentangTanggal.tglAwal +
      "&tanggal_akhir=" + rentangTanggal.tglAkhir;
  } else if (jenis_lap == '4') {
    link = "<?= site_url('Report/neraca_saldo') ?>" + "?tanggal_awal=" + rentangTanggal.tglAwal +
      "&tanggal_akhir=" + rentangTanggal.tglAkhir;
  } else {
    link = "";
  }
  window.open(link, '_blank', 'width=1024, height=768')
}

function reset() {
  $('.date-picker').datepicker('setDate', new Date());
  $('#barang').val("");
}

function formatDate(date) {
  let s = date.split("-");
  return s[2] + '-' + s[1] + '-' + s[0]
}

function getDateReport(periode, bulan, tahun) {
  var tgl_awal = $('#tgl_awal').val();
  var tgl_akhir = $('#tgl_akhir').val();

  if (periode == undefined) {
    return {
      success: false,
      tglAwal: '',
      tglAkhir: '',
    }
  } else {
    var parseDate = ''
    var firstDate = ''
    var lastDate = ''

    if (periode == 'by_tanggal') {
      firstDate = formatDate(tgl_awal)
      lastDate = formatDate(tgl_akhir)
    } else if (periode == 'by_tahun') {
      firstDate = tahun + '-01-01'
      lastDate = new Date(tahun, 12, 0).getDate();
      lastDate = tahun + '-12-' + lastDate
    } else if (periode == 'by_bulan') {
      firstDate = tahun + '-' + bulan + '-01'
      lastDate = new Date(tahun, bulan, 0).getDate();
      lastDate = tahun + '-' + bulan + '-' + lastDate
    } else {
      firstDate = ''
      lastDate = ''
    }

    return {
      success: true,
      tglAwal: firstDate,
      tglAkhir: lastDate,
    }
  }
}
</script>
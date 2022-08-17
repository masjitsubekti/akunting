<div class="row">
  <div class="col-md-12">
    <div class="card mt-4 mb-4">
      <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Form Barang
      </div>
      <div class="card-body">
        <form id="formdata" action="" method="POST">
          <input type="hidden" name="modeform" id="modeform">
          <input type="hidden" class="form-control" id="id" name="id"
            value="<?= isset($data) ? $data['id'] : '' ?>"></input>
          <div class="form-group mb-2">
            <label for="nama" class="form-label">Nama*</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama"
              value="<?= isset($data) ? $data['nama'] : '' ?>" required>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-2" id="select-jenis">
                <label for="jenis_barang" class="form-label">Jenis Barang*</label>
                <select class="form-control" name="jenis_barang" id="jenis_barang" required>
                  <option value="">Pilih Jenis Barang</option>
                  <?php foreach ($jenis_barang as $j){ ?>
                  <option <?php 
                    if(isset($data)){
                      if($data['id_jenis'] == $j->id){
                          echo 'selected';
                      }
                    }
                ?> value="<?= $j->id ?>"><?= $j->nama; ?>
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-2" id="select-satuan">
                <label for="satuan" class="form-label">Satuan*</label>
                <select class="form-control" name="satuan" id="satuan" required>
                  <option value="">Pilih Satuan</option>
                  <?php foreach ($satuan as $s){ ?>
                  <option <?php 
                    if(isset($data)){
                      if($data['id_satuan'] == $s->id){
                          echo 'selected';
                      }
                    }
                ?> value="<?= $s->id ?>"><?= $s->nama; ?>
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label for="harga_jual" class="form-label">Harga Jual*</label>
                <input type="text" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Jual"
                  value="<?= isset($data) ? floatval($data['harga_jual']) : '' ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label for="harga_beli" class="form-label">Harga Beli*</label>
                <input type="text" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli"
                  value="<?= isset($data) ? floatval($data['harga_beli']) : '' ?>" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-2" id="select-persediaan">
                <label for="akun_persediaan" class="form-label">Akun Persediaan</label>
                <select class="form-control" name="akun_persediaan" id="akun_persediaan">
                  <option value="">Pilih Akun Persediaan</option>
                  <?php foreach ($akun_persediaan as $ap){ ?>
                  <option <?php 
                    if(isset($data)){
                      if($data['id_akun_persediaan'] == $ap->id){
                          echo 'selected';
                      }
                    }
                ?> value="<?= $ap->id ?>"><?= $ap->kode; ?> - <?= $ap->nama; ?>
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" placeholder="Stok"
                  value="<?= isset($data) ? $data['stok'] : '' ?>" required>
              </div>
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan (Opsional)"
              rows="2"><?= isset($data) ? $data['keterangan'] : '' ?></textarea>
          </div>

          <hr>
          <div class="float-end">
            <a class="btn btn-secondary" href="javascript:history.go(-1);"> Batal</a>
            <button class="btn btn-primary" type="submit"> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$("#jenis_barang").select2({
  placeholder: "Pilih Kelompok Akun",
  allowClear: true,
  dropdownParent: $("#select-jenis")
});

$("#satuan").select2({
  placeholder: "Pilih Satuan",
  allowClear: true,
  dropdownParent: $("#select-satuan")
});

$("#akun_persediaan").select2({
  placeholder: "Pilih Akun Persediaan",
  allowClear: true,
  dropdownParent: $("#select-persediaan")
});

$(document).on('submit', '#formdata', function(event) {
  event.preventDefault();
  var modeform = $('#modeform').val();
  var page = (modeform == 'UPDATE') ? $('#hidden_page').val() : 1;
  $.ajax({
    url: site_url + "/Barang/save",
    method: 'POST',
    dataType: 'json',
    data: new FormData($('#formdata')[0]),
    async: true,
    processData: false,
    contentType: false,
    success: function(data) {
      if (data.success == true) {
        Toast.fire({
          icon: 'success',
          title: data.message
        });

        swal.hideLoading()
        setTimeout(function() {
          window.location.href = "<?= site_url('Barang') ?>";
        }, 1000);
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: data.message
        });
      }
    },
    fail: function(event) {
      alert(event);
    }
  });
});
</script>
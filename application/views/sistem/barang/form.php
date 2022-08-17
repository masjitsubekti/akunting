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
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-2">
                  <label for="kode" class="form-label">Kode*</label>
                  <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode"
                    value="<?= isset($data) ? $data['kode'] : '' ?>" required>
                </div>

              </div>
            </div>
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
                <label for="harga_jual" class="form-label">Harga Jual</label>
                <input type="text" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Jual"
                  value="<?= isset($data) ? $data['harga_jual'] : '' ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label for="harga_beli" class="form-label">Harga Beli</label>
                <input type="text" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli"
                  value="<?= isset($data) ? $data['harga_beli'] : '' ?>" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label for="akun_persediaan" class="form-label">Akun Persediaan</label>
                <input type="text" class="form-control" id="akun_persediaan" name="akun_persediaan" placeholder="Akun Persediaan"
                  value="<?= isset($data) ? $data['id_akun_persediaan'] : '' ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label for="stok" class="form-label">Stok</label>
                <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok"
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
            <a class="btn btn-secondary" href="<?= site_url('Akun') ?>"> Batal</a>
            <button class="btn btn-primary" type="submit"> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$("#kelompok_akun").select2({
  placeholder: "Pilih Kelompok Akun",
  allowClear: true,
  dropdownParent: $("#select-kelompok")
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
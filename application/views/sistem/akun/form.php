<div class="row">
  <div class="col-md-12">
    <div class="card mt-4">
      <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Form Akun
      </div>
      <div class="card-body">
        <form id="formData" action="" method="POST">
          <input type="hidden" name="modeform" id="modeform">
          <input type="hidden" class="form-control" id="id" name="id"
            value="<?= isset($data) ? $data['id'] : '' ?>"></input>
          <div class="form-group mb-2">
            <label for="kode" class="form-label">Kode*</label>
            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode"
              value="<?= isset($data) ? $data['kode'] : '' ?>" required>
          </div>
          <div class="form-group mb-2">
            <label for="nama" class="form-label">Nama*</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama"
              value="<?= isset($data) ? $data['nama'] : '' ?>" required>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label for="parent_akun" class="form-label">Sub dari akun</label>
                <div class="input-group">
                  <input type="hidden" id="id_parent" name="id_parent" class="form-control" value="<?= isset($data) ? $data['id_parent'] : '' ?>">
                  <input type="text" id="parent_akun" name="parent_akun" class="form-control" placeholder="Akun"
                    readonly value="<?= isset($data) ? $data['nama_parent_akun'] : '' ?>">
                  <span id="clear_akun" class="input-group-text" style="cursor:pointer; display:none;"
                    onclick="clearAkun()">
                    <i class="fas fa-times"></i>
                  </span>
                  <span class="input-group-text" style="cursor:pointer;" onclick="lookupAkun()">
                    <i class="fas fa-search"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-2" id="select-kelompok">
                <label for="kelompok_akun" class="form-label">Kelompok Akun*</label>
                <select class="form-control" name="kelompok_akun" id="kelompok_akun" required>
                  <option value="">Pilih Kelompok</option>
                  <?php foreach ($kelompok_akun as $ka){ ?>
                  <option <?php 
                    if(isset($data)){
                      if($data['id_kelompok'] == $ka->id){
                          echo 'selected';
                      }
                    }
                ?> value="<?= $ka->id ?>"><?= $ka->nama; ?>
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan (Opsional)"
              rows="2"><?= isset($data) ? $data['keterangan'] : '' ?></textarea>
          </div>
          <br>
          <div class="form-check">
            <input class="form-check-input" name="aktif" type="checkbox" value="1" id="flexCheckDefault" checked>
            <label class="form-check-label" for="flexCheckDefault">
              Aktif
            </label>
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
<div id="div_modal_lookup_akun"></div>
<script>
$("#kelompok_akun").select2({
  placeholder: "Pilih Kelompok Akun",
  allowClear: true,
  dropdownParent: $("#select-kelompok")
});

function lookupAkun() {
  $.ajax({
    url: "<?= site_url('Akun/lookup_akun/')?>",
    type: 'post',
    data:{
      select_all : true
    },
    dataType: 'html',
    beforeSend: function() {},
    success: function(result) {
      $('#div_modal_lookup_akun').html(result);
      $('#modal_lookup_akun').modal('show');
    }
  });
};

function selectRowAkun(payload) {
  console.log("row akun selected", payload)
  $('#id_parent').val(payload.id)
  $('#parent_akun').val(payload.kode + ' - ' + payload.nama)
  $('#modal_lookup_akun').modal('hide');
  $('#clear_akun').show();
}

function clearAkun() {
  $('#id_parent').val('')
  $('#parent_akun').val('')
  $('#clear_akun').hide();
}

$(document).on('submit', '#formData', function(event) {
  event.preventDefault();
  var modeform = $('#modeform').val();
  var page = (modeform == 'UPDATE') ? $('#hidden_page').val() : 1;
  $.ajax({
    url: site_url + "/Akun/save",
    method: 'POST',
    dataType: 'json',
    data: new FormData($('#formData')[0]),
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
          window.location.href = "<?= site_url('Akun') ?>";
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
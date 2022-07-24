<div class="modal fade"  id="formModal"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleAdd" style="display:none;">Tambah Akun</h5>
        <h5 class="modal-title" id="modalTitleEdit" style="display:none;">Edit Akun</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formData" action="" method="POST">
        <div class="modal-body">
          <input type="hidden" name="modeform" id="modeform">
          <input type="hidden" class="form-control" id="id" name="id" value="<?= isset($data) ? $data['id'] : '' ?>"></input>
          <div class="form-group mb-2">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode" value="<?= isset($data) ? $data['kode'] : '' ?>" required>
          </div>
          <div class="form-group mb-2">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= isset($data) ? $data['nama'] : '' ?>" required>
          </div>
          <div class="form-group mb-2" id="select-kelompok">
            <label for="kelompok_akun" class="form-label">Kelompok Akun</label>
            <select class="form-control" name="kelompok_akun" id="kelompok_akun" required>
              <option value="">Pilih Kelompok</option>
              <?php foreach ($kelompok_akun as $ka){ ?>
              <option <?php 
                    if(isset($data)){
                      if($data['id_kelompok_akun'] == $ka->id){
                          echo 'selected';
                      }
                    }
                ?> value="<?= $ka->id ?>"><?= $ka->nama; ?>
              </option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group mb-2" id="select-kelompok">
            <label for="parent_akun" class="form-label">Sub dari akun</label>
            <select class="form-control" name="parent_akun" id="parent_akun" required>
              <option value="">Pilih Akun</option>
              <?php foreach ($kelompok_akun as $ka){ ?>
              <option <?php 
                    if(isset($data)){
                      if($data['id_kelompok_akun'] == $ka->id){
                          echo 'selected';
                      }
                    }
                ?> value="<?= $ka->id ?>"><?= $ka->nama; ?>
              </option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group mb-2">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" rows="2"><?= isset($data) ? $data['keterangan'] : '' ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $("#kelompok_akun").select2({
    placeholder: "Pilih Kelompok Akun",
    allowClear: true,
    dropdownParent: $("#select-kelompok")
  });
</script>
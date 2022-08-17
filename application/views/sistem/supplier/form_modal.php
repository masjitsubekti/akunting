<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Tambah Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formdata" action="" method="POST">
        <div class="modal-body">
          <input type="hidden" name="modeform" id="modeform">
          <input type="hidden" class="form-control" id="id" name="id" value="<?= isset($data) ? $data['id'] : '' ?>"></input>
          <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode" value="<?= isset($data) ? $data['kode'] : $kode ?>" readonly>
          </div>
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Supplier" value="<?= isset($data) ? $data['nama'] : '' ?>" required>
          </div>
          <div class="mb-3">
            <label for="no_telp" class="form-label">No Telepon</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="No Telepon" value="<?= isset($data) ? $data['no_telp'] : '' ?>" required>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Alamat" required><?= isset($data) ? $data['alamat'] : '' ?></textarea>
          </div>
          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" rows="2" placeholder="Keterangan"><?= isset($data) ? $data['keterangan'] : '' ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
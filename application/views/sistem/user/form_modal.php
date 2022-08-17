<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Tambah User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formdata" action="" method="POST">
        <div class="modal-body">
          <input type="hidden" name="modeform" id="modeform">
          <input type="hidden" class="form-control" id="id" name="id"
            value="<?= isset($data_user) ? $data_user['id'] : '' ?>"></input>
          <div class="mb-3">
            <label for="nama_user" class="form-label">Nama User</label>
            <input class="form-control" id="nama_user" name="nama_user" type="text" placeholder="Nama user . . ."
              autocomplete="off" value="<?php 
										if(isset($data_user)){
											echo $data_user['nama'];
										} 
									?>" required>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input class="form-control" id="username" name="username" type="text" placeholder="Username . . ."
              autocomplete="off" value="<?php 
										if(isset($data_user)){
											echo $data_user['username'];
										} 
									?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input class="form-control" id="email" name="email" type="text" placeholder="Email . . ." autocomplete="off"
              value="<?php 
										if(isset($data_user)){
											echo $data_user['email'];
										} 
									?>" required>
          </div>
          <div class="mb-3">
            <label for="hak_akses" class="form-label">Pilih Hak Akses</label>
            <select class="form-control" id="hak_akses" name="hak_akses" required>
              <option value="">- Pilih Hak Akses -</option>
              <?php foreach ($list_role as $roles){ ?>
              <option <?php 
										if(isset($data_user)){
                      if($data_user['id_role'] == $roles->id){
                          echo 'selected';
                      }
										}
                ?> value="<?= $roles->id ?>">
                <?= $roles->nama; ?>
              </option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input class="form-control" id="password" name="password" type="password" placeholder="Password . . ."
              autocomplete="off" value="" <?= (isset($data_user)) ? '' : 'required'; ?>>
          </div>
          <div class="mb-3">
            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
            <input class="form-control" id="confirm_password" name="confirm_password" type="password"
              placeholder="Konfirmasi Password . . ." autocomplete="off" value="" onkeyup="validate_password()"
              <?= (isset($data_user)) ? '' : 'required'; ?>>
            <span id="pass-message"></span>
          </div>
          <?php if($mode=='UPDATE'){ ?>
          <small>*Kosongkan password jika tidak ingin merubah password</small>
          <?php } ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
function validate_password() {
  var pass = $('#password').val();
  var confirm_pass = $('#confirm_password').val();
  if (pass != confirm_pass) {
    $('#pass-message').show();
    $('#pass-message').text('Password tidak cocok !');
    $('#pass-message').css('color', 'red');
    $('#btn-simpan').prop('disabled', true);
  } else {
    $('#pass-message').hide();
    $('#pass-message').text('');
    $('#pass-message').css('color', 'white');
    $('#btn-simpan').prop('disabled', false);
  }
}
</script>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login | Akunting</title>
  <!-- plugins:css -->
  <link rel="shortcut icon" href="<?= base_url('assets/images/logo--.png') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/all/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/styles.css')?>" />

  <style>
  .content-wrapper {
    background: #F5F7FF;
    padding: 1.5rem 1.5rem;
    width: 100%;
    -webkit-flex-grow: 1;
    flex-grow: 1;
  }
  </style>
</head>

<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <br>
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-3">Login</h3>
                </div>
                <div class="card-body" style="padding:20px !important;">
                  <p class="font-weight-light mb-0" style="font-size:12pt;">Gunakan username / email dan password Anda
                    untuk masuk ke dalam sistem!</p>
                  <br>
                  <form id="form-login" method="post">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="username" name="username" type="text" placeholder="Username" />
                      <label for="username">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="password" name="password" type="password"
                        placeholder="Password" />
                      <label for="password">Password</label>
                    </div>
                    <br>
                    <div class="d-flex align-items-center justify-content-between mb-0">
                      <a class="small" href="password.php">Lupa Password?</a>
                      <button type="submit" class="btn btn-success">&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;</button>
                    </div>
                  </form>
                  <br>
                </div>
              </div>
              <div class="text-center mt-3">
                <span class="text-sm-left d-block d-sm-inline-block" style="font-size:13px; color:#fff;">Copyright © 2022 Akunting</span>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <!-- plugins:js -->
  <script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
  <script src="<?= base_url('assets/all/sweetalert2/sweetalert2.all.min.js') ?>"></script>
  <script>
  var site_url = '<?= site_url() ?>';
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  $('#form-login').submit(function(event) {
    event.preventDefault();
    $.ajax({
      url: site_url + '/Auth/login',
      method: 'POST',
      dataType: 'json',
      data: new FormData($('#form-login')[0]),
      async: true,
      processData: false,
      contentType: false,
      success: function(data) {
        if (data.success == true) {
          Toast.fire({
            icon: 'success',
            title: data.message
          });

          setTimeout(function() {
            window.location.href = site_url + data.page;
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
        console.log(event);
      }
    });
    event.preventDefault();
  });
  </script>
</body>

</html>
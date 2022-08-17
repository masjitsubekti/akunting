<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
  <!-- Navbar Brand-->
  <a class="navbar-brand ps-3" href="index.php">Akunting</a>
  <!-- Sidebar Toggle-->
  <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
    <i class="fas fa-bars"></i>
  </button>
  <!-- Navbar Search-->
  <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
  <!-- Navbar-->
  <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
        aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="javascript:;">Profil</a></li>
        <li><hr class="dropdown-divider" /></li>
        <li><a class="dropdown-item" onclick="logout()" href="javascript:;">Logout</a></li>
      </ul>
    </li>
  </ul>
</nav>
<script>
  function logout() {
    Swal.fire({
        title: 'Keluar dari sistem ?',
        text: "Apakah Anda yakin keluar dari sistem !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Logout',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    method: 'POST',
                    dataType: 'json',
                    url: '<?= site_url() ?>' + '/Auth/logout',
                    success: function (data) {
                        if (data.success == true) {
                            Swal.fire('Berhasil',data.message,'success');
                            swal.hideLoading()
                            setTimeout(function(){ 
                              window.location.href = '<?= site_url() ?>/' + data.page;
                            }, 1000);
                        } else {
                            Swal.fire({icon: 'error',title: 'Oops...',text: data.message});
                        }
                    },
                    fail: function (e) {
                        alert(e);
                    }
                });
            });
        },
        allowOutsideClick: false
    });
  }
</script>
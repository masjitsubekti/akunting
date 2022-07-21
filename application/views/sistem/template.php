<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="" />
  <title><?= $title ?></title>
  <!-- plugins:css -->
  <?php include('layouts/theme_css.php') ?>
</head>
<body>  
  <!-- partial:header -->
  <?php include('layouts/theme_header.php') ?>
  <!-- partial:sidebar -->
  <div id="layoutSidenav">      
    <?php include('layouts/theme_sidebar.php') ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
        <!-- Content -->
        <?php include($content) ?>
        </div>
        <!-- partial:footer -->
      </main>
      <?php include('layouts/theme_footer.php') ?>  
    </div>
  </div>

  <!-- plugins:js -->
  <?php include('layouts/theme_js.php') ?>
  <script>
    var base_url = "<?= base_url() ?>";
    var site_url = "<?= site_url() ?>";
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
  </script>
</body>
</html>




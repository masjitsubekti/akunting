<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
      <div class="nav">
        <div class="sb-sidenav-menu-heading">Menu</div>
        <a class="nav-link" href="<?= site_url('Home') ?>">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
          Dashboard
        </a>
        <!-- Master Data -->
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMaster"
          aria-expanded="false" aria-controls="collapseMaster">
          <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
          Akuntansi
          <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseMaster" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
          <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="<?= site_url('Akun') ?>">Chart Of Account</a>
            <a class="nav-link" href="<?= site_url('Jurnal') ?>">Jurnal Umum</a>
          </nav>
        </div>
        <!-- Transaksi -->
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTransaksi"
          aria-expanded="false" aria-controls="collapseTransaksi">
          <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
          Transaksi
          <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseTransaksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
          <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="javascript:;">Penjualan</a>
            <a class="nav-link" href="javascript:;">Pembelian</a>
          </nav>
        </div>
        <!-- Laporan -->
        <!-- <a class="nav-link" href="<?= site_url('Report') ?>">
          <div class="sb-nav-link-icon"><i class="fas fa-copy"></i></div>
          Laporan
        </a> -->

        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLaporan"
          aria-expanded="false" aria-controls="collapseLaporan">
          <div class="sb-nav-link-icon"><i class="fas fa-copy"></i></div>
          Laporan
          <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
          <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="<?= site_url('Report') ?>">Keuangan</a>
          </nav>
        </div>
        <!-- Pengaturan -->
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePengaturan"
          aria-expanded="false" aria-controls="collapsePengaturan">
          <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
          Pengaturan
          <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapsePengaturan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
          <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="javascript:;">User</a>
          </nav>
        </div>
  </nav>
</div>
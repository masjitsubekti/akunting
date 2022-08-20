<div class="row">
  <div class="col-md-12">
    <div class="card mt-4">
      <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Data Pembelian
        <div class="float-end">
          <a href="<?= site_url('Pembelian/create') ?>" class="btn btn-success mr-1 mb-1" id="btn-create"><i
          class="fa fa-plus-circle"></i> &nbsp;Tambah</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-1">
            <select class="form-control" name="limit" id="limit" onchange="pageLoad(1)">
              <option value="10" selected>10 Baris</option>
              <option value="25">25 Baris</option>
              <option value="50">50 Baris</option>
              <option value="100">100 Baris</option>
            </select>
          </div>
          <div class="col-md-2">
            <div class="input-group">
              <input class="form-control date-picker" id="startdate" name="startdate" data-date-format='dd-mm-yyyy'
              autocomplete="off" onchange="pageLoad(1)" onkeypress="return false;" value="<?= date('d-m-Y') ?>">
              <span class="input-group-text">
                <i class="fas fa-calendar"></i>
              </span>
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group">
              <input class="form-control date-picker" id="enddate" name="enddate" data-date-format='dd-mm-yyyy'
              autocomplete="off" onchange="pageLoad(1)" onkeypress="return false;" value="<?= date('d-m-Y') ?>">
              <span class="input-group-text">
                <i class="fas fa-calendar"></i>
              </span>
            </div>
          </div>
          <div class="col-md-3"></div>
          <div class="col-md-4">
            <div class="input-group">
              <input type="text" id="search" name="search" class="form-control" placeholder="Cari <Tekan Enter>">
              <span class="input-group-text" onclick="pageLoad(1)">
                <i class="fas fa-search"></i>
              </span>
            </div>
          </div>
        </div>
        <br>
        <div id="list"></div>
      </div>
    </div>
  </div>
</div>

<!-- DATA SORT -->
<input type="hidden" name="hidden_id_th" id="hidden_id_th" value="#column_created">
<input type="hidden" name="hidden_page" id="hidden_page" value="1">
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="created_at">
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc">
<div id="div_modal"></div>
<script>
  $('.date-picker').datepicker({
    autoclose: true,
  }) 
</script>
<script src="<?= base_url('assets/js/pages/pembelian.js') ?>"></script>

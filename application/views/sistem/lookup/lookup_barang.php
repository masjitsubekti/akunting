<style>
.modal-full {
  min-width: 80% !important;
}
</style>
<div class="modal fade" id="modal_lookup_barang" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bx bx-layer"></i> Lookup Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-md-2">
                <select class="form-control" name="lookup_barang_limit" id="lookup_barang_limit" onchange="pageLoadBarang()">
                  <option value="10" selected>10 Baris</option>
                  <option value="25">25 Baris</option>
                  <option value="50">50 Baris</option>
                  <option value="100">100 Baris</option>
                </select>
              </div>
              <div class="col-md-6"></div>
              <div class="col-md-4">
                <div class="input-group">
                  <input type="text" id="lookup_barang_cari" name="lookup_barang_cari" class="form-control"
                    placeholder="Cari . . .">
                  <span class="input-group-text">
                    <i class="fa fa-search"></i>
                  </span>
                </div>
              </div>
            </div>
            <br>
            <div id="list_lookup_barang"></div>
          </div>
        </div>
        <!-- DATA SORT -->
        <input type="hidden" name="lookup_barang_id_th" id="lookup_barang_id_th" value="#column_nama">
        <input type="hidden" name="lookup_barang_column" id="lookup_barang_column" value="nama">
        <input type="hidden" name="lookup_barang_sort" id="lookup_barang_sort" value="asc">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  pageLoadBarang(1)
});

$('#lookup_barang_cari').on('keypress', function(e) {
  if (e.which == 13) {
    pageLoadBarang(1);
  }
});

function pageLoadBarang(page=1) {
  var id_th = $('#lookup_barang_id_th').val();
  var column = $('#lookup_barang_column').val();
  var sort = $('#lookup_barang_sort').val();
  var limit = $('#lookup_barang_limit').val();
  var cari = $('#lookup_barang_cari').val();
  $.ajax({
    url: "<?= site_url('Barang/fetch_data_lookup')?>",
    type: 'GET',
    dataType: 'html',
    data: {
      page : page,
      sortby : column,
      sorttype : sort,
      limit : limit,
      q : cari,
      function_name: 'pageLoadBarang',
    },
    beforeSend: function() {},
    success: function(result) {
      $('#list_lookup_barang').html(result);
      sort_finish(id_th, sort);
    }
  });
}

function sort_table(id, column) {
  var sort = $(id).attr("data-sort");
  $('#lookup_barang_id_th').val(id);
  $('#lookup_barang_column').val(column);

  if (sort == "asc") {
    sort = 'desc';
  } else if (sort == "desc") {
    sort = 'asc';
  } else {
    sort = 'asc';
  }
  $('#lookup_barang_sort').val(sort);
  pageLoadBarang(1);
}
</script>
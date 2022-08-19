<style>
.modal-full {
  min-width: 80% !important;
}
</style>
<div class="modal fade" id="modal_lookup_akun" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bx bx-layer"></i> Lookup Akun</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="select_all" value="<?= $select_all ?>">
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-md-2">
                <!-- <select class="form-control" name="lookup_akun_limit" id="lookup_akun_limit" onchange="pageLoadAkun()">
                  <option value="10" selected>10 Baris</option>
                  <option value="25">25 Baris</option>
                  <option value="50">50 Baris</option>
                  <option value="100">100 Baris</option>
                </select> -->
              </div>
              <div class="col-md-6"></div>
              <div class="col-md-4">
                <div class="input-group">
                  <input type="text" id="lookup_akun_cari" name="lookup_akun_cari" class="form-control"
                    placeholder="Cari . . .">
                  <span class="input-group-text">
                    <i class="fa fa-search"></i>
                  </span>
                </div>
              </div>
            </div>
            <br>
            <div id="list_lookup_akun"></div>
          </div>
        </div>
        <!-- DATA SORT -->
        <!-- <input type="hidden" name="lookup_akun_id_th" id="lookup_akun_id_th" value="#column_nama">
        <input type="hidden" name="lookup_akun_column" id="lookup_akun_column" value="nama">
        <input type="hidden" name="lookup_akun_sort" id="lookup_akun_sort" value="asc"> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  pageLoadAkun()
});

$('#lookup_akun_cari').on('keypress', function(e) {
  if (e.which == 13) {
    pageLoadAkun();
  }
});

function pageLoadAkun() {
  var search = $('#lookup_akun_cari').val();
  var select = $('#select_all').val();
  $.ajax({
    url: "<?= site_url('Akun/get_akun_tree')?>",
    type: 'GET',
    dataType: 'html',
    data: {
      q : search,
      select_all : select
    },
    beforeSend: function() {},
    success: function(result) {
      $('#list_lookup_akun').html(result);
    }
  });
}

// function pageLoadAkun(page=1) {
//   var id_th = $('#lookup_akun_id_th').val();
//   var column = $('#lookup_akun_column').val();
//   var sort = $('#lookup_akun_sort').val();
//   var limit = $('#lookup_akun_limit').val();
//   var cari = $('#lookup_akun_cari').val();
//   $.ajax({
//     url: "<?= site_url('Akun/get_data_lookup')?>",
//     type: 'GET',
//     dataType: 'html',
//     data: {
//       page : page,
//       sortby : column,
//       sorttype : sort,
//       limit : limit,
//       search : cari,
//       function_name: 'pageLoadAkun'
//     },
//     beforeSend: function() {},
//     success: function(result) {
//       $('#list_lookup_akun').html(result);
//       $('#hidden_page').val(page);
//       sort_finish(id_th, sort);
//     }
//   });
// }

// function sort_table(id, column) {
//   var sort = $(id).attr("data-sort");
//   $('#lookup_akun_id_th').val(id);
//   $('#lookup_akun_column').val(column);

//   if (sort == "asc") {
//     sort = 'desc';
//   } else if (sort == "desc") {
//     sort = 'asc';
//   } else {
//     sort = 'asc';
//   }
//   $('#lookup_akun_sort').val(sort);
//   pageLoadAkun(1);
// }
</script>
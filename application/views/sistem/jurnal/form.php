<style>
  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>
<div class="row">
  <div class="col-12">
    <div class="card mt-4">
      <div class="card-header">
        <span class="card-title">Form Jurnal Umum</span>
      </div>
      <div class="card-body">
        <form id="formData">
          <input type="hidden" name="id" id="id" value="<?php (isset($data)) ?  $data['id'] : '' ?>">
          <input type="hidden" name="modeform" id="modeform" value="<?= $modeform ?>">
          <div class="row mb-1">
            <label for="nomor_transaksi" class="col-sm-2 col-form-label">No Transaksi</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control" name="nomor_transaksi" id="nomor_transaksi"
                value="<?php (isset($data)) ?  $data['nomor_transaksi'] : '' ?>" readonly>
            </div>
          </div>
          <div class="row mb-1">
            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-4">
              <input class="form-control date-picker" id="tanggal" name="tanggal"
                data-date-format='dd-mm-yyyy' autocomplete="off" onkeypress="return false;" value="<?php
                      if(isset($data)){
                        $time = strtotime($data['tanggal']);
                        $tgl = date('d-m-Y', $time);
                        echo $tgl;
                      }else {
                        echo date('d-m-Y'); 
                      }?>" required>
            </div>
          </div>
          <div class="row mb-1">
            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-8">
              <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="2" required></textarea>
            </div>
          </div>
          <hr>
          <div id="list_detail">
            <h6>Rincian Transaksi</h6>
            <table class="table table-bordered" id="dataTableTransaksi" style="border:1px solid #ddd; font-size:15px;">
              <thead class="tr-head">
                <th class="text-center" style="width:15%;">Akun </th>
                <th style="width:25%;">Keterangan </th>
                <th class="text-center" style="width:10%;">Debet </th>
                <th class="text-center" style="width:10%;">Kredit </th>
                <th class="text-center" style="width:5%;" class="text-center">Aksi </th>
              </thead>
              <tbody>
                <!-- Edit Rincian -->
                <?php if (isset($data_detail)) {
                  foreach ($data_detail as $row) { ?>
                <!-- <tr>
                      <td><input type='hidden' name='barang[]' class='form-control form-control-sm' value='{{ $row->id_barang }}'><b>[{{ $row->kode_barang }}]</b> {{ $row->nama_barang }}</td>
                      <td><input type='text' name='qty[]' class='form-control form-control-sm qty' placeholder='Qty' value="{{ $row->jumlah }}" required></td>
                      <td><input type='number' name='harga[]' class='form-control form-control-sm harga' value="{{ $row->harga }}" placeholder='Harga'></td>
                      <td><input type='number' name='diskon[]' class='form-control form-control-sm diskon' value="{{ $row->diskon }}" placeholder='Diskon'></td>
                      <td class='text-right'>
                        <input type='hidden' class='form-control form-control-sm sub_total_hidden' value="">
                        <span class='sub_total'></span>
                      </td>
                      <td class='text-center'><a href='javascript:;' onclick='deleteRow(this)' class='btn btn-sm btn-danger'><i class='fa fa-times-circle'></i></a></td>
                    </tr> -->
                <?php }} ?>
              </tbody>
              <tbody>
                <tr style="border-top: 2px solid #ddd;">
                  <td class="text-center">
                    <a href="javascript:;" onclick="lookupAkun()" class="btn btn-success"><i
                        class="fa fa-plus-circle"></i> Tambah</a>
                  </td>
                  <td class="text-end"><b>Total</b></td>
                  <td class="text-end">
                    <input type="hidden" id="input_total_debet" value="0">
                    <b><span class="total_debet">0</span></b>
                  </td>
                  <td class="text-end">
                    <input type="hidden" id="input_total_kredit" value="0">
                    <b><span class="total_kredit">0</span></b>
                  </td>
                  <td></td>
                </tr>
              </tbody>
            </table>
            <input type="hidden" id="jumlah-row" value="0">
          </div>
          <hr>
          <div class="float-end">
            <a href="<?= site_url('jurnal') ?>" class="btn btn-secondary">Batal</a>
            <button id="btn-save" type="submit" class="btn btn-primary"><i id="loading" class=""></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="div_modal_lookup_akun"></div>
<script>
$(document).ready(function() {
  const modeform = $('#modeform').val()
  if (modeform == 'UPDATE') {
    loadTotal()
  }
})

$('.date-picker').datepicker({
  autoclose: true,
});

function selectRowAkun(payload) {
  console.log("row akun selected", payload)
  addRows(payload)
}

function lookupAkun() {
  $.ajax({
    url: "<?= site_url('Akun/lookup_akun/')?>",
    type: 'post',
    dataType: 'html',
    beforeSend: function() {},
    success: function(result) {
      $('#div_modal_lookup_akun').html(result);
      $('#modal_lookup_akun').modal('show');
    }
  });
};

function validateRow(val) {
  let table = document.getElementById("dataTableTransaksi");
  let count = table.rows.length;
  let result = false;
  for (let i = 0; i < count; i++) {
    if (i != 0) {
      const el = table.rows[i].cells[0];
      let cekInput = el.getElementsByTagName('input');
      if (cekInput.length > 0) {
        let input = cekInput[0].value;
        if (input == val) {
          result = true;
          break;
        }
      }
    }
  }
  return result;
}

function addRows(val) {
  let jumlah = parseInt($("#jumlah-row").val()) + 1;
  let data = "<tr>" +
    "<td><input type='hidden' name='akun[]' class='form-control' value='" + val.id + "'>" + "<b>[" + val
    .kode + "]</b> " + val.nama + "</td>" +
    "<td style='padding:0px;'><input type='text' name='ket[]' class='form-control ket' autocomplete='off' placeholder='Keterangan' required></td>" +
    "<td style='padding:0px;'><input type='number' name='debet[]' class='form-control text-end debet' placeholder='0'></td>" +
    "<td style='padding:0px;'><input type='number' name='kredit[]' class='form-control text-end kredit' placeholder='0'></td>" +
    "<td style='padding:0px; vertical-align:middle;' class='text-center'><a href='javascript:;' onclick='deleteRow(this)' class='btn btn-sm btn-danger'><i class='fa fa-times-circle'></i></a></td>" +
    "</tr>";
  $('#dataTableTransaksi').append(data);
  $("#jumlah-row").val(jumlah);
  $('#modal_lookup_akun').modal('hide');
}

function deleteRow(r) {
  var jumlah = parseInt($("#jumlah-row").val());
  var moverow = jumlah - 1;
  var i = r.parentNode.parentNode.rowIndex;
  document.getElementById("dataTableTransaksi").deleteRow(i);
  $("#jumlah-row").val(moverow);
  calculateGrandTotal()
}

$(document).on('input', ".debet", function() {
  const self = $(this);
  calculateTotal();
});

$(document).on('input', ".kredit", function() {
  const self = $(this);
  calculateTotal();
});

function loadTotal() {
  $("#dataTableTransaksi tr").each(function() {
    let qty = parseFloat($(this).find(".qty").val() || 0);
    let harga = parseFloat($(this).find(".harga").val() || 0);
    let diskon = parseInt($(this).find(".diskon").val() || 0);
    let total = (qty * harga) - diskon;
    $(this).find(".sub_total_hidden").val(total);
    $(this).find(".sub_total").text(formatNumber(total));
  });
  calculateGrandTotal()
}

function calculateTotal() {
  var debet = 0;
  var kredit = 0;
  $(".debet").each(function() {
    var value = $(this).val();
    if (!isNaN(value) && value.length != 0) {
      debet += parseFloat(value);
    }
  });

  $(".kredit").each(function() {
    var value = $(this).val();
    if (!isNaN(value) && value.length != 0) {
      kredit += parseFloat(value);
    }
  });

  let total_debet = formatNumber(debet);
  let total_kredit = formatNumber(kredit);

  $('#input_total_debet').val(debet)
  $('#input_total_kredit').val(kredit)
  $('.total_debet').text(total_debet)
  $('.total_kredit').text(total_kredit)
}

function formatNumber(val) {
  if (!val) return 0
  return parseInt(val) < 0 ?
    '(' + Number(Math.abs(parseInt(val))).toLocaleString() + ')' :
    Number(Math.abs(parseInt(val))).toLocaleString()
}

$(document).on('submit', '#formData', function(event) {
  event.preventDefault();
  const modeform = $('#modeform').val();
  let debet = $('#input_total_debet').val();
  let kredit = $('#input_total_kredit').val();
  let row_count = $("#jumlah-row").val();
  let url = (modeform == 'ADD') ? '/jurnal/save' : '/jurnal/update';

  if(row_count==0){
    Swal.fire({
      icon: 'error',
      title: 'Maaf',
      text: 'Rincian transaksi tidak boleh kosong'
    });
    return
  }

  if(debet==0){
    Swal.fire({
      icon: 'error',
      title: 'Maaf',
      text: 'Silahkan periksa kembali nominal debet & kredit'
    });
    return
  }

  // validate
  if(debet==kredit){
      $("#loading").addClass("fa fa-spinner fa-spin");
      $('#btn-save').prop('disabled', true)
      $.ajax({
        url: site_url + url,
        method: 'POST',
        dataType: 'json',
        data: new FormData($('#formData')[0]),
        async: true,
        processData: false,
        contentType: false,
        success: function(data) {
          if (data.success == true) {
            setTimeout(function() {
              Toast.fire({
                icon: 'success',
                title: data.message
              });

              $("#loading").removeClass("fa fa-spinner fa-spin");
              $('#btn-save').prop('disabled', false)
              // window.location.href = site_url + "/jurnal";
            }, 1000);
          } else {
            $("#loading").removeClass("fa fa-spinner fa-spin");
            $('#btn-save').prop('disabled', false)
            Swal.fire({
              icon: 'error',
              title: 'Maaf',
              text: data.message
            });
          }
        },
        fail: function(event) {
          alert(event);
        }
      });
  }else{
    Swal.fire({
      icon: 'error',
      title: 'Maaf',
      text: 'Silahkan periksa kembali nominal debet & kredit'
    });
  }
});
</script>
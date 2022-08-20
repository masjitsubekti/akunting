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
    <div class="card mt-4 mb-4">
      <div class="card-header">
        <span class="card-title">Form Pembelian</span>
      </div>
      <div class="card-body">
        <form id="formData">
          <input type="hidden" name="id" id="id" value="<?= (isset($data)) ?  $data['id'] : '' ?>">
          <input type="hidden" name="modeform" id="modeform" value="<?= $modeform ?>">

          <div class="row">
            <div class="col-md-10">
              <div class="row mb-1">
                <label for="nomor_transaksi" class="col-sm-2 col-form-label">No Transaksi</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="nomor_transaksi" id="nomor_transaksi"
                    value="<?= (isset($data)) ?  $data['nomor'] : $nomor_transaksi ?>" readonly>
                </div>
              </div>
              <div class="row mb-1">
                <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-4">
                  <input class="form-control date-picker" id="tanggal" name="tanggal" data-date-format='dd-mm-yyyy'
                    autocomplete="off" onkeypress="return false;" value="<?php
                          if(isset($data)){
                            $time = strtotime($data['tanggal']);
                            $tgl = date('d-m-Y', $time);
                            echo $tgl;
                          }else {
                            echo date('d-m-Y'); 
                          }?>" required>
                </div>
              </div>
              <div class="row mb-1" id="select-supplier">
                <label for="supplier" class="col-sm-2 form-label">Supplier</label>
                <div class="col-sm-7">
                  <select class="form-control" name="supplier" id="supplier" required>
                    <option value="">Pilih Supplier</option>
                    <?php foreach ($supplier as $s){ ?>
                    <option <?php 
                      if(isset($data)){
                        if($data['id_supplier'] == $s->id){
                            echo 'selected ';
                        }
                      }
                  ?> value="<?= $s->id ?>">[<?= $s->kode; ?>] <?= $s->nama; ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row mb-1">
                <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-9">
                  <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="2"
                    placeholder="Keterangan" required><?= (isset($data)) ?  $data['keterangan'] : '' ?></textarea>
                </div>
              </div>
            </div>
            <div class="col-md-2 text-right">
              <span>Pembayaran : </span>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  Tunai
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                <label class="form-check-label" for="flexRadioDefault2">
                  Kredit
                </label>
              </div>
            </div>
          </div>
          <hr>
          <div id="list_detail">
            <h6>Rincian Transaksi</h6>
            <table class="table table-bordered" id="dataTableTransaksi" style="border:1px solid #ddd; font-size:15px;">
              <thead class="tr-head">
                <th class="text-center" style="width:15%;">Nama Barang </th>
                <th class="text-center" style="width:5%;">Jumlah </th>
                <th class="text-center" style="width:10%;">Harga </th>
                <th class="text-center" style="width:10%;">Pajak </th>
                <th class="text-center" style="width:10%;">Total </th>
                <th class="text-center" style="width:5%;" class="text-center">Aksi </th>
              </thead>
              <tbody>
                <!-- Edit Rincian -->
                <?php if (isset($details)) {
                  foreach ($details as $row) { ?>
                <tr>
                  <td>
                    <input type='hidden' name='id_jurnal_detail[]' class='form-control' value='<?= $row->id ?>'>
                    <input type='hidden' name='akun[]' class='form-control'
                      value='<?= $row->id_akun ?>'><b>[<?= $row->kode_akun ?>] </b><?= $row->nama_akun ?>
                  </td>
                  <td style='padding:0px;'>
                    <input type='text' name='ket[]' class='form-control ket' autocomplete='off' placeholder='Keterangan'
                      value="<?= $row->keterangan ?>" required>
                  </td>
                  <td style='padding:0px;'>
                    <input type='number' name='debet[]' class='form-control text-end debet' placeholder='0'
                      value='<?= floatval($row->debet) ?>'>
                  </td>
                  <td style='padding:0px;'>
                    <input type='number' name='kredit[]' class='form-control text-end kredit' placeholder='0'
                      value='<?= floatval($row->kredit) ?>'>
                  </td>
                  <td style='padding:0px; vertical-align:middle;' class='text-center'>
                    <a href='javascript:;' onclick='deleteRow(this)' class='btn btn-sm btn-danger'><i
                        class='fa fa-times-circle'></i></a>
                  </td>
                </tr>
                <?php }} ?>
              </tbody>
              <tbody>
                <tr style="border-top: 2px solid #ddd;">
                  <td class="text-center">
                    <a href="javascript:;" onclick="addRows()" class="btn btn-success"><i
                        class="fa fa-plus-circle"></i> Tambah</a>
                  </td>
                  <td colspan="3" class="text-end"><b>Total</b></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
            <input type="text" id="jumlah-row" value="<?= (isset($details)) ?  count($details) : 0 ?>">
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

$("#supplier").select2({
  placeholder: "Pilih Supplier",
  allowClear: true,
  dropdownParent: $("#select-supplier")
});

$('.date-picker').datepicker({
  autoclose: true,
});

function selectRow(payload) {
  addRows(payload)
}

$('#btn-add').on('click', function() {
  $.ajax({
    url: base_url + "/lookup-barang",
    type: 'GET',
    data: {},
    dataType: 'html',
    beforeSend: function() {},
    success: function(result) {
      $('#div_modal').html(result);
      $('#lookup_barang').modal('show');
    }
  });
});

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

function addRows(val={
  id_barang : 1,
  kode : '567',
  nama : 'Laptop',
  harga_beli : 1000000,
}) {
  // let found = validateRow(val.id_barang);
  let found = false
  if (found) {
    Swal.fire({
      icon: 'warning',
      title: 'Maaf',
      text: 'Barang sudah tersedia dalam item transaksi!'
    });
  } else {
    let jumlah = parseInt($("#jumlah-row").val()) + 1;
    let data = "<tr>" +
      "<td><input type='text' name='barang[]' class='form-control form-control-sm barang_hidden' value='" + val
      .id_barang + "'>" + "<b>[" + val.kode + "]</b> " + val.nama + "</td>" +
      "<td><input type='number' name='qty[]' class='form-control form-control-sm qty' placeholder='0' required></td>" +
      "<td><input type='number' name='harga[]' class='form-control form-control-sm harga' value='" + val.harga_beli +
      "' placeholder='0' required></td>" +
      "<td><input type='number' name='diskon[]' class='form-control form-control-sm diskon' placeholder='0'></td>" +
      "<td class='text-right'><input type='text' class='form-control form-control-sm sub_total_hidden'> <span class='sub_total'></span></td>" +
      "<td class='text-center'><a href='javascript:;' onclick='deleteRow(this)' class='btn btn-sm btn-danger'><i class='fa fa-times-circle'></i></a></td>" +
      "</tr>";
    $('#dataTableTransaksi').append(data);
    $("#jumlah-row").val(jumlah);
    $('#lookup_barang').modal('hide');
  }
}

function deleteRow(r) {
  var jumlah = parseInt($("#jumlah-row").val());
  var moverow = jumlah - 1;
  var i = r.parentNode.parentNode.rowIndex;
  document.getElementById("dataTableTransaksi").deleteRow(i);
  $("#jumlah-row").val(moverow);
  calculateGrandTotal()
}

$(document).on('input', ".qty", function() {
  const self = $(this);
  let qty = parseInt($(this).val() || 0);
  let harga = parseFloat($(this).parents('tr').find(".harga").val() || 0);
  let diskon = parseFloat($(this).parents('tr').find(".diskon").val() || 0);
  let total = (qty * harga) - diskon;
  $(this).parents('tr').find(".sub_total_hidden").val(total);
  $(this).parents('tr').find(".sub_total").text(formatNumber(total));
  calculateGrandTotal()
});

$(document).on('input', ".harga", function() {
  const self = $(this);
  let harga = parseInt($(this).val() || 0);
  let qty = parseFloat($(this).parents('tr').find(".qty").val() || 0);
  let diskon = parseFloat($(this).parents('tr').find(".diskon").val() || 0);
  let total = (qty * harga) - diskon;
  $(this).parents('tr').find(".sub_total_hidden").val(total);
  $(this).parents('tr').find(".sub_total").text(formatNumber(total));
  calculateGrandTotal()
});

$(document).on('input', ".diskon", function() {
  const self = $(this);
  let diskon = parseInt($(this).val() || 0);
  let qty = parseFloat($(this).parents('tr').find(".qty").val() || 0);
  let harga = parseFloat($(this).parents('tr').find(".harga").val() || 0);
  let total = (qty * harga) - diskon;
  $(this).parents('tr').find(".sub_total_hidden").val(total);
  $(this).parents('tr').find(".sub_total").text(formatNumber(total));
  calculateGrandTotal()
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

function calculateGrandTotal() {
  var total = 0;
  var diskon = 0;
  $(".diskon").each(function() {
    var value = $(this).val();
    if (!isNaN(value) && value.length != 0) {
      diskon += parseFloat(value);
    }
  });

  $(".sub_total_hidden").each(function() {
    var value = $(this).val();
    if (!isNaN(value) && value.length != 0) {
      total += parseFloat(value);
    }
  });

  let harga_total = formatNumber(total + diskon);
  let diskon_total = formatNumber(diskon);
  let grand_total = formatNumber(total);
  $('.harga_total').text(harga_total)
  $('.diskon_total').text(diskon_total)
  $('.grand_total').text(grand_total)
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
  let url = (modeform == 'ADD') ? '/barang-masuk/save' : '/barang-masuk/update';

  $("#loading").addClass("fa fa-spinner fa-spin");
  $('#btn-save').prop('disabled', true)
  $.ajax({
    url: base_url + url,
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
          window.location.href = "{{ url('/barang-masuk') }}";
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
});
</script>
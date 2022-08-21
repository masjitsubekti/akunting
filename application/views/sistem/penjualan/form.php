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
        <span class="card-title">Form Penjualan</span>
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
              <div class="row mb-1" id="select-pelanggan">
                <label for="id_pelanggan" class="col-sm-2 form-label">Pelanggan</label>
                <div class="col-sm-7">
                  <select class="form-control" name="id_pelanggan" id="id_pelanggan" required>
                    <option value="">Pilih Pelanggan</option>
                    <?php foreach ($pelanggan as $s){ ?>
                    <option <?php 
                      if(isset($data)){
                        if($data['id_pelanggan'] == $s->id){
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
                <input class="form-check-input" type="radio" name="pembayaran" id="radioTunai" value="TUNAI"
                  <?php if(isset($data)) {
                    echo ($data['pembayaran']=='TUNAI') ? ' checked' : '';
                  }else{
                    echo ' checked';
                  } ?>
                >
                <label class="form-check-label" for="radioTunai">
                  Tunai
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pembayaran" id="radioKredit" value="KREDIT"
                  <?php if(isset($data)) {
                    echo ($data['pembayaran']=='KREDIT') ? ' checked' : '';
                  } ?>
                >
                <label class="form-check-label" for="radioKredit">
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
                <th class="text-center" style="width:20%;">Nama Barang </th>
                <th class="text-center" style="width:5%;">Jumlah </th>
                <th class="text-center" style="width:10%;">Harga </th>
                <th class="text-center" style="width:5%;">Pajak (%) </th>
                <th class="text-center" style="width:10%;">Total </th>
                <th class="text-center" style="width:5%;" class="text-center">Aksi </th>
              </thead>
              <tbody>
                <!-- Edit Rincian -->
                <?php if (isset($details)) {
                  foreach ($details as $row) { ?>
                <tr>
                  <td style='padding-bottom:0px;'>
                    <input type='hidden' name='id_penjualan_detail[]' class='form-control' value='<?= $row->id ?>'>
                    <input type='hidden' name='barang[]' class='form-control barang_hidden'
                      value='<?= $row->id_barang ?>'><b>[<?= $row->kode_barang ?>]</b> <?= $row->nama_barang ?>
                  </td>
                  <td style='padding:0px;'>
                    <input type='number' name='qty[]' class='form-control text-end qty' placeholder='0'
                      value='<?= $row->qty ?>' required>
                  </td>
                  <td style='padding:0px;'>
                    <input type='number' name='harga[]' class='form-control text-end harga'
                      value='<?= floatval($row->harga) ?>' placeholder='0' required>
                  </td>
                  <td style='padding:0px;'>
                    <input type='number' name='ppn[]' class='form-control text-end ppn'
                      value="<?= floatval($row->ppn) ?>" placeholder='0'>
                  </td>
                  <td style='padding-bottom:0px;' class='text-end'>
                    <input type='hidden' class='form-control sub_total_hidden' value=''> <span class='sub_total'></span>
                  </td>
                  <td style='padding:0px;' class='text-center'>
                    <a href='javascript:;' onclick='deleteRow(this)' class='btn btn-sm btn-danger'><i
                        class='fa fa-times-circle'></i></a>
                  </td>
                </tr>
                <?php }} ?>
              </tbody>
              <tbody>
                <tr style="border-top: 2px solid #ddd;">
                  <td class="text-center">
                    <a href="javascript:;" onclick="lookupBarang()" class="btn btn-success"><i
                        class="fa fa-plus-circle"></i>
                      Tambah</a>
                  </td>
                  <td colspan="3" class="text-end"><b>Total</b></td>
                  <td class="text-end"><b><span class="grand_total">0</span></b></td>
                </tr>
              </tbody>
            </table>
            <input type="hidden" id="jumlah-row" value="<?= (isset($details)) ?  count($details) : 0 ?>">
          </div>
          <hr>
          <div class="float-end">
            <a href="<?= site_url('Penjualan') ?>" class="btn btn-secondary">Batal</a>
            <button id="btn-save" type="submit" class="btn btn-primary"><i id="loading" class=""></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="div_modal_lookup_barang"></div>
<script>
$(document).ready(function() {
  const modeform = $('#modeform').val()
  if (modeform == 'UPDATE') {
    loadTotal()
  }
})

$("#id_pelanggan").select2({
  placeholder: "Pilih Pelanggan",
  allowClear: true,
  dropdownParent: $("#select-pelanggan")
});

$('.date-picker').datepicker({
  autoclose: true,
});

function selectRow(payload) {
  addRows(payload)
}

function lookupBarang() {
  $.ajax({
    url: site_url + "/Barang/lookup_barang",
    type: 'GET',
    data: {},
    dataType: 'html',
    beforeSend: function() {},
    success: function(result) {
      $('#div_modal_lookup_barang').html(result);
      $('#modal_lookup_barang').modal('show');
    }
  });
}

function validateRow(val) {
  let table = document.getElementById("dataTableTransaksi");
  let count = table.rows.length;
  let result = false;
  for (let i = 0; i < count; i++) {
    if (i != 0) {
      const el = table.rows[i].cells[0];
      let cekInput = el.getElementsByTagName('input');
      if (cekInput.length > 0) {
        let input = cekInput[1].value;
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
  let found = validateRow(val.id);
  if (found) {
    Swal.fire({
      icon: 'warning',
      title: 'Maaf',
      text: 'Barang sudah tersedia dalam item transaksi!'
    });
  } else {
    let jumlah = parseInt($("#jumlah-row").val()) + 1;
    let data = "<tr>" +
      "<td style='padding-bottom:0px;'>" +
      "<input type='hidden' name='id_penjualan_detail[]' class='form-control' value=''>" +
      "<input type='hidden' name='barang[]' class='form-control barang_hidden' value='" + val.id + "'>" + "<b>[" + val.kode + "]</b> " + val.nama + "</td>" +
      "<td style='padding:0px;'><input type='number' name='qty[]' class='form-control text-end qty' placeholder='0' value='1' required></td>" +
      "<td style='padding:0px;'><input type='number' name='harga[]' class='form-control text-end harga' value='" + parseFloat(val.harga_jual) + "' placeholder='0' required></td>" +
      "<td style='padding:0px;'><input type='number' name='ppn[]' class='form-control text-end ppn' placeholder='0'></td>" +
      "<td style='padding-bottom:0px;' class='text-end'><input type='hidden' class='form-control sub_total_hidden' value='" + parseFloat(val.harga_jual) + "'> <span class='sub_total'>" + formatNumber(val.harga_jual) + "</span></td>" +
      "<td style='padding:0px;' class='text-center'><a href='javascript:;' onclick='deleteRow(this)' class='btn btn-sm btn-danger'><i class='fa fa-times-circle'></i></a></td>" +
      "</tr>";
    $('#dataTableTransaksi').append(data);
    $("#jumlah-row").val(jumlah);
    $('#modal_lookup_barang').modal('hide');
    calculateGrandTotal()
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
  let ppn = parseFloat($(this).parents('tr').find(".ppn").val() || 0);
  let pajak = (qty * harga) * ppn / 100;
  let total = (qty * harga) + pajak;
  $(this).parents('tr').find(".sub_total_hidden").val(total);
  $(this).parents('tr').find(".sub_total").text(formatNumber(total));
  calculateGrandTotal()
});

$(document).on('input', ".harga", function() {
  const self = $(this);
  let harga = parseInt($(this).val() || 0);
  let qty = parseFloat($(this).parents('tr').find(".qty").val() || 0);
  let ppn = parseFloat($(this).parents('tr').find(".ppn").val() || 0);
  let pajak = (qty * harga) * ppn / 100;
  let total = (qty * harga) + pajak;
  $(this).parents('tr').find(".sub_total_hidden").val(total);
  $(this).parents('tr').find(".sub_total").text(formatNumber(total));
  calculateGrandTotal()
});

$(document).on('input', ".ppn", function() {
  const self = $(this);
  let ppn = parseInt($(this).val() || 0);
  let qty = parseFloat($(this).parents('tr').find(".qty").val() || 0);
  let harga = parseFloat($(this).parents('tr').find(".harga").val() || 0);
  let pajak = (qty * harga) * ppn / 100;
  let total = (qty * harga) + pajak;
  $(this).parents('tr').find(".sub_total_hidden").val(total);
  $(this).parents('tr').find(".sub_total").text(formatNumber(total));
  calculateGrandTotal()
});

function loadTotal() {
  $("#dataTableTransaksi tr").each(function() {
    let qty = parseFloat($(this).find(".qty").val() || 0);
    let harga = parseFloat($(this).find(".harga").val() || 0);
    let ppn = parseInt($(this).find(".ppn").val() || 0);
    let pajak = (qty * harga) * ppn / 100;
    let total = (qty * harga) + pajak;
    $(this).find(".sub_total_hidden").val(total);
    $(this).find(".sub_total").text(formatNumber(total));
  });
  calculateGrandTotal()
}

function calculateGrandTotal() {
  var total = 0;
  $(".sub_total_hidden").each(function() {
    var value = $(this).val();
    if (!isNaN(value) && value.length != 0) {
      total += parseFloat(value);
    }
  });

  let grand_total = formatNumber(total);
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
  let url = (modeform == 'ADD') ? '/Penjualan/save' : '/Penjualan/update';

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
          // window.location.href = site_url + '/Penjualan';
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
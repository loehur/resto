<?php
$total = 0;
foreach ($data['order'] as $dk) {
  $subTotal = ($dk['harga'] * $dk['qty']) - $dk['diskon'];
  $total += $subTotal;
} ?>

<div class="w-100 mt-4">
  <div class="text-center">Total</div>
  <div class="text-center fs-5 fw-bold"><?= number_format($total) ?></div>
</div>
<div class="w-100 mt-3">
  <div class="d-flex justify-content-center">
    <div class="px-1"><span onclick="data_kembalian(<?= $total ?>)" class="pilihBayar btn btn-outline-primary">Pas</span></div>
    <div class="px-1"><span onclick="data_kembalian(20000)" class="pilihBayar btn btn-outline-primary">20.000</span></div>
    <div class="px-1"><span onclick="data_kembalian(50000)" class="pilihBayar btn btn-outline-primary">50.000</span></div>
    <div class="px-1"><span onclick="data_kembalian(100000)" class="pilihBayar btn btn-outline-primary">100.000</span></div>
  </div>
</div>
<div class="w-100 mt-3">
  <div class="text-center">Input Jumlah Bayar</div>
  <div class="text-center"><input class="border-top-0 border-start-0 border-end-0 border-bottom fs-2 text-success w-100 text-center inBayar" type="number"></div>
</div>
<div class="w-100 mt-3">
  <div class="text-center">Dibayar</div>
  <div class="text-center fs-5 fw-bold" id="dibayar"></div>
</div>
<div class="w-100 mt-3">
  <div class="d-flex justify-content-center">
    <div class="px-3 border-end">
      <div class="text-end">Kembalian</div>
      <div class="text-end fs-5 fw-bold text-danger" id="kembalian"></div>
    </div>
    <div class="px-3">
      <div class="text-center">Metode Bayar</div>
      <div class="form-check">
        <input class="form-check-input" type="radio" value="1" name="metode" id="flexRadioDefault2" checked>
        <label class="form-check-label" for="flexRadioDefault2">
          CASH
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" value="2" name="metode" id="flexRadioDefault1">
        <label class="form-check-label" for="flexRadioDefault1">
          QRIS
        </label>
      </div>
    </div>
  </div>
</div>
<div class="w-100 mt-4">
  <div class="text-center fs-5 fw-bold">
    <span class="btn btn-success w-100 bg-gradient rounded-0" onclick="bayarOK()">Bayar</span>
  </div>
</div>

<script>
  var bill = parseInt(<?= $total ?>);

  $('.inBayar').keyup(function() {
    let total_bayar = parseInt($(this).val());
    data_kembalian(total_bayar);
  })

  function data_kembalian(total_bayar) {
    let sisa = total_bayar - bill;
    $("#dibayar").html(number_format(total_bayar));
    if (sisa > 0) {
      $("#kembalian").html(number_format(sisa));
    } else {
      $("#kembalian").html(0);
    }
    $('.inBayar').val(total_bayar);
  }

  function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
      s = '',
      toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }

  function bayarOK() {
    let bill = parseInt(<?= $total ?>);
    let total_bayar = parseInt($('.inBayar').val());
    let metode = $('input[name="metode"]:checked').val();

    $.ajax({
      url: "<?= URL::BASE_URL ?>Penjualan/bayar",
      data: {
        mode: <?= $data['mode'] ?>,
        nomor: <?= $data['nomor'] ?>,
        dibayar: total_bayar,
        metode: metode
      },
      type: "POST",
      success: function(res) {
        if (res == 0) {
          $('.offcanvas.show').each(function() {
            $(this).offcanvas('hide');
          });
          $('button.pilih[data-group=nomor][data-id=' + nomor + '][data-mode=' + mode_dt + ']').removeClass('border-2 border-dark');
          load_pesanan(mode_dt, nomor);
        } else if (res == 1) {
          $('.offcanvas.show').each(function() {
            $(this).offcanvas('hide');
          });
          load_pesanan(mode_dt, nomor);
        } else {
          console.log(res);
        }
      },
    });
  }
</script>
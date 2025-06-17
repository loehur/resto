<?php
foreach ($data['order'] as $dk) { ?>
  <div class="d-flex flex-row border-bottom justify-content-between">
    <div class="py-1">
      <span class="fw-bold"><?= $data['menu'][$dk['id_menu']]['nama'] ?></span><br>
      <span class="text-success">Diskon:</span> <input data-val="<?= $dk['diskon'] ?>" data-max="<?= $dk['harga'] * $dk['qty'] ?>" class="border-0 text-success border-bottom-1 diskon" data-id="<?= $dk['id'] ?>" value="<?= $dk['diskon'] ?>" type="number">
    </div>
    <div class="py-1 align-self-center">
      <button data-id="<?= $dk['id_menu'] ?>" data-kat="<?= $data['menu'][$dk['id_menu']]['id_kategori'] ?>" data-add="-1" class="btn btn-sm btn-outline-danger fw-bold tambah_ubah" style="width: 30px;">-</button>
      <input data-id="<?= $dk['id_menu'] ?>" data-kat="<?= $data['menu'][$dk['id_menu']]['id_kategori'] ?>" style="width: 50px;" value="<?= $dk['qty'] ?>" class="manual_qty_ubah border-0 text-center fw-bold border-bottom-1" id="qty<?= $dk['id'] ?>" type="number">
      <button data-id="<?= $dk['id_menu'] ?>" data-kat="<?= $data['menu'][$dk['id_menu']]['id_kategori'] ?>" data-add="1" class="btn btn-sm btn-outline-success fw-bold tambah_ubah" style="width: 30px;">+</button>
    </div>
  </div>
<?php } ?>

<div class="w-100 mt-4">
  <div class="text-center fs-5 fw-bold">
    <span class="btn btn-outline-secondary w-100 rounded-0" data-bs-dismiss="offcanvas">Kembali</span>
  </div>
</div>

<script>
  $(".tambah_ubah").click(function() {
    const add = $(this).attr("data-add");
    const id = $(this).attr("data-id");
    const id_kat = $(this).attr("data-kat");

    let qty = $("#qty" + id).val();
    if (qty == 0 && add == -1) {
      return;
    } else {
      tambahMenu(add, id, qty, id_kat);
    }
  })

  var val_before;
  $("input.manual_qty_ubah").focusin(function() {
    val_before = $(this).val();
  });

  $("input.manual_qty_ubah").focusout(function() {
    const qty = $(this).val();
    if (val_before == qty) {
      console.log('Tidak ada perubahan qty');
      return;
    }
    const id = $(this).attr("data-id");
    const id_kat = $(this).attr("data-kat");
    tambahMenuManual(id, qty, id_kat);
  });

  $("input.diskon").focusout(function() {
    const max = $(this).attr("data-max");
    const id = $(this).attr("data-id");
    const val = $(this).attr("data-val");
    const diskon = $(this).val();
    if (parseInt(diskon) > parseInt(max)) {
      $(this).val(val);
      return;
    } else {
      setDiskon(id, diskon)
    }
  });

  $("input.diskon").focusin(function() {
    $(this).val('');
  });
</script>
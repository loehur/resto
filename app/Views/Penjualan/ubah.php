<?php
foreach ($data['order'] as $dk) { ?>
  <div class="d-flex flex-row border-bottom justify-content-between">
    <div class="py-1">
      <span class="fw-bold"><?= $data['menu'][$dk['id_menu']]['nama'] ?></span><br>
      <span class="text-success">Diskon:</span> <input data-val="<?= $dk['diskon'] ?>" data-max="<?= $dk['harga'] * $dk['qty'] ?>" class="border-0 text-success border-bottom-1 diskon" data-id="<?= $dk['id'] ?>" value="<?= $dk['diskon'] ?>" type="number">
    </div>
    <div class="py-1 align-self-center">
      <button data-id="<?= $dk['id_menu'] ?>" data-kat="<?= $data['menu'][$dk['id_menu']]['id_kategori'] ?>" data-add="-1" data-harga="<?= $dk['harga'] ?>" class="btn btn-sm btn-outline-danger fw-bold tambah_ubah" style="width: 30px;">
        -
      </button>
      <span class="px-2 fw-bold" id="qty<?= $dk['id'] ?>"><?= $dk['qty'] ?></span>
      <button data-id="<?= $dk['id_menu'] ?>" data-kat="<?= $data['menu'][$dk['id_menu']]['id_kategori'] ?>" data-add="1" data-harga="<?= $dk['harga'] ?>" class="btn btn-sm btn-outline-success fw-bold tambah_ubah" style="width: 30px;">
        +
      </button>
    </div>
  </div>
<?php } ?>

<script>
  $(".tambah_ubah").click(function() {
    const add = $(this).attr("data-add");
    const id = $(this).attr("data-id");
    const harga = $(this).attr("data-harga");
    const id_kat = $(this).attr("data-kat");

    let qty = $("#qty" + id).html();
    if (qty == 0 && add == -1) {
      return;
    } else {
      tambahMenu(add, id, harga, qty, id_kat);
    }
  })

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
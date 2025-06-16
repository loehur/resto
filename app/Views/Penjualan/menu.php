<?php
foreach ($data['menu'] as $dk) { ?>
  <div class="d-flex flex-row border-bottom justify-content-between">
    <div class="py-1">
      <span class="text-success fw-bold"><?= $dk['nama'] ?></span><br>
      Rp<?= number_format($dk['harga']) ?>
    </div>
    <div class="py-1 align-self-center">
      <button data-id="<?= $dk['id'] ?>" data-kat="<?= $dk['id_kategori'] ?>" data-add="-1" data-harga="<?= $dk['harga'] ?>" class="btn btn-sm btn-outline-danger fw-bold tambah" style="width: 30px;">
        -
      </button>
      <span class="px-2 fw-bold" id="qty<?= $dk['id'] ?>"><?= isset($data['order'][$dk['id']]) ? $data['order'][$dk['id']]['qty'] : 0 ?></span>
      <button data-id="<?= $dk['id'] ?>" data-kat="<?= $dk['id_kategori'] ?>" data-add="1" data-harga="<?= $dk['harga'] ?>" class="btn btn-sm btn-outline-success fw-bold tambah" style="width: 30px;">
        +
      </button>
    </div>
  </div>
<?php } ?>

<script>
  $(".tambah").click(function() {
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
</script>
<?php
foreach ($data['menu'] as $dk) { ?>
  <div class="d-flex flex-row border-bottom justify-content-between">
    <div class="py-1">
      <span class="text-success fw-bold"><?= $dk['nama'] ?></span><br>
      Rp<?= number_format($dk['harga']) ?>
    </div>
    <div class="py-1 align-self-center">
      <button data-id="<?= $dk['id'] ?>" data-kat="<?= $dk['id_kategori'] ?>" data-add="-1" class="btn btn-sm btn-outline-danger fw-bold tambah" style="width: 30px;">-</button>
      <input data-id="<?= $dk['id'] ?>" data-kat="<?= $dk['id_kategori'] ?>" style="width: 50px;" value="<?= isset($data['order'][$dk['id']]) ? $data['order'][$dk['id']]['qty'] : 0 ?>" class="manual_qty border-0 text-center fw-bold border-bottom-1" id="qty<?= $dk['id'] ?>" type="number">
      <button data-id="<?= $dk['id'] ?>" data-kat="<?= $dk['id_kategori'] ?>" data-add="1" class="btn btn-sm btn-outline-success fw-bold tambah" style="width: 30px;">+</button>
    </div>
  </div>
<?php } ?>

<script>
  $(".tambah").click(function() {
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
  $("input.manual_qty").focusin(function() {
    val_before = $(this).val();
  });

  $("input.manual_qty").focusout(function() {
    const qty = $(this).val();
    if (val_before == qty) {
      console.log('Tidak ada perubahan qty');
      return;
    }
    const id = $(this).attr("data-id");
    const id_kat = $(this).attr("data-kat");
    tambahMenuManual(id, qty, id_kat);
  });
</script>
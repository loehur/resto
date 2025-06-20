<table class="table table-sm mx-0">
  <thead>
    <tr>
      <th class="border-top-0">Pesanan</th>
      <th class="text-end border-top-0">Total</th>
    </tr>
  </thead>

  <tbody id="ubah_pesanan" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight1" aria-controls="offcanvasRight" style="cursor: pointer;">
    <?php
    $total = 0;;
    foreach ($data['order'] as $ref => $a) {
      foreach ($a as $key => $d) { ?>
        <?php
        $total_awal = ($d['harga'] * $d['qty']);
        $subTotal = ($d['harga'] * $d['qty']) - $d['diskon'];
        $total += $subTotal;
        ?>
        <tr>
          <td>
            <small><?= $d['id'] ?></small><span class="fw-bold"><?= $data['menu'][$key]['nama'] ?></span><br>
            <?= $d['qty'] ?>x @<?= number_format($d['harga']) ?> <?= number_format($total_awal) ?>
          </td>
          <td class="text-end">
            <?php if ($d['diskon'] > 0) { ?>
              <small class="text-success">Disc. <?= number_format($d['diskon']) ?></small><br>
            <?php } ?>
            <?= number_format($subTotal) ?>
          </td>
        </tr>
    <?php }
    } ?>
  </tbody>
  <tr class="table-borderless">
    <th class="text-end">
      Total
    </th>
    <th class="text-end"><?= number_format($total) ?></th>
  </tr>
</table>
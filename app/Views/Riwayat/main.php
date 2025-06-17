<?php
foreach ($data['ref'] as $key => $r) { ?>
  <div class="row mx-0 border-bottom py-1">
    <div class="col">
      <b><?= $r['id'] ?></b><br>
      <span class="badge bg-primary"><?= $r['mode'] == 0 ? "Dine-In" : "Take-Away" ?></span><br>
      No. <?= $r['nomor'] ?>
    </div>
    <div class="col text-end">
      <?= date('d M y, H:i', strtotime($r['tgl'] . " " . $r['jam'] . ":00")) ?><br>
      <span class="fw-bold">Rp<?= number_format($data['total'][$key]) ?></span><br>
      <?php
      switch ($r['step']) {
        case 1:
          echo "<span class='badge bg-success'>Lunas</span>";
          break;
        case 2:
          echo "<span class='badge bg-secondary'>Batal</span>";
          break;
        case 3:
          echo "<span class='badge bg-danger'>Piutang</span>";
          break;
        case 4:
          echo "<span class='badge bg-warning'>Pengecekan</span>";
          break;
        default:
          echo "<span class='badge bg-dark'>???</span>";
          break;
      }
      ?>
    </div>
  </div>
<?php } ?>
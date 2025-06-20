<script src="<?= $this->ASSETS_URL ?>js/alpine.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>mine/luhur.js"></script>

<?php
$total = 0;
?>

<div x-data="dataBill">
  <?php foreach ($data['order'] as $key => $d) {
    $total += $data['total'][$key]; ?>
    <div class="form-check w-100">
      <input class="form-check-input cekbox" type="checkbox" x-on:change="cek" data-val="<?= $data['total'][$key] ?>" value="<?= $key ?>" id="flexCheckChecked" checked>
      <label class="form-check-label w-100" for="flexCheckChecked">
        <div class="d-flex justify-content-between">
          <div><?= date('d M y', strtotime($key . " 00:00:00")) ?></div>
          <div>Rp<?= number_format($data['total'][$key]) ?></span></div>
        </div>
      </label>
    </div>
  <?php } ?>
  <div class="d-flex justify-content-between border-top py-1 mt-2">
    <div></div>
    <div class="fw-bold">
      Rp<span x-text="showBill"></span>
    </div>
  </div>
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('dataBill', () => ({
      bill: parseInt(<?= $total ?>),
      showBill: '<?= number_format($total) ?>',

      cek() {
        this.bill = 0;
        var tol = 0;
        $(".cekbox:checked").each(function() {
          let val = $(this).attr('data-val');
          tol += parseInt(val);
        })
        this.bill = tol;
        this.showBill = number_format(this.bill);
      }
    }))
  })
</script>
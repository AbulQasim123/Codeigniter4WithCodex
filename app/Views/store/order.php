<?= $this->extend('layout') ?><?= $this->section('content') ?>
<div class="card text-center">
    <div class="card-body p-5">
        <div class="display-4">✓</div>
        <h1 class="mt-3">Thanks for your order!</h1>
        <p class="text-muted">Order <strong><?= esc($order['order_number']) ?></strong> is <?= esc($order['status']) ?>.
        </p>
        <h3>₹<?= number_format($order['total'], 2) ?></h3><a href="<?= base_url('/') ?>"
            class="btn btn-dark mt-3">Continue shopping</a>
    </div>
</div><?= $this->endSection() ?>
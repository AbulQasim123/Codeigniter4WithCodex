<?= $this->extend('admin_layout') ?><?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center">
    <h1>Dashboard</h1><a class="btn btn-dark" href="<?= base_url('admin/products') ?>">Manage products</a>
</div>
<div class="row g-4 mt-2">
    <?php foreach (['Products' => $products, 'Orders' => $orders, 'Customers' => $customers] as $label => $value): ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted"><?= $label ?></div>
                    <div class="display-5 fw-bold"><?= $value ?></div>
                </div>
            </div>
        </div><?php endforeach ?>
</div><?= $this->endSection() ?>
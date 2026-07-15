<?= $this->extend('layout') ?><?= $this->section('content') ?>
<section class="hero p-5 mb-5">
    <div class="col-lg-7"><span class="badge text-bg-light text-dark mb-3">Thoughtfully selected</span>
        <h1 class="display-5 fw-bold">Everyday essentials, beautifully simple.</h1>
        <p class="lead">Browse quality products, enjoy a fast guest cart, and check out in minutes.</p>
    </div>
</section>
<form class="row g-2 mb-4">
    <div class="col-md-7"><input class="form-control form-control-lg" name="q"
            value="<?= esc(service('request')->getGet('q')) ?>" placeholder="Search products or SKU"></div>
    <div class="col-auto"><button class="btn btn-dark btn-lg">Search</button></div>
</form>
<div class="d-flex gap-2 mb-4 flex-wrap"><?php foreach ($categories as $c): ?><span
            class="badge rounded-pill text-bg-light border p-2"><?= esc($c['name']) ?></span><?php endforeach ?></div>
<div class="row g-4"><?php foreach ($products as $p): ?>
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100"><img class="card-img-top product-image"
                    src="<?= esc($p['image'] ?: 'https://placehold.co/600x400/e9ecef/495057?text=' . urlencode($p['name'])) ?>"
                    alt="<?= esc($p['name']) ?>">
                <div class="card-body d-flex flex-column"><small class="text-muted"><?= esc($p['category_name']) ?></small>
                    <h5 class="mt-1"><?= esc($p['name']) ?></h5>
                    <p class="price mb-3">₹<?= number_format((float) ($p['sale_price'] ?: $p['price']), 2) ?></p>
                    <form method="post" action="<?= base_url('cart/add/' . $p['id']) ?>" class="mt-auto"><button
                            class="btn btn-dark w-100" <?= $p['stock'] < 1 ? 'disabled' : '' ?>><?= $p['stock'] < 1 ? 'Out of stock' : 'Add to cart' ?></button></form>
                </div>
            </div>
        </div><?php endforeach ?>
</div><?php if (!$products): ?>
    <div class="text-center p-5 text-muted">No products found yet.</div><?php endif ?><?= $this->endSection() ?>
<?= $this->extend('layout') ?><?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-7">
        <h1>Checkout</h1>
        <form method="post" action="<?= base_url('checkout') ?>" class="card">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Full name</label><input required
                            class="form-control" name="customer_name" value="<?= esc(session('user.name')) ?>"></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input required type="email"
                            class="form-control" name="email"></div>
                    <div class="col-md-6"><label class="form-label">Phone</label><input required class="form-control"
                            name="phone"></div>
                    <div class="col-12"><label class="form-label">Delivery address</label><textarea required
                            class="form-control" name="address" rows="3"></textarea></div>
                    <div class="col-12"><label class="form-label">Payment</label><select name="payment_method"
                            class="form-select">
                            <option value="cod">Cash on Delivery</option>
                        </select></div>
                    <div class="col-12"><button class="btn btn-dark w-100">Place order ·
                            ₹<?= number_format($content['total'], 2) ?></button></div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h5>Order summary</h5><?php foreach ($content['items'] as $i): ?>
                    <div class="d-flex justify-content-between py-2"><span><?= esc($i['name']) ?> ×
                            <?= $i['quantity'] ?></span><span>₹<?= number_format($i['line_total'], 2) ?></span></div>

                <?php endforeach ?>
                <hr><strong>Total ₹<?= number_format($content['total'], 2) ?></strong>
            </div>
        </div>
    </div>
</div><?= $this->endSection() ?>
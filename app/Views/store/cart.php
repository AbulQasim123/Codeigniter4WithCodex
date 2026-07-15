<?= $this->extend('layout') ?><?= $this->section('content') ?>
<h1 class="mb-4">Your cart</h1><?php if ($content['items']): ?>
    <div class="card">
        <div class="card-body"><?php foreach ($content['items'] as $i): ?>
                <div class="row align-items-center border-bottom py-3 cart-row" data-id="<?= $i['id'] ?>">
                    <div class="col"><strong><?= esc($i['name']) ?></strong>
                        <div class="text-muted">₹<?= number_format($i['unit_price'], 2) ?> each</div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group"><button class="btn btn-outline-dark qty" data-change="-1">−</button><input
                                class="form-control text-center quantity" value="<?= $i['quantity'] ?>" readonly><button
                                class="btn btn-outline-dark qty" data-change="1">+</button></div>
                    </div>
                    <div class="col-md-2 text-end fw-bold">₹<?= number_format($i['line_total'], 2) ?></div>
                </div><?php endforeach ?>
            <div class="d-flex justify-content-between pt-4">
                <h4>Total: ₹<span id="cartTotal"><?= number_format($content['total'], 2) ?></span></h4><a
                    class="btn btn-dark" href="<?= base_url('checkout') ?>">Proceed to checkout</a>
            </div>
        </div>
    </div><?php else: ?>
    <div class="card">
        <div class="card-body text-center p-5">Your cart is empty. <a href="<?= base_url('/') ?>">Start shopping</a>.</div>
    </div><?php endif ?><?= $this->endSection() ?><?= $this->section('scripts') ?>
<script>$('.qty').on('click', function () { const row = $(this).closest('.cart-row'), input = row.find('.quantity'), q = +input.val() + +$(this).data('change'); if (q < 0) return; $.post('<?= base_url('cart/update') ?>/' + row.data('id'), { quantity: q }).done(r => { input.val(q); $('#cartCount').text(r.count); $('#cartTotal').text(Number(r.total).toFixed(2)); if (q === 0) row.remove(); notify(r.message) }).fail(x => notify(x.responseJSON.message, false)) })</script>

<?= $this->endSection() ?>
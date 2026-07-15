<?= $this->extend('admin_layout') ?><?= $this->section('content') ?>
<h1 class="mb-4">Orders</h1>
<div class="card">
    <div class="card-body">
        <table id="dataTable" class="table align-middle">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody><?php foreach ($orders as $o): ?>
                    <tr>
                        <td><strong><?= esc($o['order_number']) ?></strong><br><small><?= esc($o['created_at']) ?></small>
                        </td>
                        <td><?= esc($o['customer_name']) ?><br><small><?= esc($o['email']) ?></small></td>
                        <td>₹<?= number_format($o['total'], 2) ?></td>
                        <td><?= strtoupper(esc($o['payment_method'])) ?></td>
                        <td>
                            <form class="status-form d-flex gap-1" data-id="<?= $o['id'] ?>"><select name="status"
                                    class="form-select form-select-sm"><?php foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $s): ?>
                                        <option <?= $o['status'] === $s ? 'selected' : '' ?>><?= $s ?></option><?php endforeach ?>
                                </select><button class="btn btn-sm btn-dark">Save</button></form>
                        </td>
                    </tr><?php endforeach ?>
            </tbody>
        </table>
    </div>
</div><?= $this->endSection() ?><?= $this->section('scripts') ?>
<script>new DataTable('#dataTable'); $('.status-form').on('submit', function (e) { e.preventDefault(); $.post(BASE + 'admin/orders/' + $(this).data('id'), $(this).serialize()).done(r => notify(r.message)).fail(x => notify(Object.values(x.responseJSON.errors)[0], 'error')) })</script>

<?= $this->endSection() ?>
<?= $this->extend('admin_layout') ?><?= $this->section('content') ?>
<div class="d-flex justify-content-between mb-4">
    <h1>Products</h1><button class="btn btn-dark" data-bs-toggle="collapse" data-bs-target="#editor">Add
        product</button>
</div>
<div id="editor" class="collapse">
    <div class="card mb-4">
        <div class="card-body">
            <form id="productForm" class="row g-3"><input type="hidden" name="id">
                <div class="col-md-4"><label class="form-label">Name</label><input class="form-control" name="name">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-3"><label class="form-label">Category</label><select name="category_id"
                        class="form-select">
                        <option value="">Choose</option><?php foreach ($categories as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= esc($c['name']) ?></option><?php endforeach ?>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-2"><label class="form-label">SKU</label><input name="sku" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-1"><label class="form-label">Price</label><input name="price" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-1"><label class="form-label">Stock</label><input name="stock" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-1 d-flex align-items-end"><button class="btn btn-dark">Save</button></div>
                <div class="col-12"><label class="form-label">Description</label><textarea name="description"
                        class="form-control"></textarea></div>
            </form>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table id="dataTable" class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody><?php foreach ($products as $p): ?>
                    <tr data-item='<?= esc(json_encode($p), 'attr') ?>'>
                        <td><?= esc($p['name']) ?></td>
                        <td><?= esc($p['sku']) ?></td>
                        <td><?= esc($p['category_name']) ?></td>
                        <td>₹<?= esc($p['price']) ?></td>
                        <td><?= esc($p['stock']) ?></td>
                        <td><button class="btn btn-sm btn-outline-primary edit">Edit</button> <button
                                class="btn btn-sm btn-outline-danger remove" data-id="<?= $p['id'] ?>">Delete</button></td>
                    </tr><?php endforeach ?>
            </tbody>
        </table>
    </div>
</div><?= $this->endSection() ?><?= $this->section('scripts') ?>
<script>new DataTable('#dataTable'); $('#productForm').on('submit', function (e) { e.preventDefault(); $.post('<?= base_url('admin/products') ?>', $(this).serialize()).done(r => { notify(r.message); location.reload() }).fail(x => showErrors(this, x.responseJSON.errors)) }); $(document).on('click', '.edit', function () { let d = $(this).closest('tr').data('item'); Object.keys(d).forEach(k => $('#productForm [name=' + k + ']').val(d[k])); $('#editor').collapse('show') }); $(document).on('click', '.remove', function () { if (confirm('Soft delete this product?')) $.ajax({ url: BASE + 'admin/products/' + $(this).data('id'), method: 'DELETE' }).done(r => { notify(r.message); location.reload() }) })</script>

<?= $this->endSection() ?>
<?= $this->extend('admin_layout') ?><?= $this->section('content') ?>
<div class="d-flex justify-content-between mb-4">
    <h1>Categories</h1><button class="btn btn-dark" data-bs-toggle="collapse" data-bs-target="#editor">Add
        category</button>
</div>
<div id="editor" class="collapse show">
    <div class="card mb-4">
        <div class="card-body">
            <form id="categoryForm" class="row g-3"><input type="hidden" name="id">
                <div class="col-md-4"><label class="form-label">Name</label><input class="form-control" name="name">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-6"><label class="form-label">Description</label><input class="form-control"
                        name="description">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-md-2 d-flex align-items-end"><button class="btn btn-dark w-100">Save</button></div>
            </form>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table id="dataTable" class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody><?php foreach ($categories as $c): ?>
                    <tr data-item='<?= esc(json_encode($c), 'attr') ?>'>
                        <td><?= esc($c['name']) ?></td>
                        <td><?= esc($c['slug']) ?></td>
                        <td><?= esc($c['description']) ?></td>
                        <td><button class="btn btn-sm btn-outline-primary edit">Edit</button> <button
                                class="btn btn-sm btn-outline-danger remove" data-id="<?= $c['id'] ?>">Delete</button></td>
                    </tr><?php endforeach ?>
            </tbody>
        </table>
    </div>
</div><?= $this->endSection() ?><?= $this->section('scripts') ?>
<script>const table = new DataTable('#dataTable'); $('#categoryForm').on('submit', function (e) { e.preventDefault(); $.post('<?= base_url('admin/categories') ?>', $(this).serialize()).done(r => { notify(r.message); location.reload() }).fail(x => showErrors(this, x.responseJSON.errors)) }); $(document).on('click', '.edit', function () { let d = $(this).closest('tr').data('item'); Object.keys(d).forEach(k => $('#categoryForm [name=' + k + ']').val(d[k])); $('#editor').collapse('show') }); $(document).on('click', '.remove', function () { if (confirm('Soft delete this category?')) $.ajax({ url: BASE + 'admin/categories/' + $(this).data('id'), method: 'DELETE' }).done(r => { notify(r.message); location.reload() }) })</script>

<?= $this->endSection() ?>
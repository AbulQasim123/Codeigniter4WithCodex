<?= $this->extend('layout') ?><?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-primary">
            <div class="card-body p-4"><span class="badge text-bg-primary">One-time setup</span>
                <h2 class="mt-2">Create store admin</h2>
                <form method="post" action="<?= base_url('admin/register') ?>"><label
                        class="form-label mt-3">Name</label><input name="name" required class="form-control"><label
                        class="form-label mt-3">Email</label><input name="email" type="email" required
                        class="form-control"><label class="form-label mt-3">Password</label><input name="password"
                        type="password" minlength="8" required class="form-control"><button
                        class="btn btn-primary w-100 mt-4">Create admin account</button></form>
            </div>
        </div>
    </div>
</div><?= $this->endSection() ?>
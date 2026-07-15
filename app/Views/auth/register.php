<?= $this->extend('layout') ?><?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body p-4">
                <h2>Create account</h2>
                <form method="post" action="<?= base_url('register') ?>"><label
                        class="form-label mt-3">Name</label><input name="name" class="form-control">
                    <div class="text-danger small"><?= esc($errors['name'] ?? '') ?></div><label
                        class="form-label mt-3">Email</label><input name="email" type="email" class="form-control">
                    <div class="text-danger small"><?= esc($errors['email'] ?? '') ?></div><label
                        class="form-label mt-3">Password</label><input name="password" type="password"
                        class="form-control">
                    <div class="text-danger small"><?= esc($errors['password'] ?? '') ?></div><button
                        class="btn btn-dark w-100 mt-4">Create account</button>
                </form>
            </div>
        </div>
    </div>
</div><?= $this->endSection() ?>
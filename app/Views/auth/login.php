<?= $this->extend('layout') ?><?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body p-4">
                <h2>Welcome back</h2>
                <form method="post" action="<?= base_url('login') ?>"><label class="form-label mt-3">Email</label><input
                        name="email" type="email" class="form-control">
                    <div class="text-danger small"><?= esc($errors['email'] ?? '') ?></div><label
                        class="form-label mt-3">Password</label><input name="password" type="password"
                        class="form-control">
                    <div class="text-danger small"><?= esc($errors['password'] ?? '') ?></div><button
                        class="btn btn-dark w-100 mt-4">Login</button>
                </form>
                <p class="mt-3 mb-0">New here? <a href="<?= base_url('register') ?>">Create an account</a></p>
            </div>
        </div>
    </div>
</div><?= $this->endSection() ?>
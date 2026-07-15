<?= $this->extend('layout') ?><?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <h1 class="mb-4">My profile</h1>
        <div class="card mb-4">
            <div class="card-body">
                <h5>Account details</h5>
                <form method="post" action="<?= base_url('profile') ?>"><label
                        class="form-label mt-3">Name</label><input class="form-control" name="name"
                        value="<?= esc($profile['name']) ?>">
                    <div class="text-danger small"><?= esc(session('errors.name') ?? '') ?></div><label
                        class="form-label mt-3">Email</label><input class="form-control"
                        value="<?= esc($profile['email']) ?>" disabled><button class="btn btn-dark mt-3">Save
                        profile</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5>Change password</h5>
                <form method="post" action="<?= base_url('profile/password') ?>"><label class="form-label mt-3">Current
                        password</label><input type="password" class="form-control" name="current_password">
                    <div class="text-danger small"><?= esc(session('errors.current_password') ?? '') ?></div><label
                        class="form-label mt-3">New password</label><input type="password" class="form-control"
                        name="password">
                    <div class="text-danger small"><?= esc(session('errors.password') ?? '') ?></div><button
                        class="btn btn-outline-dark mt-3">Update password</button>
                </form>
            </div>
        </div>
    </div>
</div><?= $this->endSection() ?>
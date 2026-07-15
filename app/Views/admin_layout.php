<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin · ShopSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb
        }

        .aside {
            width: 245px;
            min-height: 100vh;
            background: #17213c
        }

        .aside a {
            color: #bfc9df;
            text-decoration: none;
            padding: .7rem 1rem;
            display: block;
            border-radius: .5rem
        }

        .aside a:hover {
            background: #27385f;
            color: #fff
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #7654e8;
            color: #fff;
            display: inline-grid;
            place-items: center;
            font-weight: 700
        }

        .main {
            min-width: 0
        }

        .toast-container {
            z-index: 1090
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <aside class="aside p-3"><a class="text-white fs-4 fw-bold mb-4" href="<?= base_url('admin') ?>">ShopSphere</a>
            <div class="mb-4 small text-uppercase text-secondary">Management</div><a
                href="<?= base_url('admin') ?>">Dashboard</a><a
                href="<?= base_url('admin/categories') ?>">Categories</a><a
                href="<?= base_url('admin/products') ?>">Products</a><a
                href="<?= base_url('admin/orders') ?>">Orders</a><a
                href="<?= base_url('admin/users') ?>">Customers</a><a href="<?= base_url('admin/logs') ?>">Activity
                logs</a>
        </aside>
        <section class="main flex-grow-1">
            <header class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center"><span
                    class="text-muted">Store management</span>
                <div class="dropdown"><button class="btn border-0 dropdown-toggle" data-bs-toggle="dropdown"><span
                            class="avatar me-2"><?= esc(strtoupper(substr(session('admin_user.name'), 0, 1))) ?></span><?= esc(session('admin_user.name')) ?></button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Profile & password</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="post" action="<?= base_url('admin/logout') ?>"><button
                                    class="dropdown-item text-danger">Logout admin</button></form>
                        </li>
                    </ul>
                </div>
            </header>
            <main class="p-4"><?= $this->renderSection('content') ?></main>
        </section>
    </div>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="actionToast" class="toast text-bg-success border-0">
            <div class="d-flex">
                <div class="toast-body"></div><button class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    <script>const BASE = '<?= base_url() ?>'; function notify(m, t = 'success') { const e = document.querySelector('#actionToast'); e.className = 'toast text-bg-' + (t === 'success' ? 'success' : 'danger') + ' border-0'; e.querySelector('.toast-body').textContent = m; bootstrap.Toast.getOrCreateInstance(e).show() } function showErrors(f, e) { Object.entries(e).forEach(([n, m]) => { const x = f.querySelector('[name="' + n + '"]'); if (x) { x.classList.add('is-invalid'); x.parentElement.querySelector('.invalid-feedback').textContent = m } }) }</script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ShopSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f8fb
        }

        .navbar-brand {
            font-weight: 800
        }

        .hero {
            background: linear-gradient(125deg, #182848, #4b6cb7);
            color: #fff;
            border-radius: 1.5rem
        }

        .card {
            border: 0;
            box-shadow: 0 5px 18px #172b4d12
        }

        .price {
            color: #7654e8;
            font-weight: 800
        }

        .product-image {
            height: 190px;
            object-fit: cover;
            background: #e9ecef
        }

        .toast-container {
            z-index: 1090
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container"><a class="navbar-brand" href="<?= base_url('/') ?>">ShopSphere</a>
            <div class="navbar-nav ms-auto align-items-lg-center"><?php if (!session('admin_user')): ?><a
                        class="nav-link" href="<?= base_url('/') ?>">Shop</a><a class="nav-link"
                        href="<?= base_url('cart') ?>">Cart <span id="cartCount"
                            class="badge text-bg-light text-dark">0</span></a><?php endif ?><?php if (session('user')): ?><a
                        class="nav-link text-info" href="<?= base_url('profile') ?>">Hi,
                        <?= esc(session('user.name')) ?></a>
                    <form method="post" action="<?= base_url('logout') ?>"><button
                            class="btn btn-sm btn-outline-light">Logout</button></form>
                <?php elseif (!session('admin_user')): ?><a class="btn btn-sm btn-outline-light ms-2"
                        href="<?= base_url('login') ?>">Login</a><?php endif ?>
            </div>
        </div>
    </nav>
    <main class="container py-4"><?= $this->renderSection('content') ?></main>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="siteToast" class="toast border-0">
            <div class="d-flex">
                <div class="toast-body"></div><button class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>function notify(m, ok = true) { let e = $('#siteToast').removeClass('text-bg-success text-bg-danger').addClass(ok ? 'text-bg-success' : 'text-bg-danger'); e.find('.toast-body').text(m); bootstrap.Toast.getOrCreateInstance(e[0]).show() } $('form[action*="cart/add"]').on('submit', function (e) { e.preventDefault(); $.post(this.action, $(this).serialize()).done(r => { notify(r.message); $('#cartCount').text(r.count) }).fail(x => notify(x.responseJSON.message, false)) })</script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>
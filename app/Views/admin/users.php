<?= $this->extend('admin_layout') ?><?= $this->section('content') ?>
<h1 class="mb-4">Customers</h1>
<div class="card">
    <div class="card-body">
        <table id="dataTable" class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody><?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= esc($u['name']) ?></td>
                        <td><?= esc($u['email']) ?></td>
                        <td><?= esc($u['created_at']) ?></td>
                        <td class="state">

                            <?= $u['is_blocked'] ? '<span class="badge text-bg-danger">Blocked</span>' : '<span class="badge text-bg-success">Active</span>' ?>
                        </td>
                        <td><button data-id="<?= $u['id'] ?>"
                                class="btn btn-sm <?= $u['is_blocked'] ? 'btn-outline-success' : 'btn-outline-danger' ?> block"><?= $u['is_blocked'] ? 'Unblock' : 'Block' ?></button>
                        </td>
                    </tr><?php endforeach ?>
            </tbody>
        </table>
    </div>
</div><?= $this->endSection() ?><?= $this->section('scripts') ?>

<script>new DataTable('#dataTable'); $(document).on('click', '.block', function () { const b = $(this); $.post(BASE + 'admin/users/' + b.data('id') + '/block').done(r => { notify(r.message); b.text(r.blocked ? 'Unblock' : 'Block').toggleClass('btn-outline-success', r.blocked).toggleClass('btn-outline-danger', !r.blocked); b.closest('tr').find('.state').html(r.blocked ? '<span class="badge text-bg-danger">Blocked</span>' : '<span class="badge text-bg-success">Active</span>') }) })</script>
<?= $this->endSection() ?>
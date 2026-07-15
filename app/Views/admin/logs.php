<?= $this->extend('admin_layout') ?><?= $this->section('content') ?>
<h1 class="mb-4">Activity logs</h1>
<div class="card">
    <div class="card-body">
        <table id="dataTable" class="table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>User</th>
                    <th>Event</th>
                    <th>Description</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody><?php foreach ($logs as $l): ?>
                    <tr>
                        <td><?= esc($l['created_at']) ?></td>
                        <td><?= esc($l['name'] ?? 'Guest') ?></td>
                        <td><span class="badge text-bg-light border"><?= esc($l['event']) ?></span></td>
                        <td><?= esc($l['description']) ?></td>
                        <td><?= esc($l['ip_address']) ?></td>
                    </tr><?php endforeach ?>
            </tbody>
        </table>
    </div>
</div><?= $this->endSection() ?><?= $this->section('scripts') ?>
<script>new DataTable('#dataTable', { order: [[0, 'desc']] });</script><?= $this->endSection() ?>
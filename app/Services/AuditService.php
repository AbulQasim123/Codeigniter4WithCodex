<?php
namespace App\Services;
use App\Models\ActivityLogModel;
class AuditService
{
    public function log(string $event, string $description, ?int $userId = null): void
    {
        (new ActivityLogModel())->insert(['user_id' => $userId ?? session('user.id'), 'event' => $event, 'description' => $description, 'ip_address' => service('request')->getIPAddress(), 'created_at' => date('Y-m-d H:i:s')]);
    }
}

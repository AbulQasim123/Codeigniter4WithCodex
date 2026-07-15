<?php
namespace App\Models;
class ActivityLogModel extends BaseModel
{
    protected $table = 'activity_logs';
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'event', 'description', 'ip_address', 'created_at'];
}

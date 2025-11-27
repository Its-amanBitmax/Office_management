<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

trait Loggable
{
    protected function logActivity($action, $model = null, $modelId = null, $description = null)
    {
        $user = auth('admin')->user() ?? auth('employee')->user();

        if (!$user) {
            return;
        }

        $userType = auth('admin')->check() ? 'admin' : 'employee';

        ActivityLog::create([
            'user_id' => $user->id,
            'user_type' => $userType,
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'description' => $description ?: ucfirst($action) . ' ' . ($model ?: 'item'),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AttendanceLog extends Model
{
    use LogsActivity;
    protected $table = 'attendance_logs';
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['sn', 'user_id', 'attendance_date', 'attendance_time', 'extra', 'punch_type', 'status_1', 'status_2'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "AttendanceLog {$eventName} Details");
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class GeneralSetting extends Model
{
    use LogsActivity;
    protected $guarded = ['id'];
    protected $casts = [
        'subscription_price' => 'decimal:2',
    ];

    public static function settings()
    {
        return self::firstOrCreate(['id' => 1]);
    }

        public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'status']) // User fields to track
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "User {$eventName} Employee details");
    }
}

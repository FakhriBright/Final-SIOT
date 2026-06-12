<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'nama_device',
        'serial_number',
        'mqtt_client_id',
        'topic_prefix',
        'status',
        'last_seen',
    ];

    protected $casts = [
        'last_seen' => 'datetime',
    ];

    /**
     * Get the logs for this device.
     */
    public function sensorLogs()
    {
        return $this->hasMany(SensorLog::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'topic',
        'type',
        'value',
        'status',
    ];

    /**
     * Get the device that owns the sensor log.
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}

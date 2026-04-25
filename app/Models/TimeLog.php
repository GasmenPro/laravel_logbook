<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'time_in',
        'time_out',
        'log_date',
        'notes',
    ];

    protected $casts = [
        'time_in' => 'datetime',
        'time_out' => 'datetime',
        'log_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getWorkDurationAttribute()
    {
        if ($this->time_in && $this->time_out) {
            $diff = $this->time_in->diff($this->time_out);
            return $diff->format('%H hours %I minutes');
        }
        return 'Still working';
    }
}
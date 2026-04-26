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
            $diff = $this->time_in->diff($this->time_out, true);
            $hours = $diff->h;
            $minutes = $diff->i;
            $seconds = $diff->s;
            
            if ($hours > 0) {
                return $hours . ' hours ' . $minutes . ' minutes';
            } elseif ($minutes > 0) {
                return $minutes . ' minutes ' . $seconds . ' seconds';
            } else {
                return $seconds . ' seconds';
            }
        }
        
        // No time out - check if it's from a previous day
        if ($this->time_in && !$this->time_out) {
            $logDate = $this->log_date;
            $today = \Carbon\Carbon::today();
            
            if ($logDate->lt($today)) {
                return 'No time out (Missed)';
            }
            return 'Still working';
        }
        
        return '-';
    }
}
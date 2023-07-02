<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceCorrectRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'reason',
        'start_time',
        'end_time',
        'rest_start_time',
        'rest_end_time',
        'attendance_id'
    ];

    public function attendance(){
        $this->belongsTo(Attendance::class);
    }
}

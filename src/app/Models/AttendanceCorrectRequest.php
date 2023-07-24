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
        'attendance_id'
    ];

    public function attendance(){
        return $this->belongsTo(Attendance::class);
    }

    public function restRequests(){
        return $this->hasMany(RestRequest::class);
    }
}

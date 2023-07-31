<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'attendance_correct_request_id',
        'rest_id'
    ];

    public function attendance(){
        return $this->belongsTo(Rest::class);
    }

    public function attendanceCorrectRequest(){
        return $this->belongsTo(AttendanceCorrectRequest::class);
    }
}

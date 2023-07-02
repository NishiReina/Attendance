<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function rests(){
        return $this->hasMany(Rest::class);
    }

    public function attendanceCorrectRequest(){
        return $this->hasOne(AttendanceCorrectRequest::class);
    }

    public static function attendanceStatus(){
        $today = Carbon::now();
        $attendance = Attendance::where('user_id',Auth::id())->where('date',$today->isoFormat("YYYY-M-D"))->first();

        if(isset($attendance) && is_null($attendance->end_time)){
            $rest = $attendance->rests()->latest()->first();
            if (empty($rest)){
                return [
                    "status" => "rest",
                ];
            }else if(is_null($rest->end_time)){
                return [
                    "status" => "rest",
                    "key" => $rest->id
                ];
            }else{
                return [
                    "status" => "at_work",
                    "key" => $attendance->id
                ];
            }
        }else if(isset($attendance->end_time)){
            return [
                "status" => "finished_work"
            ];
        }else{
            return [
                "status" => "non_work"
            ];
        }

        return [
            "status" => "non_work"
        ];

    }
}

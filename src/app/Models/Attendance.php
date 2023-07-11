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
                    "status" => "at_work",
                    "key" => $attendance->id
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

    public static function getMonthAttendanceList($user_id, $ymd){

        $month_attendances = array();
        for($i = 1; $i <= $ymd->daysInMonth; $i++){
            $date = Carbon::createMidnightDate($ymd->year, $ymd->month, $i);
            $attendance = Attendance::with('user')->where('user_id',$user_id)->whereDate('created_at', $date)->first();
            if($attendance){
                $month_attendances[$i] = $attendance;
            }else{
                $month_attendances[$i] = "";
            }
        }

        return $month_attendances;
    }

}

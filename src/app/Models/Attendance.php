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

    public function attendanceCorrectRequests(){
        return $this->hasMany(AttendanceCorrectRequest::class);
    }

    public function isPendingRequests(){
        $attendanceCorrectRequests = $this->hasMany(AttendanceCorrectRequest::class)->get();

        $isPendingRequests = $attendanceCorrectRequests->contains(function($request) {
            return $request->status === 0;
        });

        return $isPendingRequests;
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
            if(isset($attendance) && isset($attendance->end_time)){
                $month_attendances[$i] = $attendance;
            }else{
                $month_attendances[$i] = "";
            }
        }

        return $month_attendances;
    }

    public function sumWorkingHours(){
        $rest_time = $this->sumRestTime();
        $start = new Carbon($this->start_time);
        $end = new Carbon($this->end_time);
        $sum = $start->diffInSeconds($end);
        $sum = $sum - $rest_time;
        return $sum;
        
    }

    public function sumRestTime(){
        $rests = $this->rests;
        $sum = 0;
        if(isset($rests)){
            foreach($rests as $rest){
                $start = new Carbon($rest->start_time);
                $end = new Carbon($rest->end_time);
                $diff = $start->diffInSeconds($end);
                $sum += $diff;
            }
        }else{
            return 0;
        }
        return $sum;
    }

    public static function formatTime($total_seconds){
        $hours = floor($total_seconds / 3600);
        $minutes = floor(($total_seconds % 3600) / 60);
        $seconds = $total_seconds % 60;
        $result = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
        return $result;
    }

}

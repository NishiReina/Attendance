<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StampCorrectionRequest;
use App\Models\Attendance;
use App\Models\AttendanceCorrectRequest;
use App\Models\Rest;
use App\Models\RestRequest;

class AttendanceController extends Controller
{
    //
    public function top(){
        $today = Carbon::now();
        $date = $today->isoFormat("YYYY年M月D日(ddd)");
        $time = $today->format("H:i");

        $status = Attendance::attendanceStatus();
        // dd($status["status"]);
        return view('attendance', compact('date', 'time', 'status'));
    }

    public function start(){
        $now = Carbon::now();
        Attendance::create([
            "date" => $now->isoFormat("Y-M-D"),
            "start_time" => $now,
            "user_id" => Auth::id()
        ]);

        return redirect("/attendance");
    }

    public function end(Attendance $attendance){

        $now = Carbon::now();
        $attendance->update([
            "end_time" => $now
        ]);

        return redirect("/attendance");
    }

    public function startRest($id, Request $request){

        $now = Carbon::now();
        Rest::create([
            "start_time" => $now,
            "attendance_id" => $id
        ]);

        return redirect("/attendance");
    }

    public function endRest(Rest $rest){

        $now = Carbon::now();
        $rest->update([
            "end_time" => $now
        ]);

        return redirect("/attendance");
    }

    public function getAttendancesList(Request $request){

        if(isset($request->month)){
            $ymd = Carbon::createMidnightDate($request->month, null, 1);
        }else{
            $ymd = Carbon::now()->startOfMonth();
        }
        $days = $ymd->daysInMonth;
        $attendances = Attendance::getMonthAttendanceList(Auth::id(), $ymd);
        
        return view('attendance_list', compact('ymd', 'attendances'));
    }

    public function getAttendance(Attendance $attendance){
        return view('detail', compact('attendance'));
    }

    public function StampCorrection(Attendance $attendance, StampCorrectionRequest $request){
       
        // $validated = $request->validated();
        // dd($request->all());
        
        $str_start_time = $attendance->date . ' ' . $request->start_time;
        $start_time = new Carbon($str_start_time);
        $str_end_time = $attendance->date . ' ' . $request->end_time;
        $end_time = new Carbon($str_end_time);

        $attendance_correct_request = AttendanceCorrectRequest::create([
            'start_time' => $start_time,
            'end_time' => $end_time,
            'reason' => $request->reason,
            'attendance_id' => $attendance->id
        ]);

        for($i = 0; $i < count($attendance->rests); $i++){

            // リクエスト内の各休憩時間の値にアクセスするためのキーの文字列を作成
            $tmp_start = 'rest_start_time' . ($i+1);
            $tmp_end = 'rest_end_time' . ($i+1);

            // 文字列からDatetime型作成
            $str_rest_start_time = $attendance->date . ' ' . $request->$tmp_start;
            $str_rest_end_time = $attendance->date . ' ' . $request->$tmp_end;
            $rest_start_time = new Carbon($str_rest_start_time);
            $rest_end_time = new Carbon($str_rest_end_time);

            
            RestRequest::create([
                'start_time' => $rest_start_time,
                'end_time' => $rest_end_time,
                'rest_id' => $attendance->rests[$i]->id,
                'attendance_correct_request_id' => $attendance_correct_request->id
            ]);
        }

        return redirect()->route('attendance.request', ['attendance_correct_request' => $attendance_correct_request->id]);
    }

    public function getStampCorrectRequest(AttendanceCorrectRequest $attendance_correct_request){
        return view('stamp_correction_request', compact('attendance_correct_request'));
    }

}

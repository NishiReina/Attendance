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

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;


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
}

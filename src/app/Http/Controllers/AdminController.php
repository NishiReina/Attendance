<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\User;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function getStaffList(){
        $users = User::all();
        return view('admin.staff', compact('users'));
    }

    public function getDayAttendance(Request $request){
        
        if(isset($request->day)){
            $ymd = Carbon::createMidnightDate($request->day, null, null);
        }else{
            $ymd = Carbon::now();
        }
        $attendances = Attendance::whereDate('created_at', $ymd)->get();

        return view('admin.attendance_list', compact('ymd', 'attendances'));
    }

    public function getAttendancesList($id, Request $request){

        if(isset($request->month)){
            $ymd = Carbon::createMidnightDate($request->month, null, 1);
        }else{
            $ymd = Carbon::now()->startOfMonth();
        }

        $attendances = Attendance::getMonthAttendanceList($id, $ymd);
        
        return view('attendance_list', compact('id', 'ymd', 'attendances'));
    }
}

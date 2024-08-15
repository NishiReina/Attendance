<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\User;
use App\Library\CsvFunc;

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
        // dd(gettype($attendances));
        $staff_name = User::find($id)->name;

        if(isset($request->csv) && $request->csv){
            $header = ['日付', '出勤', '退勤', '休憩'];
            CsvFunc::putCsv($header,  $attendances);
        }
        
        return view('attendance_list', compact('id', 'ymd', 'attendances', 'staff_name'));
    }

    public function putCsvAttendancesList($staff_id, $ymd, Request $request){

        // if(isset($request->month)){
        //     $ymd = Carbon::createMidnightDate($request->month, null, 1);
        // }else{
        //     $ymd = Carbon::now()->startOfMonth();
        // }

        $formatted_ymd = Carbon::createMidnightDate($ymd, null, 1);

        Attendance::putCsvMonthAttendanceList($staff_id, $formatted_ymd);
        return;
    }
}

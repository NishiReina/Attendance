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

class StampCorrectionController extends Controller
{
    /**
     * 管理者：勤怠修正
     * 一般ユーザ：勤怠修正の申請
     */
    public function StampCorrection(Attendance $attendance, StampCorrectionRequest $request){
       
        // $validated = $request->validated();
        // dd($request->all());
        $str_start_time = $attendance->date . ' ' . $request->start_time;
        $start_time = new Carbon($str_start_time);
        $str_end_time = $attendance->date . ' ' . $request->end_time;
        $end_time = new Carbon($str_end_time);

        if(Auth::guard('admin')->check()){
            $attendance->update([
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);
    
            for($i = 0; $i < count($attendance->rests); $i++ ){
                // リクエスト内の各休憩時間の値にアクセスするためのキーの文字列を作成
                $tmp_start = 'rest_start_time' . ($i+1);
                $tmp_end = 'rest_end_time' . ($i+1);
    
                // 文字列からDatetime型作成
                $str_rest_start_time = $attendance->date . ' ' . $request->$tmp_start;
                $str_rest_end_time = $attendance->date . ' ' . $request->$tmp_end;
                $rest_start_time = new Carbon($str_rest_start_time);
                $rest_end_time = new Carbon($str_rest_end_time);

                $attendance->rests[$i]->update([
                    'start_time' => $rest_start_time,
                    'end_time' => $rest_end_time,
                ]);
            }
            return redirect()->route('attendance.detail', $attendance->id);
        
        }else{
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
                    // 'rest_id' => $attendance->rests[$i]->id,
                    'attendance_correct_request_id' => $attendance_correct_request->id
                ]);
            }
            return redirect()->route('attendance.request', ['attendance_correct_request' => $attendance_correct_request->id]);
        }

    }

    public function getRequest(AttendanceCorrectRequest $attendance_correct_request){
        return view('request_form', compact('attendance_correct_request'));
    }

    public function getRequestList(Request $request){
        
        if(Auth::guard('admin')->check()){
            if($request->status == 'true'){
                $requests = AttendanceCorrectRequest::where('status', 1)->get();
            }else{
                $requests = AttendanceCorrectRequest::where('status', 0)->get();
            }
        }else if(Auth::guard('web')->check()){
            $requests = array();
            if($request->status == 'true'){
                $tmp_lists = AttendanceCorrectRequest::where('status', 1)->get();
                foreach($tmp_lists as $tmp_list){
                    if($tmp_list->attendance->user->id == Auth::id()){
                        array_push($requests, $tmp_list);
                    }
                }
            }else{
                $tmp_lists = AttendanceCorrectRequest::where('status', 0)->get();
                foreach($tmp_lists as $tmp_list){
                    if($tmp_list->attendance->user->id == Auth::id()){
                        array_push($requests, $tmp_list);
                    }
                }
            }
        }
        $status = $request->status;

        return view('request_list', compact('requests', 'status'));
    }

    public function approveRequest(AttendanceCorrectRequest $attendance_correct_request){

        $attendance_correct_request->update([
            'status' => 1
        ]);

        $attendance_correct_request->attendance->update([
            'start_time' => $attendance_correct_request->start_time,
            'end_time' => $attendance_correct_request->end_time,
        ]);

        for($i = 0; $i < count($attendance_correct_request->restRequests); $i++ ){
            $attendance_correct_request->attendance->rests[$i]->update([
                'start_time' => $attendance_correct_request->restRequests[$i]->start_time,
                'end_time' => $attendance_correct_request->restRequests[$i]->end_time,
            ]);
        }

        return redirect()->route('attendance.detail', $attendance_correct_request->attendance->id);
    }

}

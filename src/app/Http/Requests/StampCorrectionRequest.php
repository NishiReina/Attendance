<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class StampCorrectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // ここできてそう
    public function rules(Request $request)
    {
        $rules = [
            'start_time' => 'required',
            'end_time' => 'required',
            'reason' => 'required',
        ];

        for ($i = 1; $i <= count($request->attendance->rests); $i++){
            $start =  'rest_start_time' . $i;
            $end = 'rest_end_time' . $i;
            $rules[$start] = 'required_with:' . $end . '| lte:' . $end;
            $rules[$end] = 'required_with:'. $start . '| gte:' . $start;

            if($i != 1){
                $rules[$start] .=  '| gte:' .'rest_end_time' . ($i-1);
            }
            if($i != count($request->attendance->rests)){
                $rules[$end] .= '| lte:' . 'rest_start_time' . ($i+1);
            }
        }
        return $rules;
    }

    public function messages(){

        $messages = [
            'start_time.required' => '出勤時間を入力してください',
            'end_time.required' => '退勤時間を入力してください',
            'reason.required' => '備考を記入してください',
        ];
        return [
            'start_time.required' => '出勤時間を入力してください',
            'end_time.required' => '退勤時間を入力してください',
            'rest_start_time.required_with' => '休憩開始時間を入力してください',
            'rest_end_time.required_with' => '休憩終了時間を入力してください',
            'reason.required' => '備考を記入してください',
        ];
        // for ($i = 1; $i <= count($request->attendance->rests); $i++){
        //     $start =  'rest_start_time' . $i . '.required_with';
        //     $end =  'rest_end_time' . $i . '.required_with';
        //     $messages[$start] = '休憩開始時間を入力してください';
        //     $messages[$end] = '休憩終了時間を入力してください';
        // }

        return $messages;
    }
}

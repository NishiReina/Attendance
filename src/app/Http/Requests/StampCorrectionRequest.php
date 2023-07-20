<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

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
    // public function rules()
    // {
    //     $rules = [
    //         'start_time' => 'required | required_with:end_time',
    //         'end_time' => [
    //             'required',
    //             'required_with:start_time',
    //             function($attribute, $value, $fail){
    //                 $start_datetime = Carbon::parse($this->date.' '.$this->start_time);
    //                 $end_datetime = Carbon::parse($this->date.' '.$this->end_time);
    //                 if ($end_datetime <= $start_datetime) {
    //                 //   $fail('退勤時間は出勤時間より後にしてください。');
    //                 }
    //             },
    //         ],
    //         'reason' => 'required',
    //     ];
    //     // return $rules;
    //     // dd($rules);

    //     for ($i = 1; $i <= count($this->attendance->rests); $i++){
    //         $rest_start =  'rest_start_time' . $i;
    //         $rest_end = 'rest_end_time' . $i;

    //         $rules[$rest_start] = [
    //             'required_with:' . $rest_end, 
    //             function($attribute, $value, $fail){
    //                 $rest_start_datetime = Carbon::parse($this->date.' '.$this->rest_start_time);
    //                 $rest_end_datetime = Carbon::parse($this->date.' '.$this->rest_end_time);
    //                 if ($rest_end_datetime <= $rest_start_datetime) {
    //                     $fail('休憩終了時間は休憩開始時間より後にしてください。');
    //                 }
    //             },
    //         ];

    //         $rules[$rest_end] = 'required_with:' . $rest_start;

            
    //         if($i != 1){
    //             $pre_end = 'rest_end_time' . ($i-1);
    //             array_push($rules[$rest_start],function($attribute, $value, $fail) use ($pre_end){
    //                 $rest_start_datetime = Carbon::parse($this->date.' '.$this->rest_start_time);
    //                 $pre_rest_end_datetime = Carbon::parse($this->date.' '.$this->$pre_end);
    //                 if ($pre_rest_end_datetime > $rest_start_datetime) {
    //                     $fail('休憩時間が被っています。');
    //                 }
    //             }, );
    //         }
    //     }

    //     return $rules;
    // }

    // public function withValidator(\Validator $validator) : void
    // {
    //     if ($validator->fails()) {
    //         return;
    //     } // bailと同じ効果

    //     $validator->after(function ($validator) {
    //         $inputData = $this->all();
    //         if (($inputData['amount'] - $inputData['prepayment'] - $inputData['point']) < 0)
    //         {
    //             $validator->errors()->add('error', '合計金額が、事前払い、または利用ポイントより多くなるようにしてください。');
    //         }
    //     });
    // }

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

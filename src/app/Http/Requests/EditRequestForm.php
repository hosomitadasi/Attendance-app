<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRequestForm extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'new_start_time' => ['required', 'date_format:H:i'],
            'new_end_time' => ['required', 'date_format:H:i'],
            'new_rests' => ['nullable', 'array'],
            'new_rests.*.start_time' => ['required_with:new_rests.*.end_time', 'date_format:H:i'],
            'new_rests.*.end_time' => ['required_with:new_rests.*.start_time', 'date_format:H:i'],
            'note' => ['required', 'string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $start = $this->input('new_start_time');
            $end = $this->input('new_end_time');
            $rests = $this->input('new_rests', []);

            // ① 出勤が退勤より遅い場合
            if ($start && $end && $start > $end) {
                $validator->errors()->add('new_start_time', '出勤時間もしくは退勤時間が不適切な値です');
            }

            // ② 休憩が勤務時間外
            foreach ($rests as $index => $rest) {
                $restStart = $rest['start_time'] ?? null;
                $restEnd = $rest['end_time'] ?? null;

                if ($restStart && ($restStart < $start || $restStart > $end)) {
                    $validator->errors()->add("new_rests.$index.start_time", '休憩時間が勤務時間外です');
                }

                if ($restEnd && ($restEnd < $start || $restEnd > $end)) {
                    $validator->errors()->add("new_rests.$index.end_time", '休憩時間が勤務時間外です');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'new_start_time.required' => '出勤時間を入力してください',
            'new_end_time.required' => '退勤時間を入力してください',
            'new_start_time.date_format' => '出勤時間の形式が正しくありません（例：09:00）',
            'new_end_time.date_format' => '退勤時間の形式が正しくありません（例：18:00）',

            'new_rests.*.start_time.date_format' => '休憩開始時間の形式が正しくありません（例：12:00）',
            'new_rests.*.end_time.date_format' => '休憩終了時間の形式が正しくありません（例：13:00）',

            'note.required' => '備考を記入してください',
        ];
    }
}

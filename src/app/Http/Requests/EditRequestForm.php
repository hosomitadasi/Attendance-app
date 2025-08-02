<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRequestForm extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'new_start_time' => 'nullable|date_format:H:i',
            'new_end_time' => 'nullable|date_format:H:i|after:new_start_time',
            'new_rests' => 'nullable|array',
            'new_rests.*.start_time' => 'nullable|date_format:H:i',
            'new_rests.*.end_time' => 'nullable|date_format:H:i|after:new_rests.*.start_time',
            'note' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'note.required' => '備考を記入してください。',
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
}

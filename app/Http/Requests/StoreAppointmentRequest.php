<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "condition" => 'required|alpha|max:255',
            "medical_treatment" => 'required|alpha_num|max:255',
            'next_examination_date' => 'date|after:today',
            'is_paid' => 'required',
            'note' => 'alpha_num|max:255',
            'rate' => 'numeric',
            'total_sessions' => 'numeric|max_digits:2',
            'total_amount' => 'numeric',

        ];
    }
}

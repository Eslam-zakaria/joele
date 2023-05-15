<?php

namespace Modules\Review\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
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
    public function rules()
    {
        return [
            'branch_id' => ['required', 'numeric', 'exists:branches,id'],
            'doctor_id' => ['required', 'numeric', 'exists:doctors,id'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:10', 'regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
            'message' => ['required'],
            'questions.*' => ['required', 'numeric', 'in:1,2,3'],
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => __('messages.phone_regex_message')
        ];
    }
}

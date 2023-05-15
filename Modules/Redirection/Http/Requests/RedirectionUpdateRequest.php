<?php

namespace Modules\Redirection\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class RedirectionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*if ( ! Gate::allows('edit review question') )
            return false;*/

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
            'from' => ['required', 'max:255'],
            'to' => ['required', 'max:255'],
            'code' => ['required', 'numeric'],
        ];
    }
}

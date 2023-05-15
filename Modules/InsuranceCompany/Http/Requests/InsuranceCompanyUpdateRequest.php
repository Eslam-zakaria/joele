<?php

namespace Modules\InsuranceCompany\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class InsuranceCompanyUpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*if ( ! Gate::allows('edit insurance company') )
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
            'category_id' => ['required', 'exists:categories,id'],
            'ar.question' => ['required', 'string', 'max:255'],
            'en.question' => ['required', 'string', 'max:255'],
        ];
    }

}

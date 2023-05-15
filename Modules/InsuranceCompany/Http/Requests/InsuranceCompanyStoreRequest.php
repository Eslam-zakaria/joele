<?php

namespace Modules\InsuranceCompany\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class InsuranceCompanyStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( ! Gate::allows('create insurance company') )
            return false;

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'ar.title' => ['required', 'string', 'max:255'],
            'en.title' => ['required', 'string', 'max:255'],
            #'ar.content' => ['required', 'string'],
            #'en.content' => ['required', 'string'],
        ];
    }

}

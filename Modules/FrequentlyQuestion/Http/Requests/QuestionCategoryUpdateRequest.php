<?php

namespace Modules\FrequentlyQuestion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;

class QuestionCategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*if ( ! Gate::allows('create insurance company') )
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
            'language' => ['required', 'in:1,2,3'], # 1 => English | 2 => Arabic | 3 => Both
            'en.name' => ['required_if:language,1,3', 'max:255'],
            'ar.name' => ['required_if:language,2,3', 'max:255'],
        ];
    }

}

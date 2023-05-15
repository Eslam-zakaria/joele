<?php

namespace Modules\FrequentlyQuestion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\FrequentlyQuestion\Models\FrequentlyQuestion;

class FrequentlyQuestionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( ! Gate::allows('create frequently question') )
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
            'language' => ['required', 'in:1,2,3'], # 1 => English | 2 => Arabic | 3 => Both
            'category_id' => ['required', 'exists:question_categories,id'],
            'en.question' => ['required_if:language,1,3', 'required_with:en.answer', 'max:255'],
            'ar.question' => ['required_if:language,2,3', 'required_with:ar.answer', 'max:255'],
            'en.answer' => ['required_if:language,1,3', 'required_with:en.question'],
            'ar.answer' => ['required_if:language,2,3', 'required_with:ar.question'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'en.question.required_if' => 'The English question field is required.',
            'ar.question.required_if' => 'The Arabic question field is required.',
            'en.answer.required_if' => 'The English answer field is required.',
            'ar.answer.required_if' => 'The Arabic answer field is required.',
        ];
    }
}

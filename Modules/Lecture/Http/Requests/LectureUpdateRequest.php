<?php

namespace Modules\Lecture\Http\Requests;

use App\Enums\GeneralEnums;
use Illuminate\Foundation\Http\FormRequest;

class LectureUpdateRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'mimes:' . GeneralEnums::mimesType],
            'en.title' => ['required', 'max:255'],
            'ar.title' => ['required', 'max:255'],
            'link' => ['required', 'url', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

}

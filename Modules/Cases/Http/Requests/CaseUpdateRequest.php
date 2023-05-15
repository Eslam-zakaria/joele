<?php

namespace Modules\Cases\Http\Requests;

use App\Enums\GeneralEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CaseUpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! Gate::allows('edit case'))
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
            'image_before' => ['nullable', 'image', 'mimes:' . GeneralEnums::mimesType],
            'image_after' => ['nullable', 'image', 'mimes:' . GeneralEnums::mimesType],
            'branch_id' => ['required', 'exists:branches,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

}

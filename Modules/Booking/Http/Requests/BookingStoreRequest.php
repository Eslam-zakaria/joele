<?php

namespace Modules\Booking\Http\Requests;


use App\Enums\GeneralEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BookingStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'email' => ['required_if:type,=,2', 'email', 'max:150'],
            'phone' => ['required', 'numeric', 'min:10'],
            'attendance_date' => ['required'],
            'available_time' => ['required'],
            'step_num' => ['required_if:type,=,2','numeric', 'min:1'],
            'payment_type' => ['required_if:step_num,=,2'],
            'type_installment' => ['required_if:payment_type,=,Pay Installment'],
            'type' => ['required','numeric','between:1,2'],
            'offer_id' => ['required_if:type,=,2', 'numeric', 'min:1' ,'exists:offers,id'],
            'doctor_id' => ['required_if:type,=,1', 'numeric', 'min:1' ,'exists:doctors,id'],
            'branch_id' => ['required', 'numeric', 'min:1'],
        ];
    }

}

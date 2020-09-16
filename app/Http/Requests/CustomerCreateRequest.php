<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCreateRequest extends FormRequest
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
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|unique:customers',
            'gender_id'       => 'required',
            'account_id'      => 'required',
            'religion_id'     => 'required',
            'division_id'     => 'required',
            'district_id'     => 'required',
            'upazilla_id'     => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
      return [
        'name.required' => __("Customer name is required"),
        'address.required' => __("Address is required"),
        'phone.required' => __("Contact no. is required"),
        'gender_id.required' => __("Gender is required"),
        'account_id.required' => __("Account is required"),
        'religion_id.required' => __("Religion is required"),
        'division_id.required' => __("Division is required"),
        'district_id.required' => __("District is required"),
        'upazilla_id.required' => __("Upazilla is required"),

        'phone.unique' => __("This contact no. is already used"),
      ];
    }
}

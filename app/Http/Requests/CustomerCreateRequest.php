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
            'gender'       => 'required',
            'account'      => 'required',
            'religion'     => 'required',
            'division'     => 'required',
            'district'     => 'required',
            'upazilla'     => 'required',
            'avatar'          => 'required|image|mimes:jpeg,png,jpg|max:2048'
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
        'gender.required' => __("Gender is required"),
        'account.required' => __("Account is required"),
        'religion.required' => __("Religion is required"),
        'division.required' => __("Division is required"),
        'district.required' => __("District is required"),
        'upazilla.required' => __("Upazilla is required"),

        'phone.unique' => __("This contact no. is already used"),

        'avatar.required' => __("User image is required"),
        'avatar.image' => __("Invalid file"),
        'avatar.mimes' => __("Image must be with in jpeg, png, or jpg format"),
        'avatar.max' => __("Image must be less then 2mb")
      ];
    }
}

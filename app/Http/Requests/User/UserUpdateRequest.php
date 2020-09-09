<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
      'name'          => 'required',
      'father_name'     => 'required',
      'mother_name'     => 'required',
      'phone'           => 'required',
      'gender_id'       => 'required',
      'birth_date'      => 'required',
      'religion_id'     => 'required',
      'nationality'     => 'required',
      'division_id'     => 'required',
      'district_id'     => 'required',
      'upazilla_id'     => 'required',
      'avatar'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
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
      'name.required' => 'Student name is required',
      'father_name.required' => 'Student father name is required',
      'mother_name.required' => 'Student mother name is required',
      'phone.required' => 'Contact no. is required',
      'gender_id.required' => 'Gender is required',
      'birth_date.required' => 'Birth date name is required',
      'religion_id.required' => 'Religion is required',
      'nationality.required' => 'Nationality is required',
      'division_id.required' => 'Division is required',
      'district_id.required' => 'District is required',
      'upazilla_id.required' => 'Upazilla is required',

      'avatar.image' => 'Invalid file',
      'avatar.mimes' => 'Image must be with in jpeg, png, or jpg format',
      'avatar.max' => 'Image must be less then 2mb'
    ];
  }
}

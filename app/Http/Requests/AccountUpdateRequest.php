<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
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
            'name'            => 'required',
            'account_type_id' => 'required',
            'money_format_id' => 'required',
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
      'name.required' => 'Account name is required',
      'account_type_id.required' => 'Account type is required',
      'money_format_id.required' => 'Money format is required',
    ];
  }
}

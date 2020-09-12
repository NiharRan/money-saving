<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'account_id' => 'required',
            'user_id' => 'required',
            'transaction_type_id' => 'required',
            'amount' => 'required|numeric',
            'trans_date' => 'required',
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
      'account_id.required' => __("Account is required"),
      'user_id.required' => __("Account member is required"),
      'transaction_type_id.required' => __("Transaction type is required"),
      'amount.required' => __("Amount is required"),
      'trans_date.required' => __("Transaction date is required"),
      'amount.numeric' => __("Invalid amount"),
    ];
  }
}

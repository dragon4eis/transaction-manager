<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionCreateRequest extends FormRequest
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
            'type' => [
                'required',
                Rule::in([Transaction::CREDIT_TRANSACTION, Transaction::DEBIT_TRANSACTION])
            ],
            'amount' => 'required|numeric|min:1'
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'account_id' => $this['account_id'],
            'email' => $this['account']['user']['email'],
            'name' => $this['account']['user']['name'],
            'balance' => $this['account']['user']['name'],
            'type' => $this['type'],
            'amount' => $this['amount'],
            'type_name' => $this['type'] === Transaction::CREDIT_TRANSACTION ? 'credit' : 'debit',
        ];

    }
}

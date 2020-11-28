<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const CREDIT_TRANSACTION = 1;
    const DEBIT_TRANSACTION = 2;

    protected $fillable = ['amount', 'type', 'account_id'];

    public function account(){
        return $this->belongsTo(UserTransactionAccount::class, 'account_id');
    }

    /**
     * Checks if the transaction is credit
     *
     * @return bool
     */
    public function isCredit():bool
    {
        return $this->type === self::CREDIT_TRANSACTION;
    }

    /**
     * Check if the transaction if debit
     *
     * @return bool
     */
    public function isDebit(): bool
    {
        return $this->type === self::DEBIT_TRANSACTION;
    }

    /**
     * Gets the signed amount
     *
     * @return float
     */
    public function getFormattedAmountAttribute():float
    {
        return ($this->isCredit()?: -1) * $this->getAttribute('amount');
    }
}

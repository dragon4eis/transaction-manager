<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransactionAccount extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'balance' => 'float'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    /**
     * Adds creating to account
     *
     * @param float $credit
     *
     * @return $this
     */
    public function addCredit(float $credit): UserTransactionAccount
    {
        $this->update(['balance' => $this->getAttribute('balance') + $credit]);
        return $this;
    }

    /**
     * Adds depth to account
     *
     * @param float $debit
     *
     * @return $this
     * @throws \Exception
     */
    public function addDebit(float $debit): UserTransactionAccount
    {
        $this->update(['balance' => $this->getAttribute('balance') - $debit]);
        return $this;
    }

    /**
     * Updates account balance
     *
     * @return UserTransactionAccount
     */
    public function refreshBalance(): UserTransactionAccount
    {
        $this->update(['balance' => $this->transactions->sum('formatted_amount')]);
        return $this;
    }

    /**
     * Updates the balance without considering is it a credit or debit
     *
     * @param float $new_amount
     *
     * @return UserTransactionAccount
     * @throws \Exception
     */
    public function updateBalance(float $new_amount): UserTransactionAccount
    {
        $this->update(['balance' => $this->getAttribute('balance') + $new_amount]);
        return $this;
    }

    /**
     * Checks if the debit is more than the current balance
     *
     * @param float $new_amount
     *
     * @return bool
     */
    public function validateBalance(float $new_amount): bool
    {
        return ($this->getAttribute('balance') + $new_amount) >= 0;
    }
}

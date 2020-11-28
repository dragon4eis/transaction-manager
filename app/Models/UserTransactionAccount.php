<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransactionAccount extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function addCredit(float $credit): ?UserTransactionAccount
    {
        $this->update(['balance' => $this->getAttribute('balance') + $credit]);
        return $this;
    }

    public function addDebit(float $debit): ?UserTransactionAccount
    {
        $this->update(['balance' => $this->getAttribute('balance') - $debit]);
        return $this;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const CREDIT_TRANSACTION = 0;
    const DEBIT_TRANSACTION = 2;
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns user's account
     *
     * @note -  move account to own table for supporting multiple user accounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account(){
        return $this->hasOne(UserTransactionAccount::class);
    }

    /**
     * Return all transactions for user
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function transactions(){
        return $this->hasManyThrough(Transaction::class, UserTransactionAccount::class);
    }
}

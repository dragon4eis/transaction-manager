<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserTransactionAccount;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Seeder;

class UserTransactionAccountSeeder extends Seeder
{
    private $limiter;

    public function __construct($maxFakeLists = 5)
    {
        $this->limiter = $maxFakeLists;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            $account = UserTransactionAccount::factory()->make();
            $account->user()->associate($user);
            $account->save();
            $account->transactions()->createMany( Transaction::factory($this->limiter)->make()->toArray());
            $account->refreshBalance();
        }
    }
}

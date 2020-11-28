<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserTransactionAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTransactionAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserTransactionAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'balance' => 0
        ];
    }
}

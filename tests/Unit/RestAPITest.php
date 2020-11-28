<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserTransactionAccount;
use Faker\Factory;
use Tests\TestCase;

class RestAPITest extends TestCase
{
    private $user;

    public function testTransactionListing()
    {
        $response = $this->actingAs($this->user)->get('/transaction');

        $response->assertStatus(200);
    }

    public function testTransactionCreate()
    {
        $newTransaction = [
            'account_id' => UserTransactionAccount::first()->id,
            'type' => Transaction::CREDIT_TRANSACTION,
            'amount' => 1000
        ];

        $response = $this->actingAs($this->user)->postJson('/transaction', $newTransaction);

        $response->assertStatus(201)
            ->assertJsonCount(2)
            ->assertJsonFragment(["message" => "Transaction for 1000 was successfully created"]);
    }

    public function testTransactionUpdate()
    {
        $transaction = Transaction::first();

        $update = [
            'amount' => Factory::create()->randomFloat(2,2)
        ];

        $response = $this->actingAs($this->user)->putJson("/transaction/{$transaction->id}", $update);

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(["message" => "Transaction was successfully updated"]);

    }

    public function testTransactionDelete()
    {
        $transaction = Transaction::first();

        $response = $this->actingAs($this->user)->delete("/transaction/{$transaction->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(["message" => "Transaction was successfully removed"]);

    }

    public function testUsersList()
    {
        $response = $this->actingAs($this->user)->get('/user');

        $response->assertStatus(200);
    }

    public function testAccountList()
    {
        $response = $this->actingAs($this->user)->get('/account');

        $response->assertStatus(200);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::first();
    }
}
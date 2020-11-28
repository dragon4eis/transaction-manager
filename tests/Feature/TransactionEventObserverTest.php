<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\UserTransactionAccount;
use App\Services\TransactionServiceInterface;
use Faker\Factory;
use Tests\TestCase;

final class TransactionEventObserverTest extends TestCase
{
    private TransactionServiceInterface $service;

    public function testNewCredit()
    {
        $account = UserTransactionAccount::first();

        $creditInputs = [
            'account_id' => $account->id,
            'type' => Transaction::CREDIT_TRANSACTION,
            'amount' => Factory::create()->numberBetween(100, 1000)
        ];

        $transaction = $this->service->save($creditInputs);

        $this->assertTrue($transaction->isCredit());

        $this->assertSame(
            $account->balance + $transaction->formatted_amount,
            $account->refreshBalance()->balance
        );
    }

    public function testNewDebit()
    {

        $account = UserTransactionAccount::first();

        $debitInputs = [
            'account_id' => $account->id,
            'type' => Transaction::DEBIT_TRANSACTION,
            'amount' => Factory::create()->numberBetween(100, 1000)
        ];

        $transaction = $this->service->save($debitInputs);

        $this->assertTrue($transaction->isDebit());

        $this->assertSame(
            $account->balance + $transaction->formatted_amount,
            $account->refreshBalance()->balance
        );
    }

    public function testDeleteTransactionEvent()
    {
        $transaction = Transaction::first();
        $account = $transaction->account;

        $this->assertTrue($this->service->remove([$transaction->id]));

        $this->assertSame(
            $account->balance + (- $transaction->formatted_amount),
            $account->refreshBalance()->balance
        );
    }

    public function testUpdateTransactionEvent()
    {
        $newValue = ['amount' => Factory::create()->numberBetween(100, 1000)];
        $transaction = Transaction::first();
        $account = $transaction->account;

        $updatedTransaction = $this->service->update($transaction->id, $newValue);

        $this->assertSame(
            $account->balance + (- $transaction->formatted_amount) + $updatedTransaction->formatted_amount,
            $account->refreshBalance()->balance
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(TransactionServiceInterface::class);

    }
}
<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\UserTransactionAccount;
use App\Services\TransactionServiceInterface;
use Faker\Factory;
use Tests\TestCase;

final class TransactionServiceTest extends TestCase
{
    protected TransactionServiceInterface $service;

    protected array $inputs;

    public function testList()
    {
        $allTransactions = Transaction::all()->count();

        $transactionList = $this->service->list();

        $this->assertSame($allTransactions, count($transactionList));

        $this->assertNotEmpty($transactionList[0]['account']);
    }

    public function testCreate()
    {
        $newTransaction = $this->service->save($this->inputs);

        $this->assertSame($this->inputs['amount'], $newTransaction->amount);

        $this->assertInstanceOf(Transaction::class, $newTransaction);

        $this->assertTrue($newTransaction->isCredit());
    }

    public function testFind()
    {
        $transaction = Transaction::first();
        $findTransaction = $this->service->find($transaction->id);

        $this->assertInstanceOf(Transaction::class, $findTransaction);

        $this->assertSame($transaction->amount, $findTransaction->amount);
    }

    public function testUpdate()
    {
        $transaction = Transaction::first();
        $update['amount'] = Factory::create()->numberBetween(1, 1000);
        $updatedTransaction = $this->service->update($transaction->id, $update);

        $this->assertInstanceOf(Transaction::class, $updatedTransaction);

        $this->assertSame($update['amount'], $updatedTransaction->amount);

        $this->assertNotSame($transaction->amount, $updatedTransaction->amount);
    }

    public function testDelete()
    {
        $transaction = Transaction::first();
        $count = Transaction::all()->count();

        $this->assertTrue($this->service->remove([$transaction->id]));

        $this->assertSame($count - 1, count($this->service->list()));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(TransactionServiceInterface::class);

        $this->inputs = [
            'type' => Transaction::CREDIT_TRANSACTION,
            'amount' => Factory::create()->numberBetween(100, 1000),
            'account_id' => UserTransactionAccount::first()->id
        ];
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionCreateRequest;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    private TransactionServiceInterface $service;

    public function __construct(TransactionServiceInterface $service)
    {

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TransactionResource::collection($this->service->list());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TransactionCreateRequest $request)
    {
        if($transaction = $this->service->save($request->all())){
            return response()->json(
                    [
                        'message' => "Transaction for {$transaction->amount} was successfully created",
                        'resource' => new TransactionResource($transaction)
                    ],
                Response::HTTP_CREATED,
                ['Location' => route('transaction.show', ['mail' => $transaction->id])]);
        } else {
            return response()->json(['message' => 'Transaction was not saved'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return TransactionResource
     */
    public function show($id)
    {
        return new TransactionResource($this->service->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($transaction = $this->service->update($id, $request->all())) {
            return response()->json(['message' => "Transaction was successfully updated", 'resource' => new TransactionResource($transaction)], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Transaction was not updated'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            if ($this->service->remove(Arr::wrap($id))) {
                return response()->json(['message' => "Transaction was successfully removed"], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Mail was not removed'], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            Log::critical($e);
            return response()->json(['message' => 'Mail not removed, try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountResource;
use App\Services\AccountServiceInterface;
use Illuminate\Http\Request;

final class AccountController extends Controller
{
    private AccountServiceInterface $service;

    public function __construct(AccountServiceInterface $service)
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
        return AccountResource::collection($this->service->list());
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return AccountResource
     */
    public function show($id)
    {
        return new AccountResource($this->service->find($id));
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserServiceInterface $service;

    public function __construct(UserServiceInterface $userService)
    {
        $this->service = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection($this->service->list());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param int               $id
     *
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if ($user = $this->service->update($id, $request->all())) {
            return response()->json(['message' => "User {$user->name} was successfully updated", 'resource' => new UserResource($user)], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'User was not updated'], Response::HTTP_BAD_REQUEST);
        }
    }

}

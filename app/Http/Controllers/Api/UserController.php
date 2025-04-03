<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $_userService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = $this->_userService->getUsers();
            return UserResource::collection($users);
        } catch (\Exception $e) {
            throw ($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = $this->_userService->storeUser($request);
            return new UserResource($user);
        } catch (\Exception $e) {
            throw ($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            $user = $this->_userService->getUser($user);
            return new UserResource($user);
        } catch (\Exception $e) {
            throw ($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $user = $this->_userService->updateUser($request, $user);
            return new UserResource($user);
        } catch (\Exception $e) {
            throw ($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

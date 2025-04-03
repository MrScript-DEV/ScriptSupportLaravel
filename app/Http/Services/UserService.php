<?php

namespace App\Http\Services;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\PasswordValidationRules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService {

    use PasswordValidationRules;

    public function getUsers() {
        try {
            return User::all();
        } catch (\Exception $e) {
            throw ($e);
        }
    }

    public function getUser(User $user) {
        try {
            return User::find($user->id);
        } catch (\Exception $e) {
            throw ($e);
        }
    }

    public function storeUser(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|min:2|max:255',
                'last_name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => $this->passwordRules(),
            ]);

            if ($validator->fails()) {
                throw new HttpResponseException(
                    response()->json($validator->errors(), 422)
                );
            }

            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->password);
            $user->save();

            $user->roles()->attach(Role::USER->value);

            return $user;

        } catch (\Exception $e) {
            throw ($e);
        }
    }

    public function updateUser(Request $request, User $user) {

    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Enums\Role;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\PasswordValidationRules;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserStoreController extends BaseController
{
    use PasswordValidationRules;

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|min:2|max:255',
                'last_name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => $this->passwordRules(),
            ]);

            if ($validator->fails()) {
                return $this->sendError(error: __('Erreur de validation :'), errorMessages: $validator->errors()->all(), code: 422);
            }

            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->password),
            ]);

            $user->roles()->attach(Role::USER->value);
            DB::commit();

            return $this->sendResponse(message: __('OK'), result: new UserResource($user));
        } catch (\Exception $e) {
            DB::rollBack();

            if (app()->isLocal()) {
                return $this->sendError(error: __('Une erreur est survenue..'), errorMessages: $e, code: 500);
            }

            return $this->sendError(error: __('Une erreur est survenue..'), code: 500);
        }
    }
}

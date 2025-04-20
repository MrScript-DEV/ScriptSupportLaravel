<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserUpdateController extends BaseController
{
    public function update(Request $request, int $userId): JsonResponse
    {
        try {
            if (!isAdmin() || !isOwner($userId)) {
                return $this->sendError(error: __('Non autorisé'), code: 403);
            }

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|min:2|max:255',
                'last_name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email',
            ]);

            if ($validator->fails()) {
                return $this->sendError(error: __('Erreur de validation :'), errorMessages: $validator->errors()->all(), code: 422);
            }

            $user = User::findOrFail($userId);

            DB::beginTransaction();

            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
            ]);

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

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserDeleteController extends BaseController
{
    public function delete(int $userId): JsonResponse
    {
        try {
            if (!isAdmin()) {
                return $this->sendError(error: __('Non autorisé'), code: 403);
            }

            $user = User::findOrFail($userId);

            DB::beginTransaction();
            $user->delete();
            DB::commit();

            return $this->sendResponse(message: __('OK'));
        } catch (\Exception $e) {
            DB::rollBack();

            if (app()->isLocal()) {
                return $this->sendError(error: __('Une erreur est survenue..'), errorMessages: $e, code: 500);
            }

            return $this->sendError(error: __('Une erreur est survenue..'), code: 500);
        }
    }
}

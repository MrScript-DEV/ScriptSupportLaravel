<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserIndexController extends BaseController
{
    public function index(): JsonResponse
    {
        try {
            if (! isAdmin()) {
                return $this->sendError(error: __('Non autorisé'), code: 403);
            }

            $users = User::all();

            return $this->sendResponse(message: __('OK'), result: UserResource::collection($users));

        } catch (\Exception $e) {
            if (app()->isLocal()) {
                return $this->sendError(error: __('Une erreur est survenue..'), errorMessages: $e, code: 500);
            }

            return $this->sendError(error: __('Une erreur est survenue..'), code: 500);
        }
    }
}

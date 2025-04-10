<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketStoreController extends BaseController
{
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'subject' => 'required|string|min:2|max:255',
            ]);

            if ($validator->fails()) {
                return $this->sendError(error: __('Erreur de validation :'), errorMessages: $validator->errors()->all(), code: 422);
            }

            authenticatedUser()->tickets()->create([
                'subject' => $request->input('subject'),
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

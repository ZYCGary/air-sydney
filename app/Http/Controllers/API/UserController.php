<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        return $this->successResponse(new UserResource($request->user()));
    }

    public function show($userId, Request $request): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);

            return $this->successResponse(new UserResource($user));
        } catch (ModelNotFoundException) {
            return $this->errorResponse(trans('app.not_found', ['attribute' => 'User']), 404);
        }
    }
}

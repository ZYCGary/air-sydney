<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        return $this->successResponse(new UserResource($request->user()));
    }

    public function show($userId): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);

            return $this->successResponse(new UserResource($user));
        } catch (ModelNotFoundException) {
            return $this->errorResponse(trans('app.not_found', ['attribute' => 'User']), 404);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $input = $request->only(['name', 'email', 'photo']);

        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return $this->failResponse($validator->messages(), 422);
        }

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }

        return $this->successResponse(new UserResource($user));
    }

    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }

    public function destroy(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $this->authorize('destroy', $user);

            $user->delete();

            return $this->successResponse(null, 204);
        }catch (AuthorizationException) {
            return $this->errorResponse('Forbidden', 403);
        }catch (Exception) {
            return $this->errorResponse('Server Error');
        }
    }
}

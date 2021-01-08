<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\PasswordValidationRules;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use PasswordValidationRules;

    public function register(Request $request): UserResource|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('invalid_input', trans('validation.custom.invalid_input'), $validator->messages());
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->save();
        $user->sendEmailVerificationNotification();

        return $this->successResponse('register_success', trans('auth.success.register'), new UserResource($user));
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('invalid_input', trans('validation.custom.invalid_input'), $validator->messages());
        }

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->errorResponse('login_fail', trans('auth.fail.login'), trans('auth.failed'));
        }

        $user = User::whereEmail($request->input('email'))->firstOrFail();

        if (!Hash::check($request->input('password'), $user->password)) {
            return $this->errorResponse('login_fail', trans('auth.fail.login'), trans('auth.password'));
        }

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return $this->successResponse('login_success', trans('auth.success.login'), ['access_token' => $tokenResult, 'token_type' => 'Bearer']);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse('logout_success');
    }
}

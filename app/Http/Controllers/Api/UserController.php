<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\Request;
use App\Services\Api\UserService;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Auth\Events\Verified;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->userService->findUserByEmail($request->get('email'));
            if (!$user) {
                return $this->responseErrors('user not found');
            }

            if (!Hash::check($request->get('password'), $user->password)) {
                return $this->responseErrors('password not match');
            }

            return response()->json([
                'code' => 200,
                'access_token' => $user->access_token
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->userService->createUser($request->Validated());
            $this->userService->sendVerifyEmail($user);

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'create user success'
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();

            return response()->json([
                'code' => 403,
                'message' => 'create use error'
            ], 403);
        }
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return redirect('/')->with('verify_message', 'メール認証できました。');
        }
    }
}

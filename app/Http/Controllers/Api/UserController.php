<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Api\UserService;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Auth\Events\Verified;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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

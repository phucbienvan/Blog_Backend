<?php

namespace App\Services\Api;

use App\Models\User;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService extends BaseService
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function createUser($params)
    {
        if (isset($params['avatar'])) {
            Storage::put('avatars/', $params['avatar']);
        }

        return $this->model->create($params);
    }

    public function sendVerifyEmail($user)
    {
        $user->sendEmailVerificationNotification();
    }
}

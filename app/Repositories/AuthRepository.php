<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\AuthInterface;
use App\Resources\AuthResource;
use App\Resources\UserDetailResource;
use Illuminate\Support\Facades\Auth;

class AuthRepository extends Controller implements AuthInterface
{

    /**
     * @inheritDoc
     */
    public function auth_login(array $credentials): object
    {
        $user = User::where('username', $credentials['username'])->with("userDetail")->first();
        if ($user == null) return $this->callback(false, 'Unable to find user');
        if (!password_verify($credentials['password'], $user->password)) return $this->callback(false, 'Invalid password');
        if (! $token = auth()->login($user)) {
            return $this->callback(false, "Unauthorized username or password is wrong");
        }
        return $this->callback(true, "Success login", $this->respond_with_token($token));
    }

    /**
     * @inheritDoc
     */
    public function auth_logout(): object
    {
        auth()->logout();
        return $this->callback(true, 'Successfully logged out');
    }

    /**
     * @inheritDoc
     */
    public function auth_refresh(): object
    {
        return $this->callback(true, "Refresh token", $this->respond_with_token(auth()->refresh()));
    }

    /**
     * @inheritDoc
     */
    public function auth_me(): object
    {
        return $this->callback(true, "Success get data login", auth()->user());
    }

    /**
     * @param $token
     * @return object
     */
    protected function respond_with_token($token): object
    {
        $collections = new AuthResource(auth()->user());
        $userDetail = new UserDetailResource(auth()->user()->userDetail);;
        $collections = (object)array_merge($collections->toArray(auth()->user()), $userDetail->toArray(auth()->user()->userDetail));

        return (object)[
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $collections,
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ];
    }
}

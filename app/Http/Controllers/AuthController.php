<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\AuthInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var AuthInterface
     */
    private AuthInterface $authInterface;

    /**
     * @param Request $request
     * @param AuthInterface $authInterface
     */
    public function __construct(Request $request, AuthInterface $authInterface)
    {
        $this->middleware('auth:api', ['except' => 'login', 'logout']);
        $this->request = $request;
        $this->authInterface = $authInterface;
    }

    /**
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $this->validate_request($this->request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $this->request->only(['username', 'password']);
        $auth = $this->authInterface->auth_login($credentials);

        return $this->BuildResponse($auth->is_success ? 200 : 400, $auth->message, $auth->data);
    }

    /**
     * @return JsonResponse
     */
    public function refresh_token(): JsonResponse
    {
        $refresh = $this->authInterface->auth_refresh();
        return $this->BuildResponse($refresh->is_success ? 200 : 400, $refresh->message, $refresh->data);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $logout = $this->authInterface->auth_logout();
        return $this->BuildResponse($logout->is_success, $logout->message, $logout->data);
    }

}

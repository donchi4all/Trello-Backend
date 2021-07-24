<?php

namespace App\Http\Controllers;

use App\Contracts\AuthServiceInterface as AuthService;
use App\Contracts\UserServiceInterface as UserService;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * AuthController constructor.
     */
    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     */
    public function login(Request $request)
    {
        $req = $this->authService->login($request);
        return isset($req['error']) || (isset($req['status']) && $req['status'] === 'failed')
            ? error($req['message'] ?? 'failed', $req['statusCode'] ?? 400)
            : success( $req['message'] ?? 'success', $req['data'] ?? $req );

    }

    /**
     * @param Request $request
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $checkUser = $this->userService->findByEmail($request->get('email'));
        if ( $checkUser ) return badRequest('User already Exist');
        $payload = $request->all();
        $payload['password'] =  bcrypt($payload['password']);

        $user = $this->authService->register( $payload );
        return success('successfully registered',$user);
    }

    public function logout()
    {
        if($this->authService->logout()){
            return success('logout successfully');
        }
        return badRequest('Error logging out');
    }

    public function me(){
        return success('Auth User returned',auth()->user()->toArray());
    }
}

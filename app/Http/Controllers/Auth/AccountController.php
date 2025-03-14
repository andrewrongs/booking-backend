<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\JwtAuthMiddleware;
use App\Services\Auth\AccountServices;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountServices;
    protected $jwtAuthMiddleware;
    
    public function __construct(AccountServices $accountServices, JwtAuthMiddleware $jwtAuthMiddleware)
    {
        $this->accountServices = $accountServices;
        $this->middleware('jwt.auth', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        try {
            $account = $this->accountServices->register($request);
            return response()->json([
                'status' => true,
                'message' => '註冊成功',
                'user' => $account,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function login(Request $request)
    {
        try {
            $login = $this->accountServices->login($request);
            return response()->json([
                'status' => true,
                'message' => '登入成功',
                'data' => $login,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $currentUser = auth('api')->user();
            
            $result = $this->accountServices->logout();
            
            return response()->json([
                'status' => true,
                'message' => '登出成功',
                'data' => [
                    'account' => $currentUser->account
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    // public function reset(Request $request)
    // {
    //     try {
           
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => '0',
    //             'message' => $e->getMessage(),
    //         ], 401);
    //     }
    // }

    // public function forgot(Request $request)
    // {
    //     try {
            
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => '0',
    //             'message' => $e->getMessage(),
    //         ], 401);
    //     }
    // }

}

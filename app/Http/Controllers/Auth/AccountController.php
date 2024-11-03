<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AccountServices;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountServices;
    public function __construct(AccountServices $accountServices)
    {
        $this->accountServices = $accountServices;
        // $this->middleware('auth:api', ['except' => 'login', 'register']);
    }

    public function register(Request $request)
    {
        try {
            $account = $this->accountServices->register($request);
            return response()->json([
                'status' => '1',
                'message' => '註冊成功',
                'user' => $account,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function login(Request $request)
    {
        try {
            $login = $this->accountServices->login($request);
            return response()->json([
                'status' => '1',
                'message' => '登入成功',
                'data' => $login,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
           $result = $this->accountServices->logout();
           return response()->json([
            'status' => 1,
            'message' => 'SUCCESS'
           ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => '0',
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

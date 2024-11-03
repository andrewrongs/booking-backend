<?php

namespace App\Services\Auth;

use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class AccountServices 
{
	protected $accountRepository;
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function register(Request $request)
    {
        $request->validate([
           'name' => 'required|string|max:12|unique:accounts',
           'account' => 'required|string|max:12|unique:accounts',
           'password' => 'required|string|min:12',
           'email' => 'required|email|unique:accounts',
           'phone' => 'required|string|max:12|unique:accounts',
        ]);

        $account = $this->accountRepository->create([
            'name' => $request->name,
            'account' => $request->account,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return $account;
    }

    public function login(Request $request)
    {
        $request->validate([
            'account' => 'required|string',
            'password' => 'required|string'
        ]);
        $account = $this->accountRepository->findAccount($request->account);
        if (!$account || !Hash::check($request->password, $account->password)) {
            throw ValidationException::withMessages([
                'account' => ['帳號或密碼錯誤'],
            ]);
        }
    
        if (!$token = auth('api')->login($account)) {
            throw new \Exception('認證錯誤');
        }
    
        return [
            'jwt_token' => $token,
            'user' => $account
        ];
    }

    public function logout()
    {
        try {
            auth('api')->logout();
            return [
                'status' => '1',
                'message' => '登出成功'
            ];
        } catch (\Exception $e) {
            throw new \Exception('登出失敗');
        }
    }

    // public function reset(Request $request)
    // {

    // }

    // public function forgot(Request $request)
    // {
    //     try{
    //         $request->validate([
    //             'email' => 'required|string'
    //         ]);
    //         $account = $this->accountRepository->findAccount2($request->email);

    //         if (!$account) {
    //             throw ValidationException::withMessages([
    //                 'email' => ['找不到此用戶'],
    //             ]);
    //         }
    //     }catch(\Exception $e){

    //     }
    // }
}
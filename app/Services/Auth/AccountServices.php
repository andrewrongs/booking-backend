<?php

namespace App\Services\Auth;

use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

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
            'password' => 'required|string',
        ]);

        $account = $this->accountRepository->findAccount($request->account);
        if (!$account || !Hash::check($request->password, $account->password)) {
            throw ValidationException::withMessages([
                'message' => ['pasword invalid'],
            ]);
        }

        if (!$token = auth('api')->login($account)) {
            throw new \Exception('authentication failed');
        }

        return [
            'data' => $account,
            'jwt_token' => $token,
        ];
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                throw new \Exception('找不到驗證');
            }

            dd($token);
            JWTAuth::invalidate($token);

            return [
                'status' => '1',
                'message' => '登出成功',
            ];
        } catch (\Exception $e) {
            throw new \Exception('logout failed');
        }
    }
}

<?php

// app/Http/Middleware/JwtAuthMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class JwtAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                throw new \Exception('找不到用户');
            }
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => '0',
                'message' => '令牌已过期'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => '0',
                'message' => '令牌无效'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => '0',
                'message' => '未授权'
            ], 401);
        }

        return $next($request);
    }
}

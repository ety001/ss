<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenticateWithToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('api')->user();
        if(!$user) {
            Log::error('Token Error, The wrong token is :'
                .Auth::guard('api')->getTokenForRequest());
            return response()->json([
                'status'=>false,
                'data'=>[],
                'msg'=>'Token错误. 接口需要权限验证'
            ]);
        }
        if(time()>$user->expired_time) {
            Log::error('Token Timeout, User id :'.$user->user_id);
            return response()->json([
                'status'=>false,
                'data'=>[],
                'msg'=>'Token超时.'
            ]);
        }
        Auth::setUser($user);
        return $next($request);
    }
}

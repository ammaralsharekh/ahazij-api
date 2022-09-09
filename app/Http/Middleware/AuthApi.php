<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessTokens;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(!empty($request->bearerToken()))
        {
            $personal_access_tokens = PersonalAccessTokens::query()->where(
                [['token',$request->bearerToken()],['expires_at','>',now()]])->first();
            if($personal_access_tokens){
                $personal_access_tokens->last_used_at=now();
                $personal_access_tokens->save();
                $request['user_id']=$personal_access_tokens->tokenable_id;
                return $next($request);
            }
        }
        return response()->json([
        'errors' => ['auth'=>['incorrect api credentials']],
    ], 401);;
    }
}

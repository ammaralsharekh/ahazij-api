<?php

namespace App\Http\Middleware;

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
            $is_exists = DB::table('personal_access_tokens')->where([['token',$request->bearerToken()],['expires_at','>',now()]])->first();
            if($is_exists){
                return $next($request);
            }
        }
        return response()->json([
        'errors' => ['auth'=>'incorrect api credentials'],
    ], 401);;
    }
}

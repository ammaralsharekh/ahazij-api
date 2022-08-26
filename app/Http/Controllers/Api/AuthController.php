<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller {

    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:15|unique:users,user_name',
            'mobile_number' => 'required|regex:/(009665)[0-9]/|unique:users,mobile_number',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['verification_code'] = rand(1000,9999);
        User::create($request->toArray());
        $response = ['verification_code' => $request['verification_code']];
        return response($response, 200);
    }

    public function verify_code (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|string',
            'mobile_number' => 'required|regex:/(009665)[0-9]/',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user=User::where('mobile_number', $request['mobile_number'])->first();
        if($user==null)
        {
            return response(['errors'=>"can't find mobile number"], 422);
        }
        if($user->verification_code != $request['verification_code'])
        {
            return response(['errors'=>'wrong verification code'], 422);
        }
        $user->mobile_number_verified_at=now();
        $user->save();
        $token = $user->createToken('Personal Access Token');

        $token->accessToken->expires_at = Carbon::now()->addYear();

        $token->accessToken->save();

        $token->accessToken->makeVisible('token');
        return response($token);
    }

	/**
	 * Login user and create token
	 *
	 * @param  [string] email
	 * @param  [string] password
	 * @return [string] access_token
	 * @return [string] token_type
	 * @return [string] expires_at
	 */
	public function login(Request $request) {

		$validator = Validator::make($request->all(), [
            'mobile_number' => 'required|regex:/(009665)[0-9]/',
			'password' => 'required|string',
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 400);
		}

		$credentials = request(['mobile_number', 'password']);

		if (!Auth::attempt($credentials)) {
			return response()->json([
				'errors' => ['auth'=>'incorrect api credentials'],
			], 401);
		}

		$user = $request->user();

        $user->verification_code=rand(1000,9999);
        $user->save();
        $response = ['verification_code' => $user->verification_code];
        return response($response, 200);


	}

	/**
	 * Logout user (Revoke the token)
	 *
	 * @return [string] message
	 */
	public function logout(Request $request) {
		$request->user()->token()->revoke();

		return response()->json([
			'message' => 'Successfully logged out',
		]);
	}

}

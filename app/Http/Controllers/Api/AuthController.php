<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
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
			'email' => 'required|string|email',
			'password' => 'required|string',
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 400);
		}

		$credentials = request(['email', 'password']);

		if (!Auth::attempt($credentials)) {
			return response()->json([
				'errors' => ['auth'=>'incorrect api credentials'],
			], 401);
		}

		$user = $request->user();

		$tokenResult = $user->createToken('Personal Access Token');
		$token = $tokenResult->token;

		$token->expires_at = Carbon::now()->addHours(2);

		$token->save();

		return response()->json([
			'access_token' => $tokenResult->accessToken,
			'token_type' => 'Bearer',
			'expires_at' => Carbon::parse(
				$tokenResult->token->expires_at
			)->toDateTimeString(),
		]);
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

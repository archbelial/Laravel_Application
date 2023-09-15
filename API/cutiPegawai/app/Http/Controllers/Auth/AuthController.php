<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Helpers\ApiFormatter;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(),[
            'name'              => 'required|min:2'
            ,'email'            => 'required|email'
            ,'password'         => 'required'
            ,'confirm_password' => 'required'
        ]);

        if ($validator->fails()) {
            return ApiFormatter::createApi(400, 'Failed to Register', $validator->errors());
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // $input = $request->all();
        // $input['password'] = bcrypt($input['password']);
        // $user = User::create($input);
        // $success['token'] = $user->createToken('auth_token')->plainTextToken;
        // $success['name'] = $user->name;
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'token' => $token,
            'name' => $user->name,
        ];

        return ApiFormatter::createApi(200, 'Success to Register', $response);
    }

    public function login(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password'=> $request->password])){
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;

            return ApiFormatter::createApi(200, 'Success to Login', $success);

        } else {
            return ApiFormatter::createApi(400, 'Invalid Credential');
            
        }
        
    }
}

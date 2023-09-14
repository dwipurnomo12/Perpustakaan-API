<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users|string|max:255',
            'password'  => 'required|min:8|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'role_id'   => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 422);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id
        ]);

        return ResponseFormatter::success([
                'user'  => $user
        ], 'User Registered');
    } 
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 422);
        }

       if(!$token=auth()->attempt($validator->validated())){
            return ResponseFormatter::error([
                'messagge'  => 'Unauthorized'
            ], 'Authentication Failed', 401);
       }

        return $this->createNewToken($token);
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => JWTAuth::factory()->getTTL() * 60,
            'user'          => auth()->user()
        ]);
    }
    
    public function profil(Request $request)
    {
        return ResponseFormatter::success($request->user(), 
            'Successfully show user data');
    }

    public function logout()
    {
        auth()->logout();
        return ResponseFormatter::success([
            'message'   => 'Logout Succesfully'
        ]);
    }
}

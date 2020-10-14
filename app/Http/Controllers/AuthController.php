<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3'
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }


    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->name != $request->name) {
            if (strlen($request->name) >= 3)
                $user->name = $request->name;
            else
                return response()->json([
                    'status' => 'error',
                    'errors' => ['name' => 'validation.required']
                ], 200);
        }
        if ($user->email != $request->email) {
            if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'status' => 'error',
                    'errors' => ['email' => 'validation.required']
                ], 200);
            } else {
                $user->email = $request->email;
            }
        }

        if ($request->password != '')
            if (strlen($request->password) >= 3) {
                $user->password = bcrypt($request->password);
            } else {
                return response()->json([
                    'status' => 'error',
                    'errors' => ['password' => 'validation.required']
                ], 200);
            }
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Login user and return a token
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'login_error'], 401);
    }
    /**
     * Logout User
     */
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
    /**
     * Refresh JWT token
     */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    /**
     * Return auth guard
     */
    private function guard()
    {
        return Auth::guard();
    }
}

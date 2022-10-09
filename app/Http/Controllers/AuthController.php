<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'first_name' => 'required',
           'last_name' => 'required',
           'email' => 'required|email',
           'phone_number' => 'required',
           'password' => 'required',
           'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = new User();
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->phone_number = $input['phone_number'];
        $user->password = $input['password'];
        $user->save();

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->first_name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User Registered Successfully!'
        ];

        return response()->json($response,200);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();

            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->first_name;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User login Successfully!'
            ];
            return response()->json($response,200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorised'
            ];
            return response()->json($response);
        }
    }
}

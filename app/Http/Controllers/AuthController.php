<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request) {

        //get the validated request
        $validated = $request->safe()->all();

        $status = 0;

        $validated['password'] = Hash::make($validated['password']);

        //create the user with validated input
        $data = User::create($validated);

        $token = $data->createToken('myapptoken')->plainTextToken;

        if($data) $status = 1;

        return response()->json([
            "status" => $status,
            "data" => $data,
            //"token" => $token
        ]);
    }
    

    public function login(LoginRequest $request)
    {
        /* Getting the validated data from the request. */
        $validated = $request->safe()->only(['username', 'password', 'type']);
        // $validated = $request->safe()->all();

        /* Getting the first customer user with the username from the request. */
        $user = User::where('username', $validated['username'])->first();
        
        /* Checking if the user exists, if the password is correct, if the pin is correct, if the status is active, if the status is blocked. */
        if ( !$user || !Hash::check($validated['password'], $user->password) ) {
               
            /* Returning a 401 status code with a message. */
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);

        }

        /* Deleting all the tokens for the user. */
        $user->tokens()->delete();

        /* Creating a token for the user. */
        $token = $user->createToken('auth_token')->plainTextToken;

        /* Returning the token to the user. */
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ]);
    }  


    public function profile(){
        
        return response()->json([
            'data' => auth()->user(),
            'status' => 1,
        ]);
    }


    public function logout(){
        
        auth()->user()->tokens()->delete();

       /* return a message that the user is logged out*/
       return response()->json([
        
            'message' => 'user logged out',
            'status' => 1
        
        ]);

    }
}

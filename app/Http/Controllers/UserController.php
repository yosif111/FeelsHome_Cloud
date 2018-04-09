<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    /**
     * register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $credentials = $request->only(['username','password','name','email']);
        
        $credentials['password'] = \Hash::make($credentials['password']);
        
        if($user = User::create($credentials)){
            return new Response(['Messeage'=>"the user has been added", 'user' => $user],200);
        }
        else
            return new Response(['error'=>"email taken"],400);
    }

   /**
     * login a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        try {
            if (!$token = \JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'credentials failed'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $token = compact('token');
        $user = \JWTAuth::toUser($token['token']);
        $data = [ $token , 'user' => $user];
        
        return new Response($data,200);
    }

    

 
}

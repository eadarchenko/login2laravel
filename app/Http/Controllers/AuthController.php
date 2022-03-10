<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique',
            'password' => 'required|string|min:6'

        ]);

        $user = new User ([
            'name' => $request->name,
            'email' =>$request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->save();
        return response()->json(['message'=>'Usuario logueado con exito!'],200);
    }
    public function login(Request $request){
        $request->validate([

            'email'=>'required',
            'password'=>'required'
        ]);

        $credentials = request(['email','password']);

        if(!Auth::attempt($credentials)){
            return   response()->json(['message'=>'Usuario no autorizado'],401);

            $user=$request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->$token;
            $token->expires_at = Carbon::now()->addMonth(2);
            $token->save();

            return response()-json([ 'data'=>[
                'user' => Auth::user(),
                'access_token' => $tokenResult->accessToken,
                'token_type' =>'Portador',
                'expires_at' =>Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();]]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
    
    protected function register(array $data){
        return Validator::make($data,[
            'nickname'=>['required','string','max:255','unique:name'],
            'email'=>['required','string','max:255','unique:users'],
            'password'=>['required','string','min:8',]
        ]);
    }

    protected function create(array $data) {
        return User::create([
            'nickname' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), //encrypta la contraseña
        ]);
    }
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

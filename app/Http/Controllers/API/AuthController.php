<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }


    public function login()
    {
        $credentials = request(['mobile', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
    public function register(Request $request)
    {
        $validator=Validator()->make($request->all(),[
            'name'=>'required',
            'mobile'=>'required|unique:users,mobile|min:11|max:11',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);
        if($validator->fails())
        {
            return response()->json(['message'=>'failed','data'=>$validator->errors()],400);

        }
        $user=User::create([
            'name'=>$request->name,
            'mobile'=>$request->mobile,
            'email'=>$request->email,
            'activation_code'=>rand(000000,999999),
            'password'=>bcrypt($request->password),
        ]);

        $this->sendMessage("Your Activation code is:$user->activation_code", $request->mobile);

        return response()->json(['message'=>'success','data'=>$user],200);
    }


    /**
     * Sends sms to user using Twilio's programmable sms client
     * @param String $message Body of sms
     * @param Number $recipients string or array of phone number of recepient
     */
    protected function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients,
            ['from' => $twilio_number, 'body' => $message]);
    }
}

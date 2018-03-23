<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\User;
 
class LoginController extends Controller
{
    /**
     * Index login controller
     *
     * When user success login will retrive callback as api_token
     */
    public function login(Request $request)
    {
        $hasher = app()->make('hash');
        $password = $request->input('password');
        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return response()->json(['status' => 'error', 'message' => 'User Not Found'], 404);
        }
        else{
            if($hasher->check($password, $user->password))
            {
                $api_token = str_random(50);
                $create_token = $user->update(['api_token' => $api_token]);
                if ($create_token){
                    return response()->json(['status' => 'success', 'user' => $user], 200);
                }                
            }
            else {
                return response()->json(['status' => 'error', 'message' => 'Invalid Credential!'], 401);
            }
        }        
    }

    public function logout(Request $request)
    {
        $api_token = $request->api_token;
        $user = User::where('api_token', $api_token)->first();

        if(!$user) {
            return response()->json(['status' => 'error', 'message' => 'Not Logged in'], 401);
        }

        $user->api_token = null;
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'You are now logged out'], 200);
    }
}
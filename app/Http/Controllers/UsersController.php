<?php
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
 
class UsersController extends Controller
{
    public function __construct()
    {

    }
    
    /**
     * Register new user
     *
     * @param $request Request
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        
        $hasher = app()->make('hash');
        $name = $request->name;
        $password = $hasher->make($request->password);
        $user = User::create([
            'name' => $name,
            'username' => $request->username,
            'email' => $request->email,
            'api_token' => str_random(50),      
        ]);
        $user->password = $password;
        $user->save();
         
        return response()->json(['status' => 'success', 'user'=>$user], 200);
    }
    
}
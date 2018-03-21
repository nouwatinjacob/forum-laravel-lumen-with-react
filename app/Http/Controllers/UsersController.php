<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\User;
 
class UsersController extends Controller
{
    /**
     * Register new user
     *
     * @param $request Request
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
 
        $hasher = app()->make('hash');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $hasher->make($request->input('password'));
        dd($password);
        $avatar = $request->input('avatar');
        $user = User::create([
            'email' => $email,
            'password' => $password,
            'avatar' => $avatar,
        ]);
 
        $res['success'] = true;
        $res['message'] = 'Success register!';
        $res['data'] = $user;
        return response($res);
    }
    /**
     * Get user by id
     *
     * URL /user/{id}
     */
    public function get_user(Request $request, $id)
    {
        $user = User::where('id', $id)->get();
        if ($user) {
              $res['success'] = true;
              $res['message'] = $user;
 
              return response($res);
        }else{
          $res['success'] = false;
          $res['message'] = 'Cannot find user!';
 
          return response($res);
        }
    }
}
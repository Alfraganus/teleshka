<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Telly;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function create(Request $request)
    {
        $name = $request->input('fullname');
        $username = $request->input('username');
        $role = $request->input('role');
        $model = new User();
        $model->fullname=$name;
        $model->username=$username;
        $model->role=$role;
        $model->save();
    }

    public function register(Request $request)
    {

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus);
    }

    public function login(){
        if(Auth::attempt(['fullname' => request('fullname'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

}

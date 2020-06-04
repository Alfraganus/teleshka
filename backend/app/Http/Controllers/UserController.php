<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Telly;
use App\Http\Models\PPrEvent;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request)
    {
        
        $getUser = User::get();
        return $getUser;
    }
   
    public function create(Request $request)
    {
        $name = $request->input('fullname');
        $username = $request->input('username');
        $email = $request->input('email');
        $role = $request->input('role');
        $password = $request->input('password');
        $model = new User();
        $model->fullname=$name;
        $model->username=$username;
        $model->role=$role;
        $model->password=bcrypt($password);
        $model->save();

        return $model;
    }

    public function update(Request $request, $id)
    {
        $updateUser = User::find($request->input('id'));
        $updatedEmail = $request->input('email');
        $updatedName = $request->input('fullname');
        $updatedPass = $request->input('password');
        $updatedUsername = $request->input('username');
        $updatedRole = $request->input('role');
        $updateUser->email = $updatedEmail;
        $updateUser->fullname = $updatedName;
        $updateUser->password = bcrypt($updatedPass);
        $updateUser->username = $updatedUsername;
        $updateUser->role = $updatedRole;
        $updateUser->save();
        return $updateUser;
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        /*$success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus);*/
        return "Successfully created";
    }

    public function destroy($id)
    {
        $user=User::FindOrFail($id);
        $user->delete();
        return 'Deleted successfully!';
    }

    public function login(){
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
           /* $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);*/
            return "Login granted!";
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    public function show()
    {
     return Auth::user();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Telly;
use App\User;

class UserController extends Controller
{
    //
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
}

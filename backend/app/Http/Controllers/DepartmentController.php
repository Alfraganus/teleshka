<?php

namespace App\Http\Controllers;
use App\Http\Models\Telly;
use App\Http\Models\PPrEvent;
use App\User;
use App\Http\Models\TellyType;
use App\Http\Models\Shift;
use App\Http\Models\Department;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    //
    public function index()
    {
        $getDeps = Department::get();
        return $getDeps;
    }

    public function create(Request $request)
    {
        $depName = $request->input('name');
        $addDep = New Department;
        $addDep->name = $depName;
        $addDep->save();
        
    }

    public function update(Request $request)
    {
        $updateDep = Department::where(['id'=>$request['id']])->first();
        $newName = $request->input('name');
        $updateDep->name = $newName;
        $updateDep->save();
        return 'Updated successfully!';
    }

    public function destroy($id)
    {
        $department = Department::FindOrFail($id);
        $department->delete();
        return 'Deleted successfully!';
    }
}


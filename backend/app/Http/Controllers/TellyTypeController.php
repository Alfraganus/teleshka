<?php

namespace App\Http\Controllers;
use App\Http\Models\Telly;
use App\Http\Models\PPrEvent;
use App\User;
use App\Http\Models\TellyType;

use Illuminate\Http\Request;

class TellyTypeController extends Controller
{
    //

    public function index()
    {
        $getTellyType = TellyType::get();
        return $getTellyType;
    }

    public function create(Request $request){
        $typeName = $request->input('name');
        $addType = New TellyType;
        $addType->name = $typeName;
        $addType->save();
    }

    public function update(Request $request, $id)
    {
        $updateType = TellyType::where(['id'=>$request['id']])->first();
        $newName = $request->input('name');
        $updateType->name = $newName;
        $updateType->save();
        return 'Updated successfully!';
    }

    public function destroy($id)
    {
        $tellyType = TellyType::FindOrFail($id);
        $tellyType->delete();
        return 'Deleted successfully!';
    }

}

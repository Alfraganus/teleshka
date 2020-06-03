<?php

namespace App\Http\Controllers;


use App\Http\Models\Telly;
use App\User;
use Illuminate\Http\Request;

class TellyController extends Controller
{
    //
    

    public function create(Request $request)
    {
        $tellyName = $request->input('telly_number');
        $tellyType = $request->input('telly_type_id');
        $tellyDesc = $request->input('telly_desc');
        $addTelly = new Telly;
        $addTelly->telly_name=$tellyName;
        $addTelly->telly_type_id=$tellyType;
        $addTelly->telly_desc=$tellyDesc;
        $addTelly->save();
        return 'New Telly successfully created!';
    }

    public function index()
    {
        
        $getTelly = Telly::get();
        return $getTelly;
    }

    public function update(Request $request)
    {
        $updateTelly = Telly::find($request->input('id'));
        $updatedNumber = $request->input('telly_number');
        $updatedType = $request->input('telly_type_id');
        $updatedDesc = $request->input('telly_desc');
        $updateTelly->telly_number = $updatedNumber;
        $updateTelly->telly_type_id = $updatedType;
        $updateTelly->telly_desc = $updatedDesc;
        $updateTelly->save();
        return 'Updated successfully!';
    }

    public function destroy($id)
    {
        $telly=Telly::FindOrFail($id);
        $telly->delete();
        return 'Deleted successfully!';
    }
}

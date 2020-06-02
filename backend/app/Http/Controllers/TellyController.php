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
        $tellyName = $request->input('telly_name');
        $tellyType = $request->input('telly_type');
        $addTelly = new Telly;
        $addTelly->telly_name=$tellyName;
        $addTelly->telly_type=$tellyType;
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
        $updatedName = $request->input('telly_name');
        $updatedType = $request->input('telly_type');
        $updateTelly->telly_name = $updatedName;
        $updateTelly->telly_type = $updatedType;
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

<?php

namespace App\Http\Controllers;
use App\Http\Models\Telly;
use App\Http\Models\PPrEvent;
use App\User;
use App\Http\Models\TellyType;
use App\Http\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    //
    public function index()
    {
        $getShifts = Shift::get();
        return $getShifts;
    }

    public function create(Request $request)
    {
        $shiftName = $request->input('name');
        $addShift = New Shift;
        $addShift->name = $shiftName;
        $addShift->save();
    }

    public function update(Request $request)
    {
        $updateShift = Shift::where(['id'=>$request['id']])->first();
        $newShift = $request->input('name');
        $updateShift->name = $newShift;
        $updateShift->save();
        return 'Updated successfully!';
    }

    public function destroy($id)
    {
        $shift = Shift::FindOrFail($id);
        $shift->delete();
        return 'Deleted successfully!';
    }
}


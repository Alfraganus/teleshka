<?php

namespace App\Http\Controllers;
use App\Http\Models\Telly;
use App\Http\Models\PPrEvent;
use App\User;
use App\Http\Models\TellyType;
use App\Http\Models\Shift;
use Illuminate\Http\Request;

class PprController extends Controller
{
    //
    public function index()
    {
        $getPpr = PprEvent::with('shift')->with('tellyId')->get();
        $shifts = Shift::get();
        $tellyIds = Telly::get();
        return ['getPpr'=>$getPpr, 'shifts'=>$shifts, 'tellyIds'=>$tellyIds];
    }

    public function create(Request $request)
    {
        $pprDate =  $request->input('ppr_date');
        $shift_id = $request->input('shift_id');
        $employeeTabel = $request->input('ppr_responsible_employee_tabel');
        $brigadirTabel =$request->input('brigadir_tabel');
        $tellyId = $request->input('telly_id');
        $departmentName = $request->input('department_name');
        $technicalReview = $request->input('technical_review_conclusion');
        $addPpr = New PprEvent;
        $addPpr->ppr_date = $pprDate;
        $addPpr->shift_id = $shift_id;
        $addPpr->ppr_responsible_employee_tabel = $employeeTabel;
        $addPpr->brigadir_tabel = $brigadirTabel;
        $addPpr->telly_id = $tellyId;
        $addPpr->department_name = $departmentName;
        $addPpr->technical_review_conclusion = $technicalReview;
        $addPpr->save();

    }

    public function update(Request $request, $id)
    {
    $updatePpr = PPrEvent::where(['id'=>$request['id']])->first();
    $newDate =  $request->input('ppr_date');
    $newShiftId = $request->input('shift_id');
    $newEmployeeTabel = $request->input('ppr_responsible_employee_tabel');
    $newBrigadirTabel = $request->input('brigadir_tabel');
    $newTellyId = $request->input('telly_id');
    $newDepartmentName = $request->input('department_name');
    $newTechReview = $request->input('technical_review_conclusion');
    $updatePpr->ppr_date = $newDate;
    $updatePpr->shift_id = $newShiftId;
    $updatePpr->ppr_responsible_employee_tabel = $newEmployeeTabel;
    $updatePpr->brigadir_tabel = $newBrigadirTabel;
    $updatePpr->telly_id =$newTellyId;
    $updatePpr->department_name =$newDepartmentName;
    $updatePpr->technical_review_conclusion = $newTechReview;
    $updatePpr->save();
    return 'Updated successfully!';
    }
    

    public function destroy($id)
    {
        $Ppr = PprEvent::FindOrFail($id);
        $Ppr->delete();
        return 'Deleted successfully';
    }
}

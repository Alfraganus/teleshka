<?php

namespace App\Http\Controllers;
use App\Http\Models\Telly;
use App\Http\Models\PPrEvent;
use App\User;
use App\Http\Models\TellyType;

use Illuminate\Http\Request;

class PprController extends Controller
{
    //
    public function index()
    {
        $getPpr = PprEvent::get();
        return $getPpr;
    }

    public function create(Request $request)
    {
        $pprDate =  $request->input('ppr_date');
        $shift_id = $request->input('shift_id');
        $employeeTabel = $request->input('ppr_responsible_employee_tabel');
        $brigadirTabel =$request->input('brigadir_tabel');
        $tellyNumber = $request->input('telly_number');
        $departmentName = $request->input('department_name');
        $technicalReview = $request->input('technical_review_conclusion');
        $addPpr = New PprEvent;
        $addPpr->ppr_date = $pprDate;
        $addPpr->shift_id = $shift_id;
        $addPpr->ppr_responsible_employee_tabel = $employeeTabel;
        $addPpr->brigadir_tabel = $brigadirTabel;
        $addPpr->telly_number = $tellyNumber;
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
    $newTellyNumber = $request->input('telly_number');
    $newDepartmentName = $request->input('department_name');
    $newTechReview = $request->input('technical_review_conclusion');
    $updatePpr->ppr_date = $newDate;
    $updatePpr->shift_id = $newShiftId;
    $updatePpr->ppr_responsible_employee_tabel = $newEmployeeTabel;
    $updatePpr->brigadir_tabel = $newBrigadirTabel;
    $updatePpr->telly_number =$newTellyNumber;
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

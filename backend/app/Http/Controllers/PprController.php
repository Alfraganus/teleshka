<?php

namespace App\Http\Controllers;
use App\Http\Models\Telly;
use App\Http\Models\PPrEvent;
use App\User;
use App\Http\Models\TellyType;
use App\Http\Models\Shift;
use App\Http\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PprController extends Controller
{
    //
    public function index()
    {
        $getPpr = PprEvent::with('shift')->with('tellyId')->with('departmentId')->orderBy('updated_at', 'desc')->get();
        //$shifts = Shift::get();
        //$tellyIds = Telly::get();
        //$departments = Department::get();
        return $getPpr;
    }

    public function create(Request $request)
    {
        $pprDate =  $request->input('ppr_date');
        $shift_id = $request->input('shift_id');
        $employeeTabel = $request->input('ppr_responsible_employee_tabel');
        $employeeFullname = $request->input('ppr_responsible_employee_fullname');
        $brigadirTabel = $request->input('brigadir_tabel');
        $brigadirFullname =$request->input('brigadir_fullname');
        $tellyId = $request->input('telly_id');
        $departmentId = $request->input('department_id');
        $technicalReview = $request->input('technical_review_conclusion');
        $addPpr = New PprEvent;
        $addPpr->ppr_date = $pprDate;
        $addPpr->shift_id = $shift_id;
        $addPpr->ppr_responsible_employee_tabel = $employeeTabel;
        $addPpr->ppr_responsible_employee_fullname = $employeeFullname;
        $addPpr->brigadir_tabel = $brigadirTabel;
        $addPpr->brigadir_fullname = $brigadirFullname;
        $addPpr->telly_id = $tellyId;
        $addPpr->department_id = $departmentId;
        $addPpr->technical_review_conclusion = $technicalReview;
        $addPpr->save();

    }

    public function update(Request $request, $id)
    {
    $updatePpr = PPrEvent::where(['id'=>$request['id']])->first();
    $newDate =  $request->input('ppr_date');
    $newShiftId = $request->input('shift_id');
    $newBrigadirTabel = $request->input('brigadir_tabel');
    $newBrigadirFullname = $request->input('brigadir_fullname');
    $newTellyId = $request->input('telly_id');
    $newDepartmentId = $request->input('department_id');
    $newTechReview = $request->input('technical_review_conclusion');
    $updatePpr->ppr_date = $newDate;
    $updatePpr->shift_id = $newShiftId;
    $updatePpr->brigadir_tabel = $newBrigadirTabel;
    $updatePpr->brigadir_fullname = $newBrigadirFullname;
    $updatePpr->telly_id =$newTellyId;
    $updatePpr->department_id =$newDepartmentId;
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

    public function list()
    {
        $getPpr = PprEvent::select(DB::raw('substring(ppr_date, 1,7) as month'), DB::raw('count(id) as count'))
                ->groupBy('month')
                ->get();
        return $getPpr;
    }
}

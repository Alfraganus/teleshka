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
use Carbon\Carbon;
class PprController extends Controller
{
    //
    public function index()
    {
        $getPpr = PprEvent::with('shift')
                            ->with('telly')
                            ->with('department')
                            ->get();
        return $getPpr;
    }

    public function create(Request $request)
    {
        $pprDate =  $request->input('ppr_date');
        $shift_id = $request->input('shift_id');
        $employeeTabel = $request->input('ppr_responsible_employee_tabel');
        $employeeFullName = $request->input('ppr_responsible_employee_fullname');
        $brigadirTabel = $request->input('brigadir_tabel');
        $brigadirFullName = $request->input('brigadir_fullname');
        $tellyId = $request->input('telly_id');
        $departmentId = $request->input('department_id');
        $technicalReview = $request->input('technical_review_conclusion');
        $addPpr = New PprEvent;
        $addPpr->ppr_date = $pprDate;
        $addPpr->shift_id = $shift_id;
        $addPpr->ppr_responsible_employee_tabel = $employeeTabel;
        $addPpr->ppr_responsible_employee_fullname = $employeeFullName;
        $addPpr->brigadir_tabel = $brigadirTabel;
        $addPpr->brigadir_fullname = $brigadirFullName;
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
    $newEmployeeTabel = $request->input('ppr_responsible_employee_tabel');
    $employeeFullName = $request->input('ppr_responsible_employee_fullname');
    $newBrigadirTabel = $request->input('brigadir_tabel');
    $brigadirFullName =$request->input('brigadir_fullname');
    $newTellyId = $request->input('telly_id');
    $newDepartmentId = $request->input('department_id');
    $newTechReview = $request->input('technical_review_conclusion');
    $updatePpr->ppr_date = $newDate;
    $updatePpr->shift_id = $newShiftId;
    $updatePpr->ppr_responsible_employee_tabel = $newEmployeeTabel;
    $updatePpr->ppr_responsible_employee_fullname = $employeeFullName;
    $updatePpr->brigadir_tabel = $newBrigadirTabel;
    $updatePpr->brigadir_fullname = $brigadirFullName;
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
        $year=date("Y");
        $getPprs = PprEvent::select(DB::raw('month(ppr_date) as month'),DB::raw('count(id) as ppr_count'))
                ->whereBetween('ppr_date',[$year.'-01-01',($year+1).'-01-01'])
                ->groupBy('month')
                ->get();
                
        return $getPprs;
    }

    public function typelist()
    {

        $getTypes= DB::select("select tt.name, count(p.id) ppr_count from ppr_events p 
                        inner join tellies t on t.id=p.telly_id 
                        inner join telly_types tt on tt.id=t.telly_type_id
                        where p.ppr_date BETWEEN '".date("Y")."-01-01' and '".(date("Y")+1)."-01-01'
                        group by tt.name");
                return ['res'=>$getTypes, 'year'=>date("Y")];

    }

    public function shiftList()
    {    
        $today = Carbon::today()->toDateString();
        
        $shift = Shift::get();

        foreach ($shift as $key => $value) {
            $shift[$key]->count = PprEvent::where('ppr_date', $today)->where('shift_id', $value->id)->count();
        }
        return $shift;
        
        
    }
}

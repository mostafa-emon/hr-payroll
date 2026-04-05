<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\EmploymentInfo;
use Auth;

class InactiveEmployeeListReport implements FromView
{
    public function view(): View
    {
        $employment_infos       = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name','employees.gender','employees.blood_group','employees.date_of_birth','employees.religion','employees.phone_1','employees.nid_number')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->where('current_status','Inactive')
                                ->orderBy('department_id','asc');

        if(request()->original_employee_id != ""){
            $employment_infos   = $employment_infos->where('employees.employee_id',request()->original_employee_id);
        }else{
            if(request()->department_id != ""){
                $employment_infos   = $employment_infos->where('department_id',request()->department_id);
            }

            if(request()->designation_id != ""){
                $employment_infos   = $employment_infos->where('designation_id',request()->designation_id);
            }

            if(request()->religion != ""){
                $employment_infos   = $employment_infos->where('religion',request()->religion);
            }

            if(request()->gender != ""){
                $employment_infos   = $employment_infos->where('gender',request()->gender);
            }

            if(request()->blood_group != ""){
                if(request()->blood_group == "AB Positive") {
                    $blood_group        = 'AB+';

                }elseif(request()->blood_group == "AB Negative") {
                    $blood_group        = 'AB-';

                }elseif(request()->blood_group == "A Positive") {
                    $blood_group        = 'A+';

                }elseif(request()->blood_group == "A Negative") {
                    $blood_group        = 'A-';

                }elseif(request()->blood_group == "B Positive") {
                    $blood_group        = 'B+';

                }elseif(request()->blood_group == "B Negative") {
                    $blood_group        = 'B-';

                }elseif(request()->blood_group == "O Positive") {
                    $blood_group        = 'O+';
                    
                }elseif(request()->blood_group == "O Negative") {
                    $blood_group        = 'O-';
                }
                $employment_infos   = $employment_infos->where('blood_group',$blood_group);
            }

            if(request()->duty_type != ""){
                $employment_infos   = $employment_infos->where('duty_type',request()->duty_type);
            }
        }

        $employees      = $employment_infos->get();

        return view('reports.exports.inactive_employee_list_table',compact('employees'));
    }
}

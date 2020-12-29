<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use App\GovtHolidayDetail;
use Auth;
use App\Employee;
use App\AttendancePolicy;

class PublicController extends Controller
{
    public function index($company_id) {
        $attendance_policy = AttendancePolicy::where('company_id',Auth::user()->company_id)->first();

        $count = Attendance::where('company_id',$company_id)->where('date',date('Y-m-d'))->count();
        if($count == 0) {
            $is_govt_holiday = GovtHolidayDetail::where('company_id',Auth::user()->company_id)->where('date',date('Y-m-d'))->count();

            $employees = Employee::where('company_id',Auth::user()->company_id)
                            ->join('employment_infos','employees.id','employment_infos.employee_id')
                            ->get();

            foreach($employees as $employee) {
                $attendance = new Attendance();
                $attendance->company_id     = $employee->company_id;
                $attendance->employee_id    = $employee->id;
                $attendance->date           = date('Y-m-d');

                $is_weekly_holiday = 0;
                if(date("l") == $employee->weekend_1 || date("l") == $employee->weekend_2) {
                    $is_govt_holiday = 1;
                }

                $is_in_paid_leave = 0;
                

                if($employee->duty_type == "Non-Roster") {
                    if($attendance_policy->start_time != "" && $attendance_policy->end_time != "") {
                        if($attendance_policy->start_time_meridiem == 0) {
                            $start_time_meridiem = "AM";
                        }else {
                            $start_time_meridiem = "PM";
                        }

                        if($attendance_policy->end_time_meridiem == 0) {
                            $end_time_meridiem = "AM";
                        }else {
                            $end_time_meridiem = "PM";
                        }

                        $attendance->actual_in_time     = date('H:i',strtotime($attendance_policy->start_time.' '.$start_time_meridiem));
                        $attendance->actual_out_time    = date('H:i',strtotime($attendance_policy->end_time.' '.$end_time_meridiem));
                        $attendance->roster_employee    = 0;
                    }
                }
                
            }
        }
    } 
}

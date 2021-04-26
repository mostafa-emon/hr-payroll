<?php

namespace App\Http\Controllers;

use App\GeneralLeave;
use Illuminate\Http\Request;
use App\Attendance;
use App\GovtHolidayDetail;
use Auth;
use App\Employee;
use App\AttendancePolicy;
use App\PaidLeave;
use App\ShiftType;
use App\RosterEmployee;
use App\AttendanceRecord;

class PublicController extends Controller
{
    public function index($company_id,$auto="") {
        $company_id = $company_id - 1000;
        $attendance_policy = AttendancePolicy::where('company_id',$company_id)->first();

        $count = Attendance::where('company_id',$company_id)->where('date',date('Y-m-d'))->count();
        if($count == 0) {
            $is_govt_holiday = GovtHolidayDetail::where('company_id',$company_id)->where('date',date('Y-m-d'))->count();

            $employees = Employee::where('company_id',$company_id)
                            ->join('employment_infos','employees.id','employment_infos.employee_id')
                            ->get();

            foreach($employees as $employee) {
                $attendance = new Attendance();
                $attendance->company_id     = $employee->company_id;
                $attendance->employee_id    = $employee->id;
                $attendance->date           = date('Y-m-d');

                $is_weekly_holiday = 0;

                $is_in_paid_leave = PaidLeave::where('employee_id',$employee->id)->where('date',date('Y-m-d'))->count();
                $is_in_general_leave = GeneralLeave::where('employee_id',$employee->id)->where('date',date('Y-m-d'))->count();

                if($employee->duty_type == "Non-Roster") {
                    if(date("l") == $employee->weekend_1 || date("l") == $employee->weekend_2) {
                        $is_weekly_holiday = 1;
                    }

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

                else {
                    $roster = RosterEmployee::where('employee_id',$employee->id)->where('date',date('Y-m-d'))->first();
                    if($roster != "") {
                        if($roster->day_off == 1) {
                            $is_weekly_holiday = 1;
                        }

                        $shift = ShiftType::where('id',$roster->shift_id)->first();
                        if($shift != "") {
                            if($shift->start_time_meridiem == 0) {
                                $start_time_meridiem = "AM";
                            }else {
                                $start_time_meridiem = "PM";
                            }

                            if($shift->end_time_meridiem == 0) {
                                $end_time_meridiem = "AM";
                            }else {
                                $end_time_meridiem = "PM";
                            }

                            $attendance->actual_in_time     = date('H:i',strtotime($shift->start_time.' '.$start_time_meridiem));
                            $attendance->actual_out_time    = date('H:i',strtotime($shift->end_time.' '.$end_time_meridiem));
                            $attendance->roster_employee    = 1;
                        }
                    } else {
                        $is_weekly_holiday = 1;
                        $in_time_default = "12:00"; $out_time_default = "12:00";
                        $attendance->actual_in_time     = date('H:i',strtotime($in_time_default));
                        $attendance->actual_out_time    = date('H:i',strtotime($out_time_default));
                        $attendance->roster_employee    = 1;
                    }

                }

                $attendance->status = "ABSENT"; $attendance->readable_status = "Absent";
                if($is_weekly_holiday > 0) { $attendance->status = "WEEKLY_HOLIDAY"; $attendance->readable_status = "Day Off"; }
                if($is_govt_holiday > 0) { $attendance->status = "GOVT_HOLIDAY"; $attendance->readable_status = "Govt Holiday"; }
                if($is_in_paid_leave > 0) { $attendance->status = "PAID_LEAVE"; $attendance->readable_status = "Leave";}
                if($is_in_general_leave > 0) { $attendance->readable_status = "Leave";}

                $attendance->save();
            }
        }

        $records = AttendanceRecord::select('attendances.date as base_date','employment_infos.employee_id as employee_id','attendances.actual_in_time','attendances.actual_out_time','attendances.status as attendance_status','attendances.readable_status as attendance_readable_status','attendance_records.id as attendance_record_id','attendances.id as attendance_id','attendance_records.time as base_time','attendance_records.record_type','attendance_policies.late_policy as allowed_late_policy','attendance_policies.late_mark as allowed_late_time','attendance_policies.late_absent_policy','attendance_policies.marks_absent_for as late_days_for_count_absent','attendance_policies.time_for_ot as ot_considering_time','attendance_policies.use_ot_round','attendance_policies.ot_round as ot_round_slab','attendances.in_time as today_in_time','attendances.work_in_govt_holiday','attendances.work_in_leave_day','payroll_infos.ot_allowed','payroll_infos.hourly_ot_rate','payroll_infos.mark_overtime_if_work_in_holiday','payroll_infos.mark_overtime_if_work_in_leave_day')
            ->join('employment_infos','employment_infos.id_in_biometric_machine','attendance_records.employee_id')
            ->join('payroll_infos','payroll_infos.employee_id','employment_infos.employee_id')
            ->join('attendances','attendances.employee_id','employment_infos.employee_id')
            ->join('attendance_policies','attendances.company_id','attendance_policies.company_id')
            ->where('attendance_records.company_id',$company_id)
            ->where('sync',0)
            ->get();

        foreach($records as $record) {
            $attendance = Attendance::where('id',$record->attendance_id)->first();
            $attendance->status = "PRESENT";
            $attendance->readable_status = "OK";

            if($record->record_type == "IN") {
                $in_time        = date('H:i:s',strtotime($record->base_time));
                $actual_in_time = date('H:i:s',strtotime($record->actual_in_time));

                $attendance->in_time = $in_time;

                // IF LATE
                if($record->attendance_readable_status != "Govt Holiday" && $record->attendance_readable_status != "Day Off" && $record->attendance_readable_status != "Leave") {
                    if ($in_time > $actual_in_time) {
                        $late_calculation = round(abs(strtotime($in_time) - strtotime($actual_in_time)) / 60);

                        // LATE ALLOWED TIME
                        if ($record->allowed_late_policy == 1) {
                            if ($late_calculation > $record->allowed_late_time) {
                                $attendance->late_over_allowed_time = 1;
                                $attendance->late = $late_calculation;
                                $attendance->readable_status = "Late";
                            }
                        } else {
                            $attendance->late_over_allowed_time = 1;
                            $attendance->late = $late_calculation;
                            $attendance->readable_status = "Late";
                        }

                        // DAY ABSENT FOR LATE
                        if ($record->late_absent_policy == 1) {
                            $late_days_for_count_absent = $record->late_days_for_count_absent;

                            $first_day_of_month = date('Y-m-01', strtotime($record->base_date));
                            $current_date = $record->base_date;

                            $data_of_late_days_till_today = Attendance::where('employee_id', $record->employee_id)
                                ->whereBetween('date', [$first_day_of_month, $current_date . " 23:59:59"])
                                ->where('late_over_allowed_time', 1)
                                ->where('punishment_processed', 0)
                                ->get();
                            $late_days_till_today = count($data_of_late_days_till_today);

                            if ($late_days_till_today >= ($late_days_for_count_absent - 1)) {
                                $attendance->status = "ABSENT";
                                $attendance->readable_status = "Absent";
                                $attendance->day_absent_for_late = 1;
                                $attendance->punishment_processed = 1;

                                foreach ($data_of_late_days_till_today as $row) {
                                    Attendance::where('id', $row->id)->update(['punishment_processed' => 1]);
                                }
                            }

                        }
                    }
                }

                // WORK IN HOLIDAY
                if($record->attendance_status == "GOVT_HOLIDAY") {
                    $attendance->work_in_govt_holiday = 1;
                }

                if($record->attendance_status == "WEEKLY_HOLIDAY" || $record->attendance_status == "PAID_LEAVE") {
                    $attendance->work_in_leave_day = 1;
                }

                if($record->attendance_readable_status == "Govt Holiday" || $record->attendance_readable_status == "Day Off" || $record->attendance_readable_status == "Leave") {
                    $attendance->late = 0;
                    $attendance->readable_status = "OK";
                }

                $attendance->save();
            }

            if($record->record_type == "OUT") {
                $in_time            = date('H:i:s',strtotime($record->today_in_time));
                $out_time           = date('H:i:s',strtotime($record->base_time));
                $actual_out_time    = date('H:i:s',strtotime($record->actual_out_time));

                $attendance->out_time = $out_time;

                // EARLY LEAVE
                if($out_time < $actual_out_time) {
                    $attendance->early_leave = round(abs(strtotime($actual_out_time) - strtotime($out_time)) / 60);
                }

                // TOTAL WORKING HOUR
                $attendance->total_working_hour = round(abs(strtotime($out_time) - strtotime($in_time)) / 60);

                // NORMAL OVERTIME CALCULATION
                if($record->ot_allowed == 1) {
                    $ot_considering_time = $record->ot_considering_time;

                    if($out_time > $actual_out_time) {
                        $today_over_time = round(abs(strtotime($out_time) - strtotime($actual_out_time)) / 60);
                    }else {
                        $today_over_time = 0;
                    }

                    if($today_over_time > $ot_considering_time) {
                        $is_round_slab_allowed = $record->use_ot_round;
                        if($is_round_slab_allowed == 1) {
                            $round_slab_value = $record->ot_round_slab;

                            if($today_over_time > 60) {
                                $extra_time = ($today_over_time % 60);
                            }else{
                                $extra_time = $today_over_time;
                            }

                            if($extra_time >= $round_slab_value) {
                                $attendance->over_time = ($today_over_time - $extra_time) + 60;
                                $attendance->over_time_round_slab = $round_slab_value;
                            }
                            else {
                                $attendance->over_time = $today_over_time;
                            }
                        }
                        else{
                            $attendance->over_time = $today_over_time;
                        }
                    }

                    // OVERTIME WORK IN HOLIDAY // JUMP
                    if($record->mark_overtime_if_work_in_holiday == 1) {
                        if($attendance->work_in_govt_holiday == 1) {
                            $attendance->over_time = round(abs(strtotime($out_time) - strtotime($in_time)) / 60);
                        }
                    }

                    if($record->mark_overtime_if_work_in_leave_day == 1) {
                        if($attendance->work_in_leave_day == 1) {
                            $attendance->over_time = round(abs(strtotime($out_time) - strtotime($in_time)) / 60);
                        }
                    }
                }

                $attendance->save();
            }

            AttendanceRecord::where('id',$record->attendance_record_id)->update(['sync' => 1]);
        }

        if($auto == "auto") {
            header('Location: '.get_biometric_redirect_url($company_id).'/zkteco-data-puller-v.1.0/sync_success.php');
        }else {
            header('Location: '.get_biometric_redirect_url($company_id).'/zkteco-data-puller-v.1.0/index.php');
        }
    }
}

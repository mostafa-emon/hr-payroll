@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/audit-trail-report')}}" style="color:#6c757d;">Audit Trail Report</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card">

                <div class="card-header">
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif

                    @if(session()->has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Audit Trail Report</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{url('audit-trail-report')}}" class="btn btn-info">Reset</a>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('audit-trail-report') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <label for="Remark" style="font-weight:bold;" class="col-form-label">Changes Made:</label>
                                <select class="form-control select2-no-search pa" name="changes_made">
                                    <option value="">All</option>
                                    <option value="Company" @if($changes_made == "Company") selected @endif>Company Setup -> Company</option>
                                    <option value="Department" @if($changes_made == "Department") selected @endif>Company Setup -> Department</option>
                                    <option value="Designation" @if($changes_made == "Designation") selected @endif>Company Setup -> Designation</option>
                                    <option value="Project" @if($changes_made == "Project") selected @endif>Company Setup -> Project</option>
                                    <option value="Branch" @if($changes_made == "Branch") selected @endif>Company Setup -> Branch</option>
                                    <option value="Currency" @if($changes_made == "Currency") selected @endif>Company Setup -> Currency</option>

                                    <option value="Employee" @if($changes_made == "Employee") selected @endif>Employee Setup -> Employee</option>
                                    <option value="User" @if($changes_made == "User") selected @endif>Employee Setup -> User</option>

                                    <option value="Leave Type" @if($changes_made == "Leave Type") selected @endif>Leave Setup -> Leave Type</option>

                                    <option value="Shift" @if($changes_made == "Shift") selected @endif>Attendance Setup -> Shift</option>
                                    <option value="Govt Holiday" @if($changes_made == "Govt Holiday") selected @endif>Attendance Setup -> Govt Holiday</option>
                                    <option value="Attendance Policy" @if($changes_made == "Attendance Policy") selected @endif>Attendance Setup -> Attendance Policy</option>

                                    <option value="Salary Component" @if($changes_made == "Salary Component") selected @endif>Payroll Setup -> Salary Component</option>
                                    <option value="Salary Transfer Letter Format" @if($changes_made == "Salary Transfer Letter Format") selected @endif>Payroll Setup -> Salary Transfer Letter Format</option>
                                    <option value="OT Transfer Letter Format" @if($changes_made == "OT Transfer Letter Format") selected @endif>Payroll Setup -> OT Transfer Letter Format</option>
                                    <option value="Payroll Bank" @if($changes_made == "Payroll Bank") selected @endif>Payroll Setup -> Payroll Bank</option>

                                    <option value="Leave Request" @if($changes_made == "Leave Request") selected @endif>Leave -> Leave Request</option>
                                    <option value="Leave Balance Transfer" @if($changes_made == "Leave Balance Transfer") selected @endif>Leave -> Leave Balance Transfer</option>

                                    <option value="Roster" @if($changes_made == "Roster") selected @endif>Attendance -> Roster</option>
                                    <option value="Manual Log Entry" @if($changes_made == "Manual Log Entry") selected @endif>Attendance -> Manual Log Entry</option>

                                    <option value="Earnings Deductions Adjustment" @if($changes_made == "Earnings Deductions Adjustment") selected @endif>Payroll -> Earnings Deductions Adjustment</option>
                                    <option value="Absent Deduction" @if($changes_made == "Absent Deduction") selected @endif>Payroll -> Absent Deduction</option>
                                    <option value="Create Salary Sheet" @if($changes_made == "Create Salary Sheet") selected @endif>Payroll -> Create Salary Sheet</option>
                                    <option value="Create Salary Transfer Letter" @if($changes_made == "Create Salary Transfer Letter") selected @endif>Payroll -> Create Salary Transfer Letter</option>
                                    <option value="Create OT Transfer Letter" @if($changes_made == "Create OT Transfer Letter") selected @endif>Payroll -> Create OT Transfer Letter</option>
                                    <option value="PF" @if($changes_made == "PF") selected @endif>Payroll -> PF</option>
                                    <option value="Deposit Salary Tax" @if($changes_made == "Deposit Salary Tax") selected @endif>Payroll -> Deposit Salary Tax</option>
                                    <option value="Gratuity" @if($changes_made == "Gratuity") selected @endif>Payroll -> Gratuity</option>

                                    <option value="General Settings" @if($changes_made == "General Settings") selected @endif>General Settings</option>
                                    <option value="SMS Setting" @if($changes_made == "SMS Setting") selected @endif>SMS Setting</option>
                                    <option value="SMTP Setting" @if($changes_made == "SMTP Setting") selected @endif>SMTP Setting</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="Remark" style="font-weight:bold;" class="col-form-label">From Date:</label>
                                <input type="text" class="form-control dtpicker" name="from_date" value="{{date('d-m-Y',strtotime($from_date))}}"placeholder="From Date" autocomplete="off" required>
                            </div>
                            <div class="col-md-4">
                                <label for="Remark" style="font-weight:bold;" class="col-form-label">To Date:</label>
                                <input type="text" class="form-control dtpicker" name="to_date" value="{{date('d-m-Y',strtotime($to_date))}}" placeholder="To Date" autocomplete="off" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                    </form>

                </div>

                @if(count($audits) > 0)
                <div class="card-body" id="printArea">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th style="text-align:center;vertical-align:middle;width:5%;">Date Time</th>
                                    <th style="vertical-align:middle;width:5%;">User Name</th>
                                    <th style="vertical-align:middle;width:5%;">Changes Made</th>
                                    <th style="vertical-align:middle;width:5%;">Event</th>
                                    <th style="vertical-align:middle;width:40%;">Old Value</th>
                                    <th style="vertical-align:middle;width:40%;">New Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($audits as $audit)
                                <tr>
                                    <td style="text-align:center;vertical-align:middle;">{{date('d M Y h:i A',strtotime($audit->created_at))}}</td>
                                    <td style="vertical-align:middle;">{{$audit->user_name}}</td>
                                    <td style="vertical-align:middle;">
                                        @if($audit->auditable_type == "App\Email") SMTP Setting
                                        @elseif($audit->auditable_type == "App\Company") Company Setup -> Company
                                        @elseif($audit->auditable_type == "App\Department") Company Setup -> Department
                                        @elseif($audit->auditable_type == "App\Designation") Company Setup -> Designation
                                        @elseif($audit->auditable_type == "App\Project") Company Setup -> Project
                                        @elseif($audit->auditable_type == "App\Branch") Company Setup -> Branch
                                        @elseif($audit->auditable_type == "App\Currency") Company Setup -> Currency
                                        @elseif($audit->auditable_type == "App\Employee" || $audit->auditable_type == "App\EmploymentInfo" || $audit->auditable_type == "App\EmployeeEarningDeduction" || $audit->auditable_type == "App\PayrollInfo" || $audit->auditable_type == "App\LeaveInfo") Employee Setup -> Employee
                                        @elseif($audit->auditable_type == "App\User") Employee Setup -> User
                                        @elseif($audit->auditable_type == "App\LeaveType") Leave Setup -> Leave Type
                                        @elseif($audit->auditable_type == "App\ShiftType") Attendance Setup -> Shift
                                        @elseif($audit->auditable_type == "App\GovtHoliday") Attendance Setup -> Govt Holiday
                                        @elseif($audit->auditable_type == "App\AttendancePolicy") Attendance Setup -> Attendance Policy
                                        @elseif($audit->auditable_type == "App\SalaryComponent") Payroll Setup -> Salary Component
                                        @elseif($audit->auditable_type == "App\SalaryTransferLetterFormat") Payroll Setup -> Salary Transfer Letter Format
                                        @elseif($audit->auditable_type == "App\OtTransferLetterFormat") Payroll Setup -> OT Transfer Letter Format
                                        @elseif($audit->auditable_type == "App\PayrollBank" || $audit->auditable_type == "App\PayrollBranch") Payroll Setup -> Payroll Bank
                                        @elseif($audit->auditable_type == "App\LeaveRequest") Leave -> Leave Request
                                        @elseif($audit->auditable_type == "App\LeaveBalance") Leave -> Leave Balance Transfer
                                        @elseif($audit->auditable_type == "App\Roster" || $audit->auditable_type == "App\RosterEmployee") Attendance -> Roster
                                        @elseif($audit->auditable_type == "App\Attendance") Attendance -> Manual Log Entry
                                        @elseif($audit->auditable_type == "App\EarningDeductionAdjustment") Payroll -> Earnings Deductions Adjustment
                                        @elseif($audit->auditable_type == "App\AbsentDeduction") Payroll -> Absent Deduction
                                        @elseif($audit->auditable_type == "App\SalarySheet") Payroll -> Create Salary Sheet
                                        @elseif($audit->auditable_type == "App\SalaryTransferLetter") Payroll -> Create Salary Transfer Letter
                                        @elseif($audit->auditable_type == "App\OTTransferLetter") Payroll -> Create OT Transfer Letter
                                        @elseif($audit->auditable_type == "App\ProvidentFund") Payroll -> PF
                                        @elseif($audit->auditable_type == "App\DepositSalaryTax") Payroll -> Deposit Salary Tax
                                        @elseif($audit->auditable_type == "App\Gratuity" )Payroll -> Gratuity
                                        @elseif($audit->auditable_type == "App\GeneralSetting") General Settings
                                        @elseif($audit->auditable_type == "App\SmsSetting") Sms Setting
                                        @endif
                                    </td>
                                    <td style="vertical-align:middle;">{{$audit->event}}</td>
                                    <td style="vertical-align:middle;">{{$audit->old_values}}</td>
                                    <td style="vertical-align:middle;">{{$audit->new_values}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                
            </div>
        </div>

    </div>

    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            font-family:arial;
            font-size:13px;
            padding:5px;
        }
    </style>
    
    <script>

        function printElem(){
            var mywindow = window.open('', 'PRINT');
            mywindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid black;font-family:arial;font-size:13px;padding:7px;} .div-padding-30{padding:30px;}</style>');
            mywindow.document.write(document.getElementById('printArea').innerHTML);

            setTimeout(function () {
                mywindow.focus();
                mywindow.print();
                mywindow.close();

                //window.location = "/mr"
            }, 1000);
        }
    </script>

@endsection
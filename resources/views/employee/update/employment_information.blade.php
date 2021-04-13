<section>
    <form action="{{url('employee/update-employment-info/'.$info_id)}}" method="POST">
        {{ csrf_field() }}

        @php 
            $datepicker_format = datepicker_format();
            $date_format = 'd-m-Y';
            
            if($datepicker_format == "MM-DD-YYYY") {
                $date_format = 'm-d-Y';
            }else if($datepicker_format == "YYYY/MM/DD") {
                $date_format = 'Y/m/d';
            }else if($datepicker_format == "DD-MMM-YY") {
                $date_format = 'd-M-y';
            }
        @endphp

        <div class="row row-xs">
            <div class="col-md-3 pd-t-10">
                <label for="department_id" style="font-weight:bold;" class="col-form-label">Department*:</label>
                <select class="form-control" name="department_id" required>
                    <option value="" label>Select Department*</option>
                    @foreach($departments as $department)
                        <option value="{{$department->id}}" @if($employment_info != "" && $department->id == $employment_info->department_id) selected @endif>{{$department->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="designation_id" style="font-weight:bold;" class="col-form-label">Designation*:</label>
                <select class="form-control" name="designation_id" required>
                    <option value="" label>Select Designation*</option>
                    @foreach($designations as $designation)
                        <option value="{{$designation->id}}" @if($employment_info != "" && $designation->id == $employment_info->designation_id) selected @endif>{{$designation->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="project_id" style="font-weight:bold;" class="col-form-label">Project:</label>
                <select class="form-control" name="project_id">
                    <option value="" label>Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{$project->id}}" @if($employment_info != "" && $project->id == $employment_info->project_id) selected @endif>{{$project->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="branch_id" style="font-weight:bold;" class="col-form-label">Branch:</label>
                <select class="form-control" name="branch_id">
                    <option value="" label>Select Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{$branch->id}}" @if($employment_info != "" && $branch->id == $employment_info->branch_id) selected @endif>{{$branch->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="status" style="font-weight:bold;" class="col-form-label">Status*:</label>
                <select class="form-control" name="current_status" required>
                    <option value="" label>Select Status*</option>
                    <option value="Active" @if($employment_info != "" && $employment_info->current_status == "Active") selected @endif>Active</option>
                    <option value="Inactive" @if($employment_info != "" && $employment_info->current_status == "Inactive") selected @endif>Inactive</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="date_of_joining" style="font-weight:bold;" class="col-form-label">Date of Joining*:</label>
                <input type="text" name="date_of_joining" placeholder="Date of Joining*" @if($employment_info !="" && $employment_info->date_of_joining != "" && $employment_info->date_of_joining != "1970-01-01") value="{{ date($date_format,strtotime($employment_info->date_of_joining))}}" @endif class="form-control dtpicker" autocomplete="off" required/>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="date_of_confirmation" style="font-weight:bold;" class="col-form-label">Date of Confirmation*:</label>
                <input type="text" name="date_of_confirmation" placeholder="Date of Confirmation*" @if($employment_info !="" && $employment_info->date_of_confirmation != "" && $employment_info->date_of_confirmation != "1970-01-01") value="{{ date($date_format,strtotime($employment_info->date_of_confirmation))}}" @endif class="form-control dtpicker" autocomplete="off" required/>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="duty_type" style="font-weight:bold;" class="col-form-label">Duty Type*:</label>
                <select class="form-control" name="duty_type" required>
                    <option value="" label>Select Duty Type*</option>
                    <option value="Roster" @if($employment_info != "" && $employment_info->duty_type == "Roster") selected @endif>Roster</option>
                    <option value="Non-Roster" @if($employment_info != "" && $employment_info->duty_type == "Non-Roster") selected @endif>Non-Roster</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="date_of_resign" style="font-weight:bold;" class="col-form-label">Date of Resign:</label>
                <input type="text" name="date_of_resign" placeholder="Date of Resign" @if($employment_info !="" && $employment_info->date_of_resign != "" && $employment_info->date_of_resign != "1970-01-01") value="{{ date($date_format,strtotime($employment_info->date_of_resign))}}" @endif class="form-control dtpicker" autocomplete="off"/>
            </div>

            <div class="col-md-9 pd-t-10">
                <label for="reason_for_resign" style="font-weight:bold;" class="col-form-label">Reason for Resign:</label>
                <input type="text" name="reason_for_resign" placeholder="Reason for Resign" @if($employment_info !="" && $employment_info->reason_for_resign != "") value="{{$employment_info->reason_for_resign}}" @endif class="form-control"/>
                <input type="hidden" name="employee_id" placeholder="Employee ID" class="form-control" value="@if($employee_id != ""){{$employee_id}}@endif">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="terminated" style="font-weight:bold;" class="col-form-label">Terminated:</label>
                <select class="form-control" name="terminated">
                    <option value="" label>Select Termination</option>
                    <option value="Yes" @if($employment_info != "" && $employment_info->terminated == "Yes") selected @endif>Yes</option>
                    <option value="No" @if($employment_info != "" && $employment_info->terminated == "No") selected @endif>No</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="date_of_termination" style="font-weight:bold;" class="col-form-label">Date of Termination:</label>
                <input type="text" name="date_of_termination" placeholder="Date of Termination" @if($employment_info !="" && $employment_info->date_of_termination != "" && $employment_info->date_of_termination != "1970-01-01") value="{{ date($date_format,strtotime($employment_info->date_of_termination))}}" @endif class="form-control dtpicker" autocomplete="off"/>
            </div>

            <div class="col-md-6 pd-t-10">
                <label for="Reason for Termination" style="font-weight:bold;" class="col-form-label">Reason for Termination:</label>
                <input type="text" name="reason_for_termination" placeholder="Reason for Termination" @if($employment_info !="" && $employment_info->reason_for_termination != "") value="{{$employment_info->reason_for_termination}}" @endif class="form-control"/>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="salary payment method*" style="font-weight:bold;" class="col-form-label">Salary Payment Method*:</label>
                <select class="form-control" name="salary_payment_method" required>
                    <option value="" label>Select Salary Payment Method*</option>
                    <option value="Bank" @if($employment_info != "" && $employment_info->salary_payment_method == "Bank") selected @endif>Bank</option>
                    <option value="Cash" @if($employment_info != "" && $employment_info->salary_payment_method == "Cash") selected @endif>Cash</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="Bank" style="font-weight:bold;" class="col-form-label">Bank:</label>
                <select id="bank_name" name="bank_name" onchange="getBranch(this.value)" class="form-control select2-no-search">
                    <option label="Choose Bank"></option>
                    @foreach($banks as $bank)
                        <option value="{{$bank->id}}" @if($employment_info != "" && $bank->id == $employment_info->bank_name) selected @endif>{{$bank->bank_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="Branch" style="font-weight:bold;" class="col-form-label">Branch:</label>
                <select id="branch" name="bank_branch_id" class="form-control select2-no-search">
                    <option label="Choose Branch"></option>
                    @foreach($bank_branches as $branch)
                        <option value="{{$branch->id}}" @if($employment_info != "" && $branch->id == $employment_info->bank_branch_id) selected @endif>{{$branch->branch_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="bank_account_no" style="font-weight:bold;" class="col-form-label">Bank Account No:</label>
                <input type="text" name="bank_account_no" placeholder="Bank Account No" @if($employment_info !="" && $employment_info->bank_account_no != "") value="{{$employment_info->bank_account_no}}" @endif class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="pay_slip_send_method" style="font-weight:bold;" class="col-form-label">Pay Slip Send Method*:</label>
                <select class="form-control" name="pay_slip_send_method" required>
                    <option value="" label>Select Pay Slip Send Method*</option>
                    <option value="Email" @if($employment_info != "" && $employment_info->pay_slip_send_method == "Email") selected @endif>Email</option>
                    <option value="Print" @if($employment_info != "" && $employment_info->pay_slip_send_method == "Print") selected @endif>Print</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="weekend one" style="font-weight:bold;" class="col-form-label">Weekend One:</label>
                <select class="form-control" name="weekend_1">
                    <option value="" label>Select Weekend One</option>
                    <option value="Saturday" @if($employment_info != "" && $employment_info->weekend_1 == "Saturday") selected @endif>Saturday</option>
                    <option value="Sunday" @if($employment_info != "" && $employment_info->weekend_1 == "Sunday") selected @endif>Sunday</option>
                    <option value="Monday" @if($employment_info != "" && $employment_info->weekend_1 == "Monday") selected @endif>Monday</option>
                    <option value="Tuesday" @if($employment_info != "" && $employment_info->weekend_1 == "Tuesday") selected @endif>Tuesday</option>
                    <option value="Wednesday" @if($employment_info != "" && $employment_info->weekend_1 == "Wednesday") selected @endif>Wednesday</option>
                    <option value="Thursday" @if($employment_info != "" && $employment_info->weekend_1 == "Thursday") selected @endif>Thursday</option>
                    <option value="Friday" @if($employment_info != "" && $employment_info->weekend_1 == "Friday") selected @endif>Friday</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="weekend two" style="font-weight:bold;" class="col-form-label">Weekend Two:</label>
                <select class="form-control" name="weekend_2">
                    <option value="" label>Select Weekend Two</option>
                    <option value="Saturday" @if($employment_info != "" && $employment_info->weekend_2 == "Saturday") selected @endif>Saturday</option>
                    <option value="Sunday" @if($employment_info != "" && $employment_info->weekend_2 == "Sunday") selected @endif>Sunday</option>
                    <option value="Monday" @if($employment_info != "" && $employment_info->weekend_2 == "Monday") selected @endif>Monday</option>
                    <option value="Tuesday" @if($employment_info != "" && $employment_info->weekend_2 == "Tuesday") selected @endif>Tuesday</option>
                    <option value="Wednesday" @if($employment_info != "" && $employment_info->weekend_2 == "Wednesday") selected @endif>Wednesday</option>
                    <option value="Thursday" @if($employment_info != "" && $employment_info->weekend_2 == "Thursday") selected @endif>Thursday</option>
                    <option value="Friday" @if($employment_info != "" && $employment_info->weekend_2 == "Friday") selected @endif>Friday</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="id_in_biometric_machine" style="font-weight:bold;" class="col-form-label">ID in Biometric Machine:</label>
                <input type="text" name="id_in_biometric_machine" placeholder="ID in Biometric Machine" @if($employment_info !="" && $employment_info->id_in_biometric_machine != "") value="{{$employment_info->id_in_biometric_machine}}" @endif class="form-control">
            </div>

            <div class="col-md-3 pd-t-10"></div>

        </div>
        <div class="row">
            <div class="col-md-12 pd-t-10 text-right">
                <input type="submit" value="Update & Next" class="btn btn-primary"/>
            </div>
        </div>
    </form>
</section>
<section>
    <form action="{{url('employee/add-employment-info')}}" method="POST">
        {{ csrf_field() }}
        <div class="row row-xs">
            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="department_id" required>
                    <option value="" label>Department*</option>
                    @foreach($departments as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="designation_id" required>
                    <option value="" label>Designation*</option>
                    @foreach($designations as $designation)
                        <option value="{{$designation->id}}">{{$designation->name}}</option>
                    @endforeach
                </select>
            </div>



            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="current_status" required>
                    <option value="" label>Status*</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="date_of_joining" placeholder="Date of Joining*" class="form-control dtpicker" autocomplete="off" required/>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="date_of_confirmation" placeholder="Date of Confirmation*" class="form-control dtpicker" autocomplete="off" required/>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="duty_type" required>
                    <option value="" label>Duty Type*</option>
                    <option value="Roster">Roster</option>
                    <option value="Non-Roster">Non-Roster</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="date_of_resign" placeholder="Date of Resign" class="form-control dtpicker" autocomplete="off"/>
            </div>

            <div class="col-md-9 pd-t-10">
                <input type="text" name="reason_for_resign" placeholder="Reason for Resign" class="form-control"/>
                <input type="hidden" name="employee_id" placeholder="Employee ID" class="form-control" value="@if($employee_id != ""){{$employee_id}}@endif">
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="terminated">
                    <option value="" label>Terminated</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="date_of_termination" placeholder="Date of Termination" class="form-control dtpicker" autocomplete="off"/>
            </div>

            <div class="col-md-6 pd-t-10">
                <input type="text" name="reason_for_termination" placeholder="Reason for Termination" class="form-control"/>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="salary_payment_method" required>
                    <option value="" label>Salary Payment Method*</option>
                    <option value="Bank">Bank</option>
                    <option value="Cash">Cash</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                {{--<input type="text" name="bank_name" placeholder="Bank Name" class="form-control">--}}
                <select id="bank_name" name="bank_name" onchange="getBranch(this.value)" class="form-control select2-no-search">
                    <option label="Choose Bank"></option>
                    @foreach($banks as $bank)
                        <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <select id="branch" name="bank_branch_id" class="form-control select2-no-search">
                    <option label="Choose Branch"></option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="bank_account_no" placeholder="Bank Account No" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="pay_slip_send_method" required>
                    <option value="" label>Pay Slip Send Method*</option>
                    <option value="Email">Email</option>
                    <option value="Print">Print</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="weekend_1">
                    <option value="" label>Weekend One</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="weekend_2">
                    <option value="" label>Weekend Two</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="id_in_biometric_machine" placeholder="ID in Biometric Machine" class="form-control">
            </div>

            <div class="col-md-12 pd-t-10">
                <input type="submit" value="Submit" class="btn btn-primary"/>
            </div>
        </div>
    </form>
</section>
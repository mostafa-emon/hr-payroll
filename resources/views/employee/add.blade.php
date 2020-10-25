@extends('layouts.master')

@section('content')
    <style>
        .tabcontent { display: none; }
        .tablinks { cursor: pointer; }
    </style>

    <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('/employee')}}" style="color:#6c757d;">Employees</a></li>
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
                    
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Create Employee</h4>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{url('employee/add')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        <div id="wizard3" class="wizard clearfix vertical">
                            <div class="steps clearfix">
                                <ul role="tablist">
                                    <li id="PersonalTab" class="current tablinks">
                                        <a onclick="openTab('Personal')">
                                            <span class="current-info audible">current step: </span>
                                            <span class="number">1</span> 
                                            <span class="title">Personal Information</span>
                                        </a>
                                    </li>
                                    <li id="EmploymentTab" class="tablinks">
                                        <a onclick="openTab('Employment')">
                                            <span class="number">2</span> 
                                            <span class="title">Employment Information</span>
                                        </a>
                                    </li>
                                    <li id="PayrollTab" class="tablinks">
                                        <a onclick="openTab('Payroll')">
                                            <span class="number">3</span> 
                                            <span class="title">Payroll Information</span>
                                        </a>
                                    </li>
                                    <li id="LeaveTab" class="tablinks">
                                        <a onclick="openTab('Leave')">
                                            <span class="number">3</span> 
                                            <span class="title">Leave Information</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="content clearfix">
                                <section id="Personal" class="body tabcontent" style="display:block">
                                    <h3 class="title">Personal Information</h3>
                                    <div>
                                        <img class="pointer" style="margin-bottom:10px" id="avatar" src="{{ asset('assets/img/users.png') }}" width="80" alt="employee" onclick="document.getElementById('imgInp').click()"/>
                                        <input class="collapse" type="file" name="avatar" id="imgInp" onchange="preview_image(event)" />
                                    </div>
                                    <div class="row row-xs">
                                        <div class="col-md-3 pd-t-10">
                                          <input type="text" name="employee_id" placeholder="Employee ID" class="form-control">
                                        </div>
                    
                                        <div class="col-md-9 pd-t-10">
                                            <input type="text" name="name" placeholder="Employee Name" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="father_name" placeholder="Father Name" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="mother_name" placeholder="Mother Name" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="marital_status">
                                                <option value="Unmarried">Unmarried</option>
                                                <option value="Married">Married</option>
                                                <option value="Divorced">Divorced</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="spouse_name" placeholder="Spouse Name" class="form-control">
                                        </div>
                    
                                        <div class="col-md-6 pd-t-10">
                                          <input type="text" name="present_address" placeholder="Present Address" class="form-control">
                                        </div>
                    
                                        <div class="col-md-6 pd-t-10">
                                            <input type="text" name="permanent_address" placeholder="Permanent Address" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="date_of_birth" placeholder="Date of Birth" class="form-control dtpicker" autocomplete="off"/>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="gender">
                                                <option value="" label>gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="religion">
                                                <option value="" label>religion</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Christianity">Christianity</option>
                                                <option value="Hinduism">Hinduism</option>
                                                <option value="Buddhism">Buddhism</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="blood_group">
                                                <option value="" label>blood group</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="nationality" placeholder="Nationality" value="Bangladeshi" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="nid_no" placeholder="NID Number" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="passport_no" placeholder="Passport Number" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="tin_no" placeholder="TIN Number" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="phone_1" placeholder="Phone Number 1" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="phone_2" placeholder="Phone Number 2" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="emergency_contact_person" placeholder="Emergency Contact Person" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="emergency_phone_number" placeholder="Emergency Phone Number" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="email" name="email_address" placeholder="Email Address" class="form-control">
                                        </div>

                                        @if(document_upload_facility(Auth::user()->company_id) == 1)
                                        <div class="col-md-3 pd-t-20 text-right">
                                            Upload CV
                                        </div>
                                        <div class="col-md-6 pd-t-10">
                                            <input class="form-control" name="employee_cv" type="file">
                                        </div>
                                        @else
                                        <div class="col-md-9"></div>
                                        @endif

                                        <div class="col-md-6 pd-t-10">
                                            <textarea class="form-control" name="reference_1" style="height:100px" placeholder="Reference 1"></textarea>
                                        </div>
                                        <div class="col-md-6 pd-t-10">
                                            <textarea class="form-control" name="reference_1" style="height:100px" placeholder="Reference 2"></textarea>
                                        </div>
                                    </div>
                                </section>
                                <section id="Employment" class="body tabcontent">
                                    <h3 class="title">Employment Information</h3>
                                    <div class="row row-xs">
                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="department_id">
                                                <option value="" label>department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="designation_id">
                                                <option value="" label>designation</option>
                                                @foreach($designations as $designation)
                                                    <option value="{{$designation->id}}">{{$designation->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="project_id">
                                                <option value="" label>project</option>
                                                @foreach($projects as $project)
                                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="branch_id">
                                                <option value="" label>branch</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="current_status">
                                                <option value="" label>status</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="date_of_joining" placeholder="Date of Joining" class="form-control dtpicker" autocomplete="off"/>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="date_of_confirmation" placeholder="Date of Confirmation" class="form-control dtpicker" autocomplete="off"/>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="duty_type">
                                                <option value="" label>duty type</option>
                                                <option value="Roster">Roster</option>
                                                <option value="Non-Roster">Non-Roster</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="date_of_resign" placeholder="Date of Resign" class="form-control dtpicker" autocomplete="off"/>
                                        </div>

                                        <div class="col-md-9 pd-t-10">
                                            <input type="text" name="reason_for_resign" placeholder="Reason for Resign" class="form-control"/>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="terminated">
                                                <option value="" label>terminated</option>
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
                                            <select class="form-control" name="salary_payment_method">
                                                <option value="" label>salary payment method</option>
                                                <option value="Bank">Bank</option>
                                                <option value="Cash">Cash</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            {{--<input type="text" name="bank_name" placeholder="Bank Name" class="form-control">--}}
                                            <select id="bank_name" name="bank_name" onchange="getBranch(this.value)" class="form-control select2-no-search" required>
                                                <option label="Choose Bank"></option>
                                                @foreach($banks as $bank)
                                                    <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select id="branch" name="branch_id" class="form-control select2-no-search" required>
                                                <option label="Choose Branch"></option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <input type="text" name="bank_account_no" placeholder="Bank Account No" class="form-control">
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="pay_slip_send_method">
                                                <option value="" label>pay slip send method</option>
                                                <option value="Email">Email</option>
                                                <option value="Print">Print</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 pd-t-10">
                                            <select class="form-control" name="weekend_1">
                                                <option value="" label>weekend one</option>
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
                                                <option value="" label>weekend two</option>
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </section>
                                <section id="Payroll" class="body tabcontent">
                                    <h3 class="title">Payroll Information</h3>
                                </section>
                                <section id="Leave" class="body tabcontent">
                                    <h3 class="title">Leave Information</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="submit" value="Submit" class="btn btn-primary"/>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="actions clearfix"></div>
                        </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>

    </div>

    <script>
        function getBranch(value) {
            $.ajax({
                type: 'GET',
                url: '/get-payroll-branch/'+value,
                success:function(data) {
                    $('#branch').html('');
                    $('#branch').append('<option value="" selected>Choose Branch</option>');
                    $('#branch').append(data);
                }
            });
        }

        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function()
            {
              var output = document.getElementById('avatar');
              output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function openTab(eventName) {
            if(eventName == "Personal") {
                $('#PersonalTab').addClass('current'); $('#EmploymentTab').removeClass('current'); $('#PayrollTab').removeClass('current'); $('#LeaveTab').removeClass('current'); 
                $('#Personal').show(); $('#Employment').hide(); $('#Payroll').hide(); $('#Leave').hide();
            }
            else if(eventName == "Employment") {
                $('#PersonalTab').removeClass('current'); $('#EmploymentTab').addClass('current'); $('#PayrollTab').removeClass('current'); $('#LeaveTab').removeClass('current'); 
                $('#Personal').hide(); $('#Employment').show(); $('#Payroll').hide(); $('#Leave').hide();
            }
            else if(eventName == "Payroll") {
                $('#PersonalTab').removeClass('current'); $('#EmploymentTab').removeClass('current'); $('#PayrollTab').addClass('current'); $('#LeaveTab').removeClass('current'); 
                $('#Personal').hide(); $('#Employment').hide(); $('#Payroll').show(); $('#Leave').hide();
            }
            else if(eventName == "Leave") {
                $('#PersonalTab').removeClass('current'); $('#EmploymentTab').removeClass('current'); $('#PayrollTab').removeClass('current'); $('#LeaveTab').addClass('current'); 
                $('#Personal').hide(); $('#Employment').hide(); $('#Payroll').hide(); $('#Leave').show();
            }
        }
    </script>
@endsection
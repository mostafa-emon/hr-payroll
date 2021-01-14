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
                            <h4 class="card-title mg-b-0">Update Employee</h4>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div id="wizard1" role="application" class="wizard clearfix">
                            <div class="steps clearfix">
                               <ul role="tablist">
                                  <li role="tab" class="@if($page == "personal") current @endif" aria-disabled="false" aria-selected="true">
                                     <a href="{{url('/employee/update/personal/'.$employee->id)}}">
                                        <span class="number">1</span> 
                                        <span class="title">Personal Information</span>
                                     </a>
                                  </li>
                                  <li role="tab" class="@if($page == "employment") current @endif" aria-disabled="true">
                                     <a href="{{url('/employee/update/employment/'.$employee->id)}}">
                                        <span class="number">2</span> 
                                        <span class="title">Employement Information</span>
                                     </a>
                                  </li>
                                  <li role="tab" class="@if($page == "payroll") current @endif" aria-disabled="true">
                                     <a href="{{url('/employee/update/payroll/'.$employee->id)}}">
                                        <span class="number">3</span> 
                                        <span class="title">Payroll Information</span>
                                     </a>
                                  </li>
                                  <li role="tab" class="@if($page == "leave") current @endif" aria-disabled="true">
                                    <a href="{{url('/employee/update/leave/'.$employee->id)}}">
                                        <span class="number">4</span> 
                                        <span class="title">Leave Information</span>
                                    </a>
                                 </li>
                               </ul>
                            </div>
                            <div class="content clearfix">
                                @if($page == "personal")
                                    @include('employee.update.personal_information')
                                @elseif($page == "employment")
                                    @include('employee.update.employment_information')
                                @elseif($page == "payroll")
                                    @include('employee.update.payroll_information')
                                @elseif($page == "leave")
                                    @include('employee.update.leave_information')
                                @endif
                            </div>
                         </div>
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
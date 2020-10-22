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
                        <div id="wizard3" class="wizard clearfix vertical">
                            <div class="steps clearfix">
                                <ul role="tablist">
                                    <li id="londonTab" class="current tablinks">
                                        <a onclick="openTab('London')">
                                            <span class="current-info audible">current step: </span>
                                            <span class="number">1</span> 
                                            <span class="title">Personal Information</span>
                                        </a>
                                    </li>
                                    <li id="parisTab" class="tablinks">
                                        <a onclick="openTab('Paris')">
                                            <span class="number">2</span> 
                                            <span class="title">Billing Information</span>
                                        </a>
                                    </li>
                                    <li id="tokyoTab" class="tablinks">
                                        <a onclick="openTab('Tokyo')">
                                            <span class="number">3</span> 
                                            <span class="title">Payment Details</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="content clearfix">
                                <section id="London" class="body tabcontent" style="display:block">
                                    <h3 class="title">Personal Information</h3>
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
                                <section id="Paris" class="body tabcontent">
                                    <h3 class="title">Billing Information</h3>
                                    <div class="table-responsive mg-t-20">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Cart Subtotal</td>
                                                    <td class="text-right">$792.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                                <section id="Tokyo" class="body tabcontent">
                                    <h3 class="title">Payment Details</h3>
                                    <div class="form-group">
                                        <label class="form-label">CardHolder Name</label>
                                        <input type="text" class="form-control" id="name12" placeholder="First Name">
                                    </div>
                                </section>
                            </div>
                            <div class="actions clearfix"></div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>

    </div>

    <script>
        function openTab(eventName) {
            if(eventName == "London") {
                $('#londonTab').addClass('current'); $('#parisTab').removeClass('current'); $('#tokyoTab').removeClass('current'); 
                $('#London').show(); $('#Paris').hide(); $('#Tokyo').hide();
            }
            else if(eventName == "Paris") {
                $('#parisTab').addClass('current'); $('#londonTab').removeClass('current'); $('#tokyoTab').removeClass('current'); 
                $('#Paris').show(); $('#London').hide(); $('#Tokyo').hide();
            }
            else if(eventName == "Tokyo") {
                $('#tokyoTab').addClass('current'); $('#londonTab').removeClass('current'); $('#parisTab').removeClass('current'); 
                $('#Tokyo').show(); $('#London').hide(); $('#Paris').hide();
            }
        }
    </script>
@endsection
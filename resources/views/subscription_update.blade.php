@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('company-register')}}" style="color:#6c757d;">Subscription / Add</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card box-shadow-0">
              <div class="card-header">
                <h4 class="card-title mb-1">Company Info</h4>
              </div>
              <div class="card-body pd-t-0">
                <form class="form-horizontal" action="{{url('/subscription/update/'.$company_info->id)}}" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div>
                      @if(isset($company_info) && $company_info->logo != "")
                          <img class="pointer" style="margin-bottom:10px" id="logo" src="{{ asset('storage/'.$company_info->logo) }}" width="80" alt="logo" onclick="document.getElementById('imgInp').click()"/>
                      @else
                          <img class="pointer" style="margin-bottom:10px" id="logo" src="{{ asset('assets/img/logo-placeholder.png') }}" width="80" alt="logo" onclick="document.getElementById('imgInp').click()"/>
                      @endif
                  </div>
                  <a onclick="document.getElementById('imgInp').click()" class="pointer wd-120 btn btn-secondary btn-sm text-white">Choose</a>
                  <input class="collapse" type="file" name="logo" id="imgInp" onchange="preview_image(event)" />

                  <div class="row row-xs">
                    <div class="col-md-3 pd-t-10">
                      <input id="name" type="text" name="name" placeholder="Company Name" class="form-control" value="{{$company_info->name}}" required>
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="phone" type="text" name="phone" placeholder="Phone" class="form-control" value="{{$company_info->phone}}">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="fax" type="text" name="fax" placeholder="Fax" class="form-control" value="{{$company_info->fax}}">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="email" type="text" name="email" placeholder="Email" class="form-control" value="{{$company_info->email}}">
                    </div>

                    <div class="col-md-6 pd-t-10">
                      <input id="address_line_1" type="text" name="address_line_1" placeholder="Address Line 1" class="form-control" value="{{$company_info->address_line_1}}">
                    </div>

                    <div class="col-md-6 pd-t-10">
                      <input id="address_line_2" type="text" name="address_line_2" placeholder="Address Line 2" class="form-control" value="{{$company_info->address_line_2}}">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="bin" type="text" name="bin" placeholder="BIN Number" class="form-control" value="{{$company_info->bin}}">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="tin" type="text" name="tin" placeholder="TIN Number" class="form-control" value="{{$company_info->tin}}">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="ein" type="text" name="ein" placeholder="EIN Number" class="form-control" value="{{$company_info->ein}}">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="vat_reg_no" type="text" name="vat_reg_no" placeholder="VAT Registration Number" class="form-control" value="{{$company_info->vat_reg_no}}">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="website" type="text" name="website" placeholder="Website" class="form-control" value="{{$company_info->website}}">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <select name="currency_id" class="form-control" required>
                        <option value="" label>Currency</option>
                        @foreach($currency as $cur)
                          <option value="{{$cur->id}}" @if($company_info->currency_id == $cur->id) selected @endif>{{$cur->currency_name}}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <select name="leave_year_from" class="form-control">
                        <option value="" label>Leave year from</option>
                        <option value="1" @if($company_info->leave_year_from == 1) selected @endif>January</option>
                        <option value="2" @if($company_info->leave_year_from == 2) selected @endif>February</option>
                        <option value="3" @if($company_info->leave_year_from == 3) selected @endif>March</option>
                        <option value="4" @if($company_info->leave_year_from == 4) selected @endif>April</option>
                        <option value="5" @if($company_info->leave_year_from == 5) selected @endif>May</option>
                        <option value="6" @if($company_info->leave_year_from == 6) selected @endif>June</option>
                        <option value="7" @if($company_info->leave_year_from == 7) selected @endif>July</option>
                        <option value="8" @if($company_info->leave_year_from == 8) selected @endif>August</option>
                        <option value="9" @if($company_info->leave_year_from == 9) selected @endif>September</option>
                        <option value="10" @if($company_info->leave_year_from == 10) selected @endif>October</option>
                        <option value="11" @if($company_info->leave_year_from == 11) selected @endif>November</option>
                        <option value="12" @if($company_info->leave_year_from == 12) selected @endif>December</option>
                      </select>
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <select name="leave_year_to" class="form-control">
                        <option value="" label>Leave year to</option>
                        <option value="1" @if($company_info->leave_year_to == 1) selected @endif>January</option>
                        <option value="2" @if($company_info->leave_year_to == 2) selected @endif>February</option>
                        <option value="3" @if($company_info->leave_year_to == 3) selected @endif>March</option>
                        <option value="4" @if($company_info->leave_year_to == 4) selected @endif>April</option>
                        <option value="5" @if($company_info->leave_year_to == 5) selected @endif>May</option>
                        <option value="6" @if($company_info->leave_year_to == 6) selected @endif>June</option>
                        <option value="7" @if($company_info->leave_year_to == 7) selected @endif>July</option>
                        <option value="8" @if($company_info->leave_year_to == 6) selected @endif>August</option>
                        <option value="9" @if($company_info->leave_year_to == 9) selected @endif>September</option>
                        <option value="10" @if($company_info->leave_year_to == 10) selected @endif>October</option>
                        <option value="11" @if($company_info->leave_year_to == 11) selected @endif>November</option>
                        <option value="12" @if($company_info->leave_year_to == 12) selected @endif>December</option>
                      </select>
                    </div>

                  </div>

                  <div class="card-header pd-l-0 mg-t-10 pd-b-0">
                    <h4 class="card-title">Login Info</h4>
                  </div>

                  <div class="row row-xs">
                    <div class="col-md-4 pd-t-10">
                      <input id="login-email" type="text" name="login_email" placeholder="Login Email" class="form-control" value="{{$login_info->email}}" required>
                    </div>

                    <div class="col-md-4 pd-t-10">
                      <input id="login-password" type="text" name="login_password" placeholder="Login Password" autocomplete="off" class="form-control">
                    </div>

                  </div>

                  <div class="card-header pd-l-0 mg-t-10 pd-b-0">
                    <h4 class="card-title">Subscription Info</h4>
                  </div>

                  <div class="row row-xs">
                    <div class="col-md-4 pd-t-10">
                      <input type="text" name="subscription_amount" placeholder="Subscription Amount" class="form-control" value="{{$subcription_info->amount}}" required>
                    </div>

                    <div class="col-md-4 pd-t-10">
                        <input type="text" name="subscription_start_date" placeholder="Subscription Start Date" class="form-control dtpicker" autocomplete="off" value="{{ date('d-m-Y',strtotime($subcription_info->subscription_start_date))}}" required/>
                    </div>

                    <div class="col-md-4 pd-t-10">
                        <input type="text" name="subscription_end_date" placeholder="Subscription End Date" class="form-control dtpicker" autocomplete="off" value="{{ date('d-m-Y',strtotime($subcription_info->subscription_end_date))}}" required/>
                    </div>

                    <div class="col-md-1 mg-t-20">
                      Modules: 
                    </div>

                    <div class="col-md-1 mg-t-20">
                      <label class="ckbox pointer"><input name="attendance" value="1" type="checkbox" @if($company_info->attendance == 1) checked @endif><span>Attendance</span></label>
                    </div>

                    <div class="col-md-1 mg-t-20">
                      <label class="ckbox pointer"><input name="leave" value="1" type="checkbox" @if($company_info->leave == 1) checked @endif><span>Leave</span></label>
                    </div>

                    <div class="col-md-1 mg-t-20">
                      <label class="ckbox pointer"><input name="payroll" value="1" type="checkbox" @if($company_info->payroll == 1) checked @endif><span>Payroll</span></label>
                    </div>

                    <div class="col-md-4 pd-t-10">
                      <input type="text" name="employee_limit" placeholder="Employee Limit" class="form-control" value="{{$company_info->employee_limit}}" required/>
                    </div>

                    <div class="col-md-4 mg-t-20">
                      <label class="ckbox pointer"><input name="document_upload" value="1" type="checkbox" @if($company_info->document_upload == 1) checked @endif><span>Document Upload</span></label>
                    </div>

                    <div class="col-md-12 mg-t-20">
                      <label class="ckbox pointer"><input id="quickbooks" name="quickbooks" value="1" type="checkbox" @if($company_info->quickbooks == 1) checked @endif onclick="hideShowQB()"><span>Quickbooks</span></label>
                    </div>

                    <div class="col-md-4 pd-t-15 collapse qb-inputs">
                      <input type="text" name="qb_client_id" placeholder="QB Client ID" class="form-control" value="{{$company_info->qb_client_id}}">
                    </div>

                    <div class="col-md-4 pd-t-15 collapse qb-inputs">
                      <input type="text" name="qb_client_secret" placeholder="QB Client Secret ID" class="form-control" value="{{$company_info->qb_client_secret}}">
                    </div>

                    <div class="col-md-2 pd-t-15 collapse qb-inputs">
                      <input type="text" name="qb_company_id" placeholder="QB Company ID" class="form-control" value="{{$company_info->qb_company_id}}">
                    </div>
                    
                    <div class="col-md-2 pd-t-15 collapse qb-inputs">
                      <select name="qb_environment" class="form-control  mg-l--4" required>
                        <option value="production" @if($company_info->qb_environment == "production") selected @endif>Production</option>
                        <option value="development" @if($company_info->qb_environment == "development") selected @endif>Development</option>
                      </select>
                    </div>

                  </div>

                  <div class="row pd-t-30">
                    <div class="col-md-12 text-center">
                        <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Submit"/>
                    </div>
                  </div>
                </form>
              </div>
            </div>
        </div>

    </div>

    <script>

        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function()
            {
              var output = document.getElementById('logo');
              output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function hideShowQB(){
          var quickbooks = document.getElementById("quickbooks");
          if (quickbooks.checked == true){
            $('.qb-inputs').show();
          } else {
            $('.qb-inputs').hide();
          }
        }
        
    </script>

@endsection
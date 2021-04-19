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
                <form class="form-horizontal" action="{{url('company-register')}}" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div>
                      @if(isset($info) && $info->logo != "")
                          <img class="pointer" style="margin-bottom:10px" id="logo" src="{{ asset('storage/'.$info->logo) }}" width="80" alt="logo" onclick="document.getElementById('imgInp').click()"/>
                      @else
                          <img class="pointer" style="margin-bottom:10px" id="logo" src="{{ asset('assets/img/logo-placeholder.png') }}" width="80" alt="logo" onclick="document.getElementById('imgInp').click()"/>
                      @endif
                  </div>
                  <a onclick="document.getElementById('imgInp').click()" class="pointer wd-120 btn btn-secondary btn-sm text-white">Choose</a>
                  <input class="collapse" type="file" name="logo" id="imgInp" onchange="preview_image(event)" />

                  <div class="row row-xs">
                    <div class="col-md-3 pd-t-10">
                      <input id="name" type="text" name="name" placeholder="Company Name" class="form-control" required>
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="phone" type="text" name="phone" placeholder="Phone" class="form-control">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="fax" type="text" name="fax" placeholder="Fax" class="form-control">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="email" type="text" name="email" placeholder="Email" class="form-control">
                    </div>

                    <div class="col-md-6 pd-t-10">
                      <input id="address_line_1" type="text" name="address_line_1" placeholder="Address Line 1" class="form-control">
                    </div>

                    <div class="col-md-6 pd-t-10">
                      <input id="address_line_2" type="text" name="address_line_2" placeholder="Address Line 2" class="form-control">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="bin" type="text" name="bin" placeholder="BIN Number" class="form-control">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="tin" type="text" name="tin" placeholder="TIN Number" class="form-control">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="ein" type="text" name="ein" placeholder="EIN Number" class="form-control">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="vat_reg_no" type="text" name="vat_reg_no" placeholder="VAT Registration Number" class="form-control">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="website" type="text" name="website" placeholder="Website" class="form-control">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <select name="leave_year_from" class="form-control">
                        <option value="" label>Leave year from</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                      </select>
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <select name="leave_year_to" class="form-control">
                        <option value="" label>Leave year to</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                      </select>
                    </div>

                  </div>

                  <div class="card-header pd-l-0 mg-t-10 pd-b-0">
                    <h4 class="card-title">Login Info</h4>
                  </div>

                  <div class="row row-xs">
                    <div class="col-md-4 pd-t-10">
                      <input id="login-email" type="text" name="login_email" placeholder="Login Email" class="form-control" required>
                    </div>

                    <div class="col-md-4 pd-t-10">
                      <input id="login-password" type="text" name="login_password" placeholder="Login Password" autocomplete="off" class="form-control" required>
                    </div>

                  </div>

                  <div class="card-header pd-l-0 mg-t-10 pd-b-0">
                    <h4 class="card-title">Subscription Info</h4>
                  </div>

                  <div class="row row-xs">
                    <div class="col-md-4 pd-t-10">
                      <input type="text" name="subscription_amount" placeholder="Subscription Amount" class="form-control" required>
                    </div>

                    <div class="col-md-4 pd-t-10">
                        <input type="text" name="subscription_start_date" placeholder="Subscription Start Date" class="form-control admindtpicker" autocomplete="off" required/>
                    </div>

                    <div class="col-md-4 pd-t-10">
                        <input type="text" name="subscription_end_date" placeholder="Subscription End Date" class="form-control admindtpicker" autocomplete="off" required/>
                    </div>

                    <div class="col-md-1 mg-t-20">
                      Modules:
                    </div>

                    <div class="col-md-1 mg-t-20">
                      <label class="ckbox pointer"><input checked="" name="attendance" value="1" type="checkbox"><span>Attendance</span></label>
                    </div>

                    <div class="col-md-1 mg-t-20">
                      <label class="ckbox pointer"><input checked="" name="leave" value="1" type="checkbox"><span>Leave</span></label>
                    </div>

                    <div class="col-md-1 mg-t-20">
                      <label class="ckbox pointer"><input checked="" name="payroll" value="1" type="checkbox"><span>Payroll</span></label>
                    </div>

                    <div class="col-md-4 pd-t-10">
                      <input type="text" name="employee_limit" placeholder="Employee Limit" class="form-control" required/>
                    </div>

                    <div class="col-md-4 mg-t-20">
                      <label class="ckbox pointer"><input checked="" name="document_upload" value="1" type="checkbox"><span>Document Upload</span></label>
                    </div>

                      <div class="card-header pd-l-0 mg-t-10 pd-b-0">
                          <h4 class="card-title">Biometric Machine Redirect URL</h4>
                      </div>

                      <div class="col-md-12">
                          <input type="text" name="biometric_machine_redirect_url" placeholder="Biometric Machine Redirect URL" class="form-control" value="http://localhost" required/>
                      </div>

                    <div class="col-md-12 mg-t-20">
                      <label class="ckbox pointer"><input id="quickbooks" name="quickbooks" value="1" type="checkbox" onclick="hideShowQB()"><span>Quickbooks</span></label>
                    </div>

                    <div class="col-md-4 pd-t-15 collapse qb-inputs">
                      <input type="text" name="qb_client_id" placeholder="QB Client ID" class="form-control">
                    </div>

                    <div class="col-md-4 pd-t-15 collapse qb-inputs">
                      <input type="text" name="qb_client_secret" placeholder="QB Client Secret ID" class="form-control">
                    </div>

                    <div class="col-md-2 pd-t-15 collapse qb-inputs">
                      <input type="text" name="qb_company_id" placeholder="QB Company ID" class="form-control" required>
                    </div>

                    <div class="col-md-2 pd-t-15 collapse qb-inputs">
                      <select name="qb_environment" class="form-control  mg-l--4" required>
                        <option value="production">Production</option>
                        <option value="development">Development</option>
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

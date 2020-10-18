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
                <form class="form-horizontal">
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
                    <div class="col-md-4 pd-t-10">
                      <input id="name" type="text" name="name" placeholder="Company Name" class="form-control" required>
                    </div>

                    <div class="col-md-4 pd-t-10">
                      <input id="email" type="text" name="email" placeholder="Email Address" class="form-control">
                    </div>

                    <div class="col-md-4 pd-t-10">
                      <input id="phone" type="text" name="phone" placeholder="Phone Number" class="form-control">
                    </div>

                    <div class="col-md-4 pd-t-10">
                      <input id="address" type="text" name="address" placeholder="Address" class="form-control">
                    </div>

                    <div class="col-md-4 pd-t-10">
                      <input id="tin" type="text" name="tin" placeholder="Tin Number" class="form-control">
                    </div>

                    <div class="col-md-4 pd-t-10">
                      <input id="vat_reg_no" type="text" name="vat_reg_no" placeholder="VAT Registration Number" class="form-control">
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
                        <input type="text" name="subscription_start_date" placeholder="Subscription Start Date" class="form-control dtpicker" autocomplete="off" required/>
                    </div>

                    <div class="col-md-4 pd-t-10">
                        <input type="text" name="subscription_end_date" placeholder="Subscription End Date" class="form-control dtpicker" autocomplete="off" required/>
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
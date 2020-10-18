@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('company')}}" style="color:#6c757d;">Company</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card box-shadow-0">
              <div class="card-header">

                  @if(session()->has('message'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                      {{ session()->get('message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      </div>
                  @endif

                <h4 class="card-title mb-1">Company Info</h4>
              </div>
              
              <div class="card-body pd-t-0">
                <form class="form-horizontal" action="{{url('company/update')}}" method="POST" enctype="multipart/form-data">
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
                      <input id="name" type="text" name="name" placeholder="Company Name" class="form-control" value="@isset($info->name){{$info->name}}@endisset" required>
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="phone" type="text" name="phone" placeholder="Phone" class="form-control" value="@isset($info->phone){{$info->phone}}@endisset">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="fax" type="text" name="fax" placeholder="Fax" class="form-control" value="@isset($info->fax){{$info->fax}}@endisset">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="email" type="text" name="email" placeholder="Email" class="form-control" value="@isset($info->email){{$info->email}}@endisset">
                    </div>

                    <div class="col-md-6 pd-t-10">
                      <input id="address_line_1" type="text" name="address_line_1" placeholder="Address Line 1" class="form-control" value="@isset($info->address_line_1){{$info->address_line_1}}@endisset">
                    </div>

                    <div class="col-md-6 pd-t-10">
                      <input id="address_line_2" type="text" name="address_line_2" placeholder="Address Line 2" class="form-control" value="@isset($info->address_line_2){{$info->address_line_2}}@endisset">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="bin" type="text" name="bin" placeholder="BIN Number" class="form-control" value="@isset($info->bin){{$info->bin}}@endisset">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="tin" type="text" name="tin" placeholder="TIN Number" class="form-control" value="@isset($info->tin){{$info->tin}}@endisset">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="ein" type="text" name="ein" placeholder="EIN Number" class="form-control" value="@isset($info->ein){{$info->ein}}@endisset">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="vat_reg_no" type="text" name="vat_reg_no" placeholder="VAT Registration Number" class="form-control" value="@isset($info->vat_reg_no){{$info->vat_reg_no}}@endisset">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <input id="website" type="text" name="website" placeholder="Website" class="form-control" value="@isset($info->website){{$info->website}}@endisset">
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <select name="currency_id" class="form-control" required>
                        <option value="" label>Currency</option>
                        @foreach($currency as $cur)
                          <option value="{{$cur->id}}" @if(isset($info) && $info->currency_id == $cur->id) selected @endif>{{$cur->currency_name}}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <select name="leave_year_from" class="form-control">
                        <option value="" label>Leave year from</option>
                        <option value="1" @if(isset($info) && $info->leave_year_from == 1) selected @endif>January</option>
                        <option value="2" @if(isset($info) && $info->leave_year_from == 2) selected @endif>February</option>
                        <option value="3" @if(isset($info) && $info->leave_year_from == 3) selected @endif>March</option>
                        <option value="4" @if(isset($info) && $info->leave_year_from == 4) selected @endif>April</option>
                        <option value="5" @if(isset($info) && $info->leave_year_from == 5) selected @endif>May</option>
                        <option value="6" @if(isset($info) && $info->leave_year_from == 6) selected @endif>June</option>
                        <option value="7" @if(isset($info) && $info->leave_year_from == 7) selected @endif>July</option>
                        <option value="8" @if(isset($info) && $info->leave_year_from == 8) selected @endif>August</option>
                        <option value="9" @if(isset($info) && $info->leave_year_from == 9) selected @endif>September</option>
                        <option value="10" @if(isset($info) && $info->leave_year_from == 10) selected @endif>October</option>
                        <option value="11" @if(isset($info) && $info->leave_year_from == 11) selected @endif>November</option>
                        <option value="12" @if(isset($info) && $info->leave_year_from == 12) selected @endif>December</option>
                      </select>
                    </div>

                    <div class="col-md-3 pd-t-10">
                      <select name="leave_year_to" class="form-control">
                        <option value="" label>Leave year to</option>
                        <option value="1" @if(isset($info) && $info->leave_year_to == 1) selected @endif>January</option>
                        <option value="2" @if(isset($info) && $info->leave_year_to == 2) selected @endif>February</option>
                        <option value="3" @if(isset($info) && $info->leave_year_to == 3) selected @endif>March</option>
                        <option value="4" @if(isset($info) && $info->leave_year_to == 4) selected @endif>April</option>
                        <option value="5" @if(isset($info) && $info->leave_year_to == 5) selected @endif>May</option>
                        <option value="6" @if(isset($info) && $info->leave_year_to == 6) selected @endif>June</option>
                        <option value="7" @if(isset($info) && $info->leave_year_to == 7) selected @endif>July</option>
                        <option value="8" @if(isset($info) && $info->leave_year_to == 8) selected @endif>August</option>
                        <option value="9" @if(isset($info) && $info->leave_year_to == 9) selected @endif>September</option>
                        <option value="10" @if(isset($info) && $info->leave_year_to == 10) selected @endif>October</option>
                        <option value="11" @if(isset($info) && $info->leave_year_to == 11) selected @endif>November</option>
                        <option value="12" @if(isset($info) && $info->leave_year_to == 12) selected @endif>December</option>
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
        
    </script>

@endsection
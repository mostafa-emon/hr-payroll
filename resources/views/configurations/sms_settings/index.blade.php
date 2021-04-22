@extends('layouts.master')

@section('content')

  <div class="row mb-2">
      <div class="col-sm-6"></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('/sms-settings')}}" style="color:#6c757d;">SMS Settings</a></li>
        </ol>
      </div>
  </div>

  @if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session()->get('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                  <div class="col-md-6" style="padding-top:5px">
                      <h4 class="card-title mg-b-0">SMS Settings</h4>
                    </div>
                  <div class="col-md-6 text-right">
                    @if(roles() != "" && in_array(42, json_decode(roles(),false)))
                      <a class="btn btn-primary btn-sm" style="font-size:15px;" href="{{url('sms-settings/add')}}"><i class="fa fa-plus-circle"></i> &nbsp;Add</a>
                    @endif
                  </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                <thead>                  
                    <tr>
                      <th class="text-center" style="width:4%">Serial</th>
                      <th style="width:86%">Name</th>
                      @if(in_array(43, json_decode(roles(),false)) || in_array(44, json_decode(roles(),false)))
                      <th class="text-center" style="width:10%">Action</th>
                      @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($settings as $setting)
                    <tr>
                      <td class="text-center" style="vertical-align: middle">{{(($settings->currentPage() * 10) - 10) + $loop->iteration}}</td>
                      <td style="vertical-align: middle">{{$setting->title}}</td>
                      @if(in_array(43, json_decode(roles(),false)) || in_array(44, json_decode(roles(),false)))
                        <td class="text-center">
                            <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                            <div class="dropdown-menu">
                              @if(roles() != "" && in_array(43, json_decode(roles(),false)))
                                <a href="javascript:void(0)" class="dropdown-item" onclick="update({{$setting->id}})">Update</a>
                              @endif
                              @if(roles() != "" && in_array(44, json_decode(roles(),false)))
                                <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$setting->id}})">Delete</a>
                              @endif
                            </div>
                        </td>
                      @endif
                    </tr>   
                    @endforeach
                </tbody>
                </table>
            </div>
            <div class="mg-t-15">
              {{ $settings->links() }}
            </div>
        </div>
    </div>
  </div>

<script>
  function update(value){
    $('#job').val('update_settings');
    window.location = "/sms-settings/update/"+value
  }

    function confirmDelete(id) {
    var r = confirm("Are you confirm to delete?");
    if (r == true) {
      window.location = "/sms-settings/delete/"+id;
    }
  }
</script>
@endsection
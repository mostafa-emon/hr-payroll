@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('subscription') }}">Subscriptions</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Subscriptions</h4>
    </div>
    <div style="float:right">
      {{--@if(roles() != "" && in_array(5, json_decode(roles(),false)))--}}
      <a href="{{ url('company-register') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add New</a>
      {{--@endif--}}
    </div>
  </div>

  <div class="br-pagebody pd-t-15">
    <div class="br-section-wrapper">
      @if(session()->has('message'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          {{ session()->get('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <div class="table-responsive">
        <table class="table table-striped mg-b-0" id="datatable">
          <thead>
            <tr>
              <th class="text-center wd-5p">Sl</th>
              <th class="wd-30p">Company Name</th>
              <th class="text-center wd-20p">Validity</th>
              <th class="wd-25p">Renew</th>
              <th class="text-center wd-20p">Status</th>
            </tr>
          </thead>
          <tbody>
            @php $sl = 0; @endphp
            @foreach($companies as $company)
              @php $sl = $sl+1; @endphp
              <tr>
                <td class="text-center" style="vertical-align: middle">{{ $loop->iteration }}</td>
                <td style="vertical-align: middle">{{ $company->name }}</td>
                <td class="text-center" style="vertical-align: middle">{{ date('d M Y',strtotime($company->subscription_end_date)) }}</td>
                <td class="text-center">
                  <form action="{{url ('company-renew/'.$company->id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="input-group mb-3" style="margin-top:17px;">
                      <input type="text" name="subscription_end_date" id="dtpick{{$sl}}" class="form-control" autocomplete="off" required style="width:100px;border-top-right-radius:0px;border-bottom-right-radius:0px;"/>
                      <input type="submit" class="btn btn-info btn-sm pointer" value="Renew" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"/>
                    </div>
                  </form>
                </td>
                <td class="text-center" style="vertical-align: middle">
                  @if($company->status == 0)
                    <a class="btn btn-success btn-sm" href="{{url('company-active/'.$company->id)}}" style="width:100px"> Activate </a>
                  @else
                    <a class="btn btn-danger btn-sm" href="{{url('company-inactive/'.$company->id)}}" style="width:100px"> Deactivate </a>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    function confirmDelete(id){
      var result = confirm("Are you confirm to delete?");
      if (result) {
          window.location = 'company/delete/'+id
      }
    }
  </script>

@endsection
@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('site-office') }}">Site Office</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Site Offices</h4>
    </div>
    <div style="float:right">
      @if(roles() != "" && in_array(2, json_decode(roles(),false)))
      <a href="{{ url('site-office/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add Office</a>
      @endif
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
      <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table table-striped mg-b-0">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Name</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Email</th>
              <th>MR Suffix</th>
              <th>MR Prefix</th>
              <th>MR Start From</th>
              @if(roles() != "" && in_array(3, json_decode(roles(),false)))
              <th>Update</th>
              @endif

              @if(roles() != "" && in_array(4, json_decode(roles(),false)))
              <th>Delete</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($site_offices as $site_office)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $site_office->name }}</td>
                <td>{{ $site_office->address }}</td>
                <td>{{ $site_office->phone }}</td>
                <td>{{ $site_office->email }}</td>
                <td>{{ $site_office->mr_suffix }}</td>
                <td>{{ $site_office->mr_prefix }}</td>
                <td>{{ $site_office->mr_start_from }}</td>
                @if(roles() != "" && in_array(3, json_decode(roles(),false)))
                <td>
                  <a class="btn btn-info btn-sm" href="{{url ('site-office/update/'.$site_office->id) }}"><i class= "fa fa-edit"></i> Update </a>
                </td>
                @endif
                @if(roles() != "" && in_array(4, json_decode(roles(),false)))
                <td>
                  <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmDelete({{$site_office->id}})"><i class= "fa fa-minus-circle"></i> Delete</a>
                </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
      </div><br>
      {{ $site_offices -> links() }}
    </div>
  </div>

  <script>
    function confirmDelete(id){
      var result = confirm("Are you confirm to delete?");
      if (result) {
          window.location = 'site-office/delete/'+id
      }
    }
  </script>
@endsection
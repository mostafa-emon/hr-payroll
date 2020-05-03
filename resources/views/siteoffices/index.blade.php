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
      <a href="{{ url('site-office/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add Site</a>
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
              <th>Update</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            @foreach($siteoffices as $siteoffice)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $siteoffice->name }}</td>
                <td>{{ $siteoffice->address }}</td>
                <td>{{ $siteoffice->phone }}</td>
                <td>{{ $siteoffice->email }}</td>
                <td>{{ $siteoffice->mr_suffix }}</td>
                <td>{{ $siteoffice->mr_prefix }}</td>
                <td>{{ $siteoffice->mr_start_from }}</td>
                <td>
                  <a class="btn btn-info btn-sm" href="{{url ('site-office/update/'.$siteoffice->id) }}"><i class= "fa fa-edit"></i> Update </a>
                  </td>
                  <td>
                  <a class="btn btn-danger btn-sm" href="{{url ('site-office/delete/'.$siteoffice->id) }}"><i class= "fa fa-minus-circle"></i> Delete</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection
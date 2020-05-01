@extends('layouts.master')

@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
          <a class="breadcrumb-item" href="{{ url('customer') }}">Customer</a>
        </nav>
      </div>
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <div style="float:left">
          <h4 class="tx-gray-800 mg-b-5">Customers</h4>
        </div>
        <div style="float:right">
          <a href="{{ url('customer/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add Customer</a>
        </div>
      </div>
      
<div class="br-pagebody pd-t-15">
        <div class="br-section-wrapper">
          <div class="bd bd-gray-300 rounded table-responsive">
            <table class="table table-striped mg-b-0">
              <thead>
                <tr>
                  <th>Sl</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Contact Person</th>
                  <th>Update</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                @foreach($customers as $customer)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>C{{ $customer->contact_person }}</td>
                    <td>Update</td>
                    <td>Delete</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- bd -->

        </div><!-- br-section-wrapper -->
      </div>


@endsection
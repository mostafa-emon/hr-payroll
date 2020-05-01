@extends('layouts.master')

    @section('content')

    
    <div class="br-pageheader pd-y-15 pd-l-20">
      <nav class="breadcrumb pd-0 mg-0 tx-12">
      </nav>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h3 class="card-title">Customer</h3>
          </div>
          <div class="col-md-6 text-right">
            <a class="btn btn-primary btn-sm" href="{{url('customer/add')}}"><i class="fa fa-plus-circle"></i> Add Customer</a>
          </div>
        </div>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <div class="bd bd-gray-300 rounded table-responsive">
            <table class="table table-striped mg-b-0">
              <thead>
                <tr>
                  <th>Serial</th>
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
                    <td> {{$loop->iteration}} </td>
                    <td> {{$customer->name}} </td>
                    <td> {{$customer->address}} </td>
                    <td> {{$customer->phone}} </td>
                    <td> {{$customer->email}} </td>
                    <td> {{$customer->contact_person}} </td>
                    <td>
                    <a class="btn btn-success btn-sm" href="{{url ('customer/update/'.$customer->id) }}"><i class= "fa fa-edit"></i> Update </a>
                    </td>
                    <td>
                    <a class="btn btn-danger btn-sm" href="{{url ('customer/delete/'.$customer->id) }}"><i class= "fa fa-minus-circle"></i> Delete</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
    @endsection
@extends('layouts.master')

    @section('content')

      <div class="br-mainpanel">
          <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
            </nav>
          </div>
          <div class="card">
            <div class="card-header">
            <div class="row">
              <div class="col-md-10">
              <h2>Update Supplier</h2>
          
              <form action="{{ url('supplier/update/'.$suppliers->id) }}" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" placeholder="Name" value="{{$suppliers->name}}"/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputChequeName" class="col-sm-2 col-form-label">Cheque Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="cheque_name" placeholder="Cheque Name" value="{{$suppliers->cheque_name}}"/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="address" placeholder="Address" value="{{$suppliers->address}}"/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{$suppliers->phone}}"/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="email" placeholder="Email" value="{{$suppliers->email}}"/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputContactPerson" class="col-sm-2 col-form-label">Contact Person</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="contact_person" placeholder="Contact Person" value="{{$suppliers->contact_person}}"/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <input type="submit" value="Submit" class="btn btn-danger btn-sm"/>
                    </div>
                  </div>
              </form>
              </div>
            </div>
            </div>
          </div> 
      </div>

    @endsection
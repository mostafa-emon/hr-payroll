@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/signatory') }}">Signatory</a>
    </nav>
  </div>

  

  <form action="{{ url('signatory/update') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        @if(session()->has('message'))
          <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        
        <div class="form-layout form-layout-4">
            <h6 class="mg-b-30 tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">SIGNATORIES</h6>
            <div class="row">
                <label class="col-sm-4 form-control-label">Prepared By:</label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="prepared_by">
                        <option value="1" @if(isset($signatories) && $signatories->prepared_by == 1) selected @endif>Enable</option>
                        <option value="0" @if(isset($signatories) && $signatories->prepared_by == 0) selected @endif>Disable</option>
                    </select>
                </div>
            </div>

            <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Checked By:</label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="checked_by">
                        <option value="1" @if(isset($signatories) && $signatories->checked_by == 1) selected @endif>Enable</option>
                        <option value="0" @if(isset($signatories) && $signatories->checked_by == 0) selected @endif>Disable</option>
                    </select>
                </div>
            </div>
            
            <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Verified By:</label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="verified_by">
                        <option value="1" @if(isset($signatories) && $signatories->verified_by == 1) selected @endif>Enable</option>
                        <option value="0" @if(isset($signatories) && $signatories->verified_by == 0) selected @endif>Disable</option>
                    </select>
                </div>
            </div>

            <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Authorized By:</label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="authorized_by">
                        <option value="1" @if(isset($signatories) && $signatories->authorized_by == 1) selected @endif>Enable</option>
                        <option value="0" @if(isset($signatories) && $signatories->authorized_by == 0) selected @endif>Disable</option>
                    </select>
                </div>
            </div>

            <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Approved By:</label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="approved_by">
                        <option value="1" @if(isset($signatories) && $signatories->approved_by == 1) selected @endif>Enable</option>
                        <option value="0" @if(isset($signatories) && $signatories->approved_by == 0) selected @endif>Disable</option>
                    </select>
                </div>
            </div>

            @if(roles() != "" && in_array(53, json_decode(roles(),false)))
            <div class="form-layout-footer mg-t-30">
                <button class="btn btn-info pointer">Update</button>
            </div>
            @endif
        </div>
      </div>
    </div>
  </form>

  <script>
    function preview_image(event) 
{
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
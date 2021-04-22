@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/leave-type')}}" style="color:#6c757d;">Leave Type</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card">

                <div class="card-header">
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Leave Type</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(roles() != "" && in_array(35, json_decode(roles(),false)))
                                <button type="button" style="font-size: 15px;" id="modal-button" onclick="reloadForm()" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal1"><i class="fa fa-plus-circle"></i> &nbsp;Create</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%;">SL</th>
                                    <th style="width:25%;">Name</th>
                                    <th class="text-center" style="width:10%;">ID</th>
                                    <th class="text-center" style="width:15%;">Short Name</th>
                                    <th class="text-center" style="width:20%;">Reference</th>
                                    <th class="text-center" style="width:15%;">EL Deviding Factor</th>
                                    @if(in_array(36, json_decode(roles(),false)) || in_array(37, json_decode(roles(),false)))
                                        <th class="text-center" style="width:10%;">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($types as $type)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{(($types->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$type->leave_name}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$type->leave_id}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$type->leave_short_name}}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        @if($type->reference == 'general_leave') Non Paid Leave
                                        @else Paid Leave
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle">
                                        @if($type->reference == 'general_leave') N\A
                                        @else {{$type->el_deviding_factor}} Days
                                        @endif
                                    </td>
                                    @if(in_array(36, json_decode(roles(),false)) || in_array(37, json_decode(roles(),false)))
                                        <td class="text-center" style="vertical-align: middle">
                                            <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                            <div class="dropdown-menu">
                                                @if(roles() != "" && in_array(36, json_decode(roles(),false)))
                                                    <a href="javascript:void(0)" class="dropdown-item" onclick="update({{$type->id}})">Update</a>
                                                @endif
                                                @if(roles() != "" && in_array(37, json_decode(roles(),false)))
                                                    <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$type->id}})">Delete</a>
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
                        {{ $types->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="modal-form" action="{{ url('leave-type/add') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modal1label"><i class=""></i> Leave Type </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="leave_name" class="col-form-label col-md-4">Name:</label>
                        <input type="text" class="form-control col-md-8 pa" id="leave_name" name="leave_name" placeholder="Enter Name" required/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="leave_name" class="col-form-label col-md-4">Reference:</label>
                        <select id="reference" name="reference" class="form-control select2-no-search col-md-8 pa" onclick="hideShowElement(this.value)" required>
                            <option label="Select Reference"></option>
                            <option value="general_leave">Non Paid Leave</option>
                            <option value="paid_leave">Paid Leave</option>
                        </select>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="leave_id" class="col-form-label col-md-4">ID :</label>
                        <input type="text" class="form-control col-md-8 pa" id="leave_id" name="leave_id" placeholder="Enter ID"/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="leave_short_name" class="col-form-label col-md-4">Short Name:</label>
                        <input type="text" class="form-control col-md-8 pa" id="leave_short_name" name="leave_short_name" placeholder="Enter Short Name"/>
                    </div>

                    <div style="display:none;" id="div_el_deviding_factor" class="form-group row pd-r-15 pd-l-10">
                        <label for="el_deviding_factor" class="col-form-label col-md-4">EL Deviding Factor:</label>
                        <input type="text" class="form-control col-md-8 pa" id="el_deviding_factor" name="el_deviding_factor" placeholder="Days"/>
                    </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Submit"/>
                </div>
            </div>
            </form>
        </div>
    </div>

    <script>
        function update(id) {
            $.ajax({
                type:'GET',
                url:'/leave-type/get/'+id,
                success:function(data) {
                var response = JSON.parse(data);
                $("#modal-button").click();
                $("#leave_name").val(response.leave_name);
                $("#leave_id").val(response.leave_id);
                $("#leave_short_name").val(response.leave_short_name);
                $("#el_deviding_factor").val(response.el_deviding_factor);
                $("#reference").val(response.reference)
                .find("option[value=" + response.reference +"]").attr('selected', true);
                if(response.reference == "paid_leave"){
                    $('#div_el_deviding_factor').show();
                }else{
                    $('#div_el_deviding_factor').hide();
                }
                $('#modal-form').prop('action', '/leave-type/update/'+id);
                }
            });
        }

        function reloadForm() {
            $('#leave_name').val('');
            $('#leave_id').val('');
            $('#leave_short_name').val('');
            $('#el_deviding_factor').val('21');
            $('#reference').val('');
            $('#modal-form').prop('action', '/leave-type/add');
        }

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/leave-type/delete/"+id;
            }
        }

        function hideShowElement(value) {
            if(value == "paid_leave") {
                $('#div_el_deviding_factor').show();
            }else{
                $('#div_el_deviding_factor').hide();
            }
        }

    </script>

@endsection
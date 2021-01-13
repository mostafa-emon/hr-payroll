@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/shift')}}" style="color:#6c757d;">Shift</a></li>
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
                            <h4 class="card-title mg-b-0">Shift</h4>
                        </div>
                        <div class="col-md-6 text-right"> 
                            <button type="button" style="font-size: 15px;" id="modal-button" onclick="reloadForm()" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal1"><i class="fa fa-plus-circle"></i> &nbsp;Create</button>
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
                                    <th class="text-center" style="width:15%;">ID</th>
                                    <th class="text-center" style="width:15%;">Short Name</th>
                                    <th class="text-center" style="width:15%;">Start Time</th>
                                    <th class="text-center" style="width:15%;">End Time</th>
                                    <th class="text-center" style="width:10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shifts as $shift)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{(($shifts->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$shift->name}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$shift->shift_id}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$shift->shift_short_name}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$shift->start_time}} @if($shift->start_time_meridiem == "1") PM @else AM @endif</td>
                                    <td class="text-center" style="vertical-align: middle">{{$shift->end_time}} @if($shift->end_time_meridiem == "1") PM @else AM @endif</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="update({{$shift->id}})">Update</a>
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$shift->id}})">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $shifts->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="modal-form" action="{{ url('shift/add') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modal1label"><i class=""></i> Shift </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="name" class="col-form-label col-md-3">Name:</label>
                        <input type="text" class="form-control col-md-9 pa" id="name" name="name" placeholder="Enter Name" required/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="shift_id" class="col-form-label col-md-3">ID :</label>
                        <input type="text" class="form-control col-md-9 pa" id="shift_id" name="shift_id" placeholder="Enter ID"/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="shift_short_name" class="col-form-label col-md-3">Short Name :</label>
                        <input type="text" class="form-control col-md-9 pa" id="shift_short_name" name="shift_short_name" placeholder="Enter Short Name"/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="start_time" class="col-form-label col-md-3">Start Time :</label>
                        <input type="text" class="form-control col-md-5 pa" id="start_time" name="start_time" placeholder="HH:MM"/>
                        <select id="start_time_meridiem" name="start_time_meridiem" class="form-control select2-no-search col-md-4 pa" required>
                            <option value="0">AM</option>
                            <option value="1">PM</option>
                        </select>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="end_time" class="col-form-label col-md-3">End Time :</label>
                        <input type="text" class="form-control col-md-5 pa" id="end_time" name="end_time" placeholder="HH:MM"/>
                        <select id="end_time_meridiem" name="end_time_meridiem" class="form-control select2-no-search col-md-4 pa" required>
                            <option value="0">AM</option>
                            <option value="1">PM</option>
                        </select>
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
                url:'/shift/get/'+id,
                success:function(data) {
                var response = JSON.parse(data);
                $("#modal-button").click();
                $("#name").val(response.name);
                $("#shift_id").val(response.shift_id);
                $("#shift_short_name").val(response.shift_short_name);
                $("#start_time").val(response.start_time);
                $("#end_time").val(response.end_time);
                $("#start_time_meridiem").val(response.start_time_meridiem)
                .find("option[value=" + response.start_time_meridiem +"]").attr('selected', true);

                $("#end_time_meridiem").val(response.end_time_meridiem)
                .find("option[value=" + response.end_time_meridiem +"]").attr('selected', true);

                $('#modal-form').prop('action', '/shift/update/'+id);
                }
            });
        }

        function reloadForm() {
            $('#name').val('');
            $('#shift_id').val('');
            $('#shift_short_name').val('');
            $('#start_time').val('');
            $('#end_time').val('');
            $('#start_time_meridiem').val('0');
            $('#end_time_meridiem').val('1');
            $('#modal-form').prop('action', '/shift/add');
        }

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/shift/delete/"+id;
            }
        }

    </script>

@endsection
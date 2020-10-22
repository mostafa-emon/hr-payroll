@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/govt-holiday')}}" style="color:#6c757d;">Govt Holiday</a></li>
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
                            <h4 class="card-title mg-b-0">Govt Holiday</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('govt-holiday/add')}}"><i class="fa fa-plus-circle"></i> &nbsp;Add</a>
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
                                    <th class="text-center" style="width:20%;">From</th>
                                    <th class="text-center" style="width:20%;">To</th>
                                    <th class="text-center" style="width:15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($holidays as $holiday)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{$loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$holiday->name}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$holiday->holiday_id}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{date('d-m-Y',strtotime($holiday->start_date))}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{date('d-m-Y',strtotime($holiday->end_date))}}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{'govt-holiday/update/'.$holiday->id}}" class="dropdown-item">Update</a>
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$holiday->id}})">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $holidays->links() }}
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="modal-form" action="{{ url('govt-holiday/add') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modal1label"><i class=""></i> Govt Holiday </h5>
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
                        <label for="holiday_id" class="col-form-label col-md-3">ID:</label>
                        <input type="text" class="form-control col-md-9 pa" id="holiday_id" name="holiday_id" placeholder="Enter ID"/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="holiday_id" class="col-form-label col-md-3">Start Date:</label>
                        <input type="text" class="form-control col-md-9 pa dtpicker" id="holiday_id" name="holiday_id" placeholder="Enter ID"/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="holiday_id" class="col-form-label col-md-3">End Date:</label>
                        <input type="text" class="form-control col-md-9 pa dtpicker" id="holiday_id" name="holiday_id" placeholder="Enter ID"/>
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
                url:'/govt-holiday/get/'+id,
                success:function(data) {
                var response = JSON.parse(data);
                $("#modal-button").click();
                $("#name").val(response.name);
                $("#holiday_id").val(response.holiday_id);
                $('#modal-form').prop('action', '/govt-holiday/update/'+id);
                }
            });
        }

        function reloadForm() {
            $('#name').val('');
            $('#holiday_id').val('');
            $('#modal-form').prop('action', '/govt-holiday/add');
        }

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/govt-holiday/delete/"+id;
            }
        }

    </script>

@endsection
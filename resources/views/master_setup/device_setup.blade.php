@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/device-setup')}}" style="color:#6c757d;">Device Setup</a></li>
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
                            <h4 class="card-title mg-b-0">Device Setup</h4>
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
                                    <th class="text-center" style="width:3%;">SL</th>
                                    <th style="width:25%;">Name</th>
                                    <th style="width:15%;">Brand</th>
                                    <th class="text-center" style="width:12%;">Floor</th>
                                    <th style="width:15%;">IP Address</th>
                                    <th class="text-center" style="width:10%;">Port</th>
                                    <th class="text-center" style="width:10%;">Serial No</th>
                                    <th class="text-center" style="width:10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($devices as $device)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{$loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$device->name}}</td>
                                    <td style="vertical-align: middle">{{$device->brand}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$device->floor}}</td>
                                    <td style="vertical-align: middle">{{$device->ip_address}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$device->port}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$device->serial_no}}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="javascript:void(0)" class="dropdown-item">Connect</a>
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="update({{$device->id}})">Update</a>
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$device->id}})">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $devices->links() }}
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="modal-form" action="{{ url('device-setup/add') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modal1label"><i class=""></i> Device Setup </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="brand" class="col-form-label col-md-3">Brand:</label>
                        <select id="brand" name="brand" class="form-control select2-no-search col-md-9 pa">
                            <option label="Choose One"></option>
                            <option value="Samsung">Samsung</option>
                            <option value="Oppo">Oppo</option>
                            <option value="Vivo">Vivo</option>
                        </select>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="name" class="col-form-label col-md-3">Name:</label>
                        <input type="text" class="form-control col-md-9 pa" id="name" name="name" placeholder="Enter Name" required/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="floor" class="col-form-label col-md-3">Floor:</label>
                        <input type="text" class="form-control col-md-9 pa" id="floor" name="floor" placeholder="Floor"/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="ip_address" class="col-form-label col-md-3">IP Address:</label>
                        <input type="text" class="form-control col-md-9 pa" id="ip_address" name="ip_address" placeholder="Enter IP Address"/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="serial_no" class="col-form-label col-md-3">Serial No:</label>
                        <input type="text" class="form-control col-md-9 pa" id="serial_no" name="serial_no" placeholder="Serial No"/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="port" class="col-form-label col-md-3">Port:</label>
                        <input type="text" class="form-control col-md-9 pa" id="port" name="port" placeholder="Port"/>
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
                url:'/device-setup/get/'+id,
                success:function(data) {
                var response = JSON.parse(data);
                $("#modal-button").click();
                $("#name").val(response.name);
                $("#floor").val(response.floor);
                $("#ip_address").val(response.ip_address);
                $("#serial_no").val(response.serial_no);
                $("#port").val(response.port);
                $("#brand").val(response.brand)
                .find("option[value=" + response.brand +"]").attr('selected', true);
                $('#modal-form').prop('action', '/device-setup/update/'+id);
                }
            });
        }

        function reloadForm() {
            $('#name').val('');
            $('#floor').val('');
            $('#ip_address').val('');
            $('#serial_no').val('');
            $('#port').val('');
            $('#brand').val('');
            $('#modal-form').prop('action', '/device-setup/add');
        }

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/device-setup/delete/"+id;
            }
        }

    </script>

@endsection
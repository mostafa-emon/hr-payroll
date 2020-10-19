@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/projects')}}" style="color:#6c757d;">Projects</a></li>
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
                            <h4 class="card-title mg-b-0">Projects</h4>
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
                                    <th style="width:20%;">Name</th>
                                    <th style="width:55%;">Address</th>
                                    <th class="text-center" style="width:10%;">ID</th>
                                    <th class="text-center" style="width:10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{$loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$project->name}}</td>
                                    <td style="vertical-align: middle">{{$project->address}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$project->project_id}}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="update({{$project->id}})">Update</a>
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$project->id}})">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $projects->links() }}
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="modal-form" action="{{ url('projects/add') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modal1label"><i class=""></i> Project </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="name" class="col-form-label col-md-3">Name:</label>
                        <input type="text" class="form-control col-md-9 pa" id="name" name="name" placeholder="Enter Name"/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="project_id" class="col-form-label col-md-3">ID :</label>
                        <input type="text" class="form-control col-md-9 pa" id="project_id" name="project_id" placeholder="Enter ID"/>
                    </div>

                    <div class="form-group row pd-r-15 pd-l-10">
                        <label for="address" class="col-form-label col-md-3">Address :</label>
                        <textarea type="text" class="form-control col-md-9 pa" rows="4" id="address" name="address" placeholder="Enter Address"></textarea>
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
                url:'/projects/get/'+id,
                success:function(data) {
                var response = JSON.parse(data);
                $("#modal-button").click();
                $("#name").val(response.name);
                $("#project_id").val(response.project_id);
                $("#address").val(response.address);
                $('#modal-form').prop('action', '/projects/update/'+id);
                }
            });
        }

        function reloadForm() {
            $('#name').val('');
            $('#project_id').val('');
            $('#address').val('');
            $('#modal-form').prop('action', '/projects/add');
        }

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/projects/delete/"+id;
            }
        }

    </script>

@endsection
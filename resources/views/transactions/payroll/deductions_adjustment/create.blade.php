@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/deductions-adjustment')}}" style="color:#6c757d; font-weight: bold">Deductions Adjustment</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/deductions-adjustment/create')}}" style="color:#6c757d;">Create</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Create Deductions Adjustment</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('deductions-adjustment/create-post')}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="row row-xs">
                                                <div class="col-md-3 mg-t-10">
                                                    <select name="department_id" id="department_id" class="form-control select2-no-search" onchange="get_employee()" required>
                                                        <option label="Department"></option>
                                                        @foreach($departments as $department)
                                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mg-t-10">
                                                    <select name="project_id" id="project_id" class="form-control select2-no-search" onchange="get_employee()">
                                                        <option label="Choose Project"></option>
                                                        @foreach($projects as $project)
                                                            <option value="{{$project->id}}">{{$project->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mg-t-10">
                                                    <select name="branch_id" id="branch_id" class="form-control select2-no-search" onchange="get_employee()">
                                                        <option label="Choose Branch"></option>
                                                        @foreach($branches as $branch)
                                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mg-t-10">
                                                    <select name="component_id" id="component_id" class="form-control select2-no-search" onchange="get_employee()" required>
                                                        <option label="Choose Component"></option>
                                                        @foreach($salary_components as $component)
                                                            <option value="{{$component->id}}">{{$component->component_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <select id="employee_id" name="employee_id[]" class="form-control employee_multiple" multiple="multiple" required>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mg-t-10">
                                                    <input type="text" name="from_date" class="form-control dtpicker" autocomplete="off" placeholder="From Date" required>
                                                </div>
                                                <div class="col-md-3 mg-t-10">
                                                    <input type="text" name="to_date" class="form-control dtpicker" autocomplete="off" placeholder="To Date" required>
                                                </div>
                                                <div class="col-md-2 mg-t-10">
                                                    <select name="type" class="form-control select2-no-search" required>
                                                        <option label="Type"></option>
                                                        <option Value="Addition">Addition</option>
                                                        <option Value="Deduction" selected>Deduction</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-12 mg-t-10">
                                                            <textarea type="text" name="note" rows="4" class="form-control" placeholder="Note..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-4 mg-t-10">
                                                            <input type="text" name="amount" class="form-control" placeholder="Amount" required/>
                                                        </div>
                                                        <div class="col-md-4 mg-t-10">
                                                            <input type="text" name="reference_no" class="form-control" placeholder="Reference No"/>
                                                        </div>
                                                        <div class="col-md-4 mg-t-10">
                                                            <select name="status" class="form-control select2-no-search">
                                                                <option label="Status"></option>
                                                                <option Value="1" selected>Active</option>
                                                                <option Value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 pd-t-20">
                                                            <input class="form-control" name="attach_file" type="file">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <div class="row pd-t-10">
                                            <div class="col-md-12 text-center">
                                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Submit"/>
                                            </div>
                                        </div>
                                    </form>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function get_employee() {
            var department_id   = $('#department_id').val();
            var project_id      = $('#project_id').val();
            var branch_id       = $('#branch_id').val();
            var component_id    = $('#component_id').val();

            var url = '/search-increment-employee_id/'+department_id;
            if(project_id != "") { url = url +'/'+ project_id;} else { url = url + '/0';}
            if(branch_id != "") { url = url +'/'+ branch_id;} else { url = url + '/0';}
            if(component_id != "") { url = url +'/'+ component_id;} else { url = url + '/0';}

            $.ajax({
                type:'GET',
                url:url,
                success:function(data) {
                    console.log(data)
                    $('#employee_id').html('');
                    $('#employee_id').append(data);
                }
            });
        }
    </script>

@endsection
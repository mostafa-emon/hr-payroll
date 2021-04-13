@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/create-campaign')}}" style="color:#6c757d;">SMS Notification</a></li>
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
                            <h4 class="card-title mg-b-0">SMS Notification</h4>
                        </div>
                        <hr>
                    </div>
                    
                    <form action="{{ url('create-campaign-post') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-5" style="padding-top:10px">
                                <textarea class="form-control" id="sms_body" name="sms_body" style="height:110px;" oninput="onBodyInput()" required placeholder="SMS Body here"></textarea>
                                <input type="hidden" id="body_length" name="body_length"/>

                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <span style="color:green">
                                        Characters:
                                        <span id="count" style="font-weight:bold;font-size:17px"></span>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div style="padding-top:5px;" id="departmentDiv">
                                            <label class="tx-bold">Departments</label>
                                            <select class="form-control departmentMultiple" id="departments" name="department_id[]" multiple="multiple" style="width:100%;">
                                                @foreach($departments as $department)
                                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div style="padding-top:5px;" id="projectDiv">
                                            <label class="tx-bold">Projects</label>
                                            <select class="form-control projectMultiple" id="projects" name="project_id[]" multiple="multiple" style="width:100%;">
                                                @foreach($projects as $project)
                                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div style="padding-top:5px;" id="branchDiv">
                                            <label class="tx-bold">Branches</label>
                                            <select class="form-control branchMultiple" id="branches" name="branch_id[]" multiple="multiple" style="width:100%;">
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div style="padding-top:10px">
                                            <input type="submit" class="btn btn-success" style="width:100%;" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

                @php 
                    $datepicker_format = datepicker_format();
                    $date_format = 'd-m-Y';
                    
                    if($datepicker_format == "MM-DD-YYYY") {
                        $date_format = 'm-d-Y';
                    }else if($datepicker_format == "YYYY/MM/DD") {
                        $date_format = 'Y/m/d';
                    }else if($datepicker_format == "DD-MMM-YY") {
                        $date_format = 'd-M-y';
                    }
                @endphp

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;width:3%">SL</th>
                                    <th class="text-center" style="vertical-align: middle;width:11%">Create Date</th>
                                    <th class="text-center" style="vertical-align: middle;width:37%">SMS Body</th>
                                    <th class="text-center" style="vertical-align: middle;width:12%">SMS Info</th>
                                    <th class="text-center" style="vertical-align: middle;width:11%">Total Numbers</th>
                                    <th class="text-center" style="vertical-align: middle;width:11%">Request To Sent</th>
                                    <th class="text-center" style="vertical-align: middle;width:6%">Status</th>
                                    <th class="text-center" style="vertical-align: middle;width:9%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campaigns as $campaign)
                                @php 
                                    $total_number = campaign_total_receiver_and_sent($campaign->id);
                                    list($total_receiver,$total_sent) = explode("_",$total_number);
                                @endphp
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle">{{(($campaigns->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ date($date_format,strtotime($campaign->created_at))}}</td>
                                        <td style="vertical-align: middle">{{$campaign->sms_body}}</td>
                                        <td style="vertical-align: middle">
                                            <b>{{$campaign->language}}</b><br>
                                            Characters: <b>{{$campaign->body_length}}</b>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle">{{$total_receiver}}</td>
                                        <td class="text-center" style="vertical-align: middle">{{$total_sent}}</td>
                                        <td class="text-center" style="vertical-align: middle">
                                            @if($total_receiver > 0 && $total_sent == 0)
                                                <span class="badge badge-info">Active</span>
                                            @elseif($total_receiver > 0 && $total_sent > 0 && $total_receiver > $total_sent)
                                                <span class="badge badge-warning">Paused</span>
                                            @else
                                                <span class="badge badge-secondary">Finished</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="vertical-align: middle">
                                            <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{url('campaign-receivers/'.$campaign->id)}}">Receivers</a>
                                                <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modalUpdate" onclick="updateText('{{$campaign->id}}','{{$campaign->sms_body}}')">Update Text</a>
                                                <a class="dropdown-item" href="{{url('campaign-duplicate/'.$campaign->id)}}">Duplicate</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="confirmDelete({{$campaign->id}})">Delete</a>
                                                    @if($total_receiver > 0 && $total_sent == 0)
                                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal1" onclick="setCampaignID({{$campaign->id}})">Send Now</a>
                                                    @elseif($total_receiver > 0 && $total_sent > 0 && $total_receiver > $total_sent)
                                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal1" onclick="setCampaignID({{$campaign->id}})">Resume</a>
                                                    @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $campaigns->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modal1label"><i class=""></i> Select API</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="margin-top:15px">
                    <select class="form-control" id="api_id">
                        @foreach($apis as $api)
                        <option value="{{$api->id}}">{{$api->title}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="campaign_id"/>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" onclick="sendSMS()">Send</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{url('campaign-update')}}" method="POST">
                {{ csrf_field() }}
                <div class="modal-header">
                <h5 class="modal-title" id="modal1label"><i class=""></i> Update Text</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="margin-top:15px">
                        <textarea class="form-control" name="updated_body" id="updated_body" style="height:120px" oninput="onUpdatedBodyInput()"></textarea>
                        <div style="color:green">
                            Characters:
                            <span id="updated_body_count_div" style="font-weight:bold;font-size:17px"></span>
                        </div>
                        <input type="hidden" name="campaign_id_update" id="campaign_id_update"/>
                        <input type="hidden" name="updated_body_count" id="updated_body_count"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function onBodyInput(){
            var body = $('#sms_body').val();
            $('#body_length').val(body.length);
            $('#count').text(body.length);
        }
    
        function getCategory() {
            var event_id = $('#events').val();

            $.ajax({
                type: 'POST',
                url: '/get-category-multiple-events',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "event_id": event_id
                },
                success:function(data) {
                    if(data.length > 0) {
                        $('#categoryDiv').show();
                    }
                    $('#category').html('');
                    $('#category').append('<option value="All">All</option>');
                    $('#category').append(data);
                }
            });
        }

        function setCampaignID(campaign_id) {
            $('#campaign_id').val(campaign_id);
        }

        function sendSMS(){
            var campaign_id = $('#campaign_id').val();
            var api_id = $('#api_id').val();
            window.location = '/send-sms/'+campaign_id+'/'+api_id;
        }

        function onUpdatedBodyInput(){
            var body = $('#updated_body').val();
            $('#updated_body_count').val(body.length);
            $('#updated_body_count_div').text(body.length);
        }

        function updateText(campaign_id,body) {
            $('#campaign_id_update').val(campaign_id);
            $('#updated_body').val(body);
            $('#updated_body_count').val(body.length);
            $('#updated_body_count_div').text(body.length);
        }

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
                window.location = "/campaign/delete/"+id;
            }
        }

    </script>

@endsection
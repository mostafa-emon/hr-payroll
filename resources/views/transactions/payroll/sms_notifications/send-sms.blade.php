@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a style="color:#6c757d;">Send SMS</a></li>
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
                            <h4 class="card-title mg-b-0">Send SMS</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th colspan="2">Name</th>
                                    <th colspan="2">Phone</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                    <textarea class="form-control" style="height:80px" readonly>{{$campaign->sms_body}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Balance: <b><span id="balance">{{$sms_setting->sms_balance}}</span></b></td>
                                    <td>Total Receiver: <b>{{count($receivers)}}</b></td>
                                    <td>Total Request Sent: <b><span id="sent">{{$received}}</span></b></td>
                                    <td>Language: <b>{{$campaign->language}}</b></td>
                                    <td>SMS Text Length: <b>{{$campaign->body_length}}</b></td>
                                    <td>Send Per SMS:
                                    <b>@php
                                        if(!isset($sms_setting->eng_character_1)) {
                                        $send_per_sms = "";
                                        echo "<script>alert('Please setup you sms balance configuration first!')</script>";
                                        echo "<script>window.location = '/create-campaign'</script>";
                                        }else {
                                        if($campaign->language == "English") {
                                            if($campaign->body_length <= $sms_setting->eng_character_1){
                                            $send_per_sms = 1;
                                            }else if($campaign->body_length > $sms_setting->eng_character_1 && $campaign->body_length <= $sms_setting->eng_character_2){
                                            $send_per_sms = 2;
                                            }else if($campaign->body_length > $sms_setting->eng_character_2 && $campaign->body_length <= $sms_setting->eng_character_3){
                                            $send_per_sms = 3;
                                            }else if($campaign->body_length > $sms_setting->eng_character_3 && $campaign->body_length <= $sms_setting->eng_character_4){
                                            $send_per_sms = 4;
                                            }else if($campaign->body_length > $sms_setting->eng_character_4 && $campaign->body_length <= $sms_setting->eng_character_5){
                                            $send_per_sms = 5;
                                            }
                                        }else if($campaign->language == "Other Language") {
                                            if($campaign->body_length <= $sms_setting->other_character_1){
                                            $send_per_sms = 1;
                                            }else if($campaign->body_length > $sms_setting->other_character_1 && $campaign->body_length <= $sms_setting->other_character_2){
                                            $send_per_sms = 2;
                                            }else if($campaign->body_length > $sms_setting->other_character_2 && $campaign->body_length <= $sms_setting->other_character_3){
                                            $send_per_sms = 3;
                                            }else if($campaign->body_length > $sms_setting->other_character_3 && $campaign->body_length <= $sms_setting->other_character_4){
                                            $send_per_sms = 4;
                                            }else if($campaign->body_length > $sms_setting->other_character_4 && $campaign->body_length <= $sms_setting->other_character_5){
                                            $send_per_sms = 5;
                                            }
                                        }
                                        echo $send_per_sms;
                                        }
                                    @endphp</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" id="start-sending-btn"><button class="btn btn-success btn-block" onclick="sendsms()">START SENDING</button></td>
                                    <td colspan="6" id="pause-btn" style="display:none"><a class="btn btn-danger btn-block" href="javascript:void(0)" onclick="pauseSending()">PAUSE</a></td>
                                    <td colspan="6" id="back-btn" style="display:none"><a class="btn btn-secondary btn-block" href="{{url('create-campaign')}}">FINISHED (Back to campaigns)</a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        var balance = '{{$sms_setting->sms_balance}}'
        var sent    = '{{$received}}'

        var runRequests = function(totalSent) {
            var sl = totalSent + 1
            if (totalSent == '{{ count($receivers) - $received }}') {
            console.log("runRequests Success");
            return;
            }

            $.ajax({
                type:'GET',
                url:'/ajax-send-sms/'+sl+'/{{$send_per_sms}}/{{$campaign_id}}/{{$api_id}}',
                success:function(data) {
                    $('#tbody').append(data);
                    $('#start-sending-btn').hide();
                    $('#pause-btn').show();

                    balance = balance - '{{$send_per_sms}}'
                    sent = parseInt(sent) + 1

                    if(balance < '{{$send_per_sms}}'){
                    location.reload();
                    }else {
                    if(totalSent == ('{{ count($receivers) - $received }}' - 1)) {
                        $('#start-sending-btn').hide();
                        $('#pause-btn').hide();
                        $('#back-btn').show();
                    }

                    $('#balance').html('');
                    $('#balance').html(balance);

                    $('#sent').html('');
                    $('#sent').html(sent);
                    }
                },
                error: function() {
                    console.error("runRequests Error");
                },
                complete: function() {
                    runRequests(++totalSent);
                }
            });
        }

        function sendsms() {
            $('#start-sending-btn').hide();
            $('#pause-btn').show();
            runRequests(0);
        }

        function pauseSending() {
            window.stop();
            window.location = '/create-campaign'
        }
        
    </script>

@endsection
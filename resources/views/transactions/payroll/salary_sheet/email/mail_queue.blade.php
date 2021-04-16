@extends('layouts.master')

@section('content')

    <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a style="color:#6c757d;">Email Pay Slip</a></li>
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
                            <h4 class="card-title mg-b-0">Email Pay Slip</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="text-center">SL</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>

                            <tfoot>
                            <tr>
                                <td colspan="3">Total Receiver: <b>{{$total_receiver}}</b></td>
                                <td colspan="3">Total Sent: <b><span id="sent">{{$total_sent}}</span></b></td>
                            </tr>
                            <tr>
                                <td colspan="6" id="start-sending-btn" @if($total_receiver == $total_sent) style="display:none" @endif><button class="btn btn-success btn-block" onclick="sendsms()">START SENDING</button></td>
                                <td colspan="6" id="pause-btn" style="display:none"><a class="btn btn-danger btn-block" href="javascript:void(0)" onclick="pauseSending()">PAUSE</a></td>
                                <td colspan="6" id="back-btn" @if($total_receiver != $total_sent) style="display:none" @endif><a class="btn btn-secondary btn-block" href="{{url('salary-sheet')}}">FINISHED (Back)</a></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        var sent    = '{{$total_sent}}'

        var runRequests = function(totalSent) {
            var sl = totalSent + 1
            if (totalSent == '{{ $total_receiver - $total_sent }}') {
                console.log("runRequests Success");
                return;
            }

            $.ajax({
                type:'GET',
                url:'/ajax-send-pay-slip/'+sl+'/{{$request_month}}/{{$request_year}}',
                success:function(data) {
                    $('#tbody').append(data);
                    $('#start-sending-btn').hide();
                    $('#pause-btn').show();

                    sent = parseInt(sent) + 1

                    if(totalSent == ('{{ $total_receiver - $total_sent }}' - 1)) {
                        $('#start-sending-btn').hide();
                        $('#pause-btn').hide();
                        $('#back-btn').show();
                    }

                    $('#sent').html('');
                    $('#sent').html(sent);
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
            window.location = '/salary-sheet'
        }

    </script>

@endsection

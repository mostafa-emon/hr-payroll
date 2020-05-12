@extends('layouts.master')

@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
        <a class="breadcrumb-item" href="{{ url('/cheque-transactions') }}">MR</a>
        <span class="breadcrumb-item active">Print</span>
    </nav>
</div>

<div class="br-pagebody">
    <div id="printArea">
        <div id="containment-wrapper" style="font-family: Arial; padding:30px">
            <div style="float: left;width:55%;margin-top:-15px;">
              <h1 style="font-size: 20px; font-weight: bold;">{{$company->name}}</h1>
              <div style="margin-top:-10px">{{$site_office->address}}</div>
              <div>Phone: {{$site_office->phone}}</div>
              <div>Email: {{$site_office->email}}</div>
            </div>
        
            <div style="float: right; height:58px;">
                <img src="{{asset('storage/'.$company->logo)}}" height="100"/>
            </div>
        
            <div style="text-align: center; font-size: 27px; font-weight: bold; margin-top: 110px;margin-bottom:15px;text-align:right;">Money Receipt</div>
            
            <div style="float:left; width: 45%;">
              <div style="font-weight: bold; font-size: 19px;margin-top:-20px;">Received Form</div>
        
              <div style="border: 1px solid; padding-bottom: 10px; padding-top: 10px; padding-left: 10px; padding-right: 5px;height:70px" >
                <div>{{$transaction->customer_name}}</div>
                <div>{{$customer->address}}</div>
              </div>
            </div>
            
        
            <div style="float: right; padding-bottom: 10px;">
              <div>
                <div style="font-weight: bold; padding-right: 160px;">Money Receipt No</div>
                <div style="float: right; border: 1px solid; height: 22px; width: 47%; margin-top: -24px; text-align: center; padding-top: 4px;">{{ $transaction->invoice_no }}</div>
              </div><br>
              <div>
                <div style="font-weight: bold; padding-right: 160px;">Money Receipt Date</div>
                <div style="float: right; border: 1px solid; height: 22px; width: 47%; margin-top: -24px; text-align: center; padding-top: 4px;">{{ date('d-m-Y',strtotime($transaction->created_at))}}
                </div>
              </div><br>
              <div>
                <div style="font-weight: bold; padding-right: 160px;">Payment Method</div>
                <div style="float: right; border: 1px solid; height: 22px; width: 47%; margin-top: -24px; text-align: center; padding-top: 4px;">{{$transaction->payment_method}}
                </div>
              </div>
            </div>
            
            <div style="margin-top:135px;">
              <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                <thead>
                  <tr>
                    <th style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;">Sl</th>
                    <th style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;">Currency</th>
                    <th style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;">Cheque No</th>
                    <th style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;">Cheque Date</th>
                    <th style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;">Bank Name</th>
                    <th style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;">Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;">1</td>
                    <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;">{{$transaction->currency}}</td>
                    <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;">{{$transaction->cheque_no}}</td>
                    <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;">@if($transaction->cheque_date != "1970-01-01"){{date('d-m-Y',strtotime($transaction->cheque_date))}}@endif</td>
                    <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;">{{$transaction->bank_name}}</td>
                    <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;">{{$transaction->amount}}</td>
                  </tr>
  
                  {{--
                  <tr>
                      <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;"></td>
                      <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;"></td>
                      <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;"></td>
                      <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;"></td>
                      <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;"></td>
                      <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;font-size:14px;">&nbsp;</td>
                  </tr>
                  --}}
                  <tr style="border: 1px solid black;padding-top:3px;padding-bottom:3px;">
                    <td colspan="5" style="text-align: right;padding-top:3px;padding-bottom:3px;padding-right:10px;">Total</td>
                    <td style="text-align: center; border: 1px solid black;padding-top:3px;padding-bottom:3px;">{{$transaction->amount}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
        
            <div style="margin-top: 15px;">
              <div style="float: left;">Amount in Word
              </div>
              <div style="float: left; padding-left: 20px;">{{$transaction->amount_in_word}}
              </div>
              <br>
              <div style="float: left; padding-left: 138px; margin-top: -13px;">_________________________________________________________________
              </div>
            </div>
            <br>
        
            <div>
              <div style="float: left;">Purpose
              </div>
              <div style="float: left; padding-left: 76px;">{{$transaction->purpose}}
              </div>
              <br>
              <div style="float: left; padding-left: 136px; margin-top: -13px;">_________________________________________________________________
              </div>
            </div>
            <br>
        
            <div style="margin-top: 40px; float: left; margin-bottom: 80px;">
              <div style="text-align: center;">
              </div>
              <br>
              <div style="margin-top: -32px;">__________________
              </div><br>
              <div style="margin-left: 37px; margin-top: -16px;">Received By
              </div>
            </div>
        
            <div style="margin-top: 40px; float: right; margin-bottom: 80px;">
              <div style="text-align: center;">
              </div>
              <br>
              <div style="margin-top: -32px;">______________________
              </div><br>
              <div style="margin-left: 50px; margin-top: -16px;">Authorized By
              </div>
            </div>
        </div>
    </div>
</div>

<script>
    var mywindow = window.open('', 'PRINT');
    mywindow.document.write('<style>#containment-wrapper{background-image: url("{{ asset("img/draft-half-mr.png")}}"); background-repeat: no-repeat; background-size: cover;}</style>');
    mywindow.document.write(document.getElementById('printArea').innerHTML);

    setTimeout(function () {
        mywindow.focus();
        mywindow.print();
        mywindow.close();

        window.location = "/mr"
    }, 1000);

</script>
@endsection
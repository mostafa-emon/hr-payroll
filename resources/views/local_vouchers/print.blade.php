@extends('layouts.master')

@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
        <span class="breadcrumb-item active">Voucher Print</span>
    </nav>
</div>

@php
      if($settings->voucher_size == "half_page"){
        $page_height = 149;
      } else{
        $page_height = 297;
      }
      if($layout->type == "Cash-Payment-Voucher") {
        $colspan = 4;
        if($layout->customer_job != 1){ $colspan = $colspan - 1; }
        if($layout->class != 1){ $colspan = $colspan - 1; }
        if($layout->name == 1){ $colspan = $colspan + 1; }
      }
      else if($layout->type == "Bank-Payment-Voucher") {
        $colspan = 4;
        if($layout->customer_job != 1){ $colspan = $colspan - 1; }
        if($layout->class != 1){ $colspan = $colspan - 1; }
        if($layout->name == 1){ $colspan = $colspan + 1; }
      }
      else if($layout->type == "Cash-Receipt-Voucher") {
        $colspan = 3;
        if($layout->class != 1){ $colspan = $colspan - 1; }
        if($layout->customer_job == 1){ $colspan = $colspan + 1; }
        if($layout->name == 1){ $colspan = $colspan + 1; }
      }
      else if($layout->type == "Bank-Receipt-Voucher") {
        $colspan = 3;
        if($layout->class != 1){ $colspan = $colspan - 1; }
        if($layout->customer_job == 1){ $colspan = $colspan + 1; }
        if($layout->name == 1){ $colspan = $colspan + 1; }
      }
      else if($layout->type == "Contra-Voucher") {
        $colspan = 3;
        if($layout->class != 1){ $colspan = $colspan - 1; }
        if($layout->customer_job == 1){ $colspan = $colspan + 1; }
        if($layout->name == 1){ $colspan = $colspan + 1; }
      }
      else if($layout->type == "Journal-Voucher") {
        $colspan = 3;
        if($layout->class != 1){ $colspan = $colspan - 1; }
        if($layout->customer_job == 1){ $colspan = $colspan + 1; }
        if($layout->name == 1){ $colspan = $colspan + 1; }
      }
      $type = $layout->type
    @endphp

<div class="br-pagebody">
    <div id="printArea">
        <div id="containment-wrapper" style="height: {{$page_height}}mm; width: 210mm; position: relative">
            <div style="font-family:arial;margin-top:3mm;text-align:center;color:black;font-size:13px;font-weight:bold">
              <div style="font-size: 15px;">{{$company->name}}</div>
              <div style="width:75mm;margin-left:70mm;">{{$company->address}}</div>
              <div style="margin-top:8px">{{ str_replace("-", " ", $type) }}</div>
            </div>
            <div id="qblogo" style="position: absolute;top: {{$layout->qb_logo_top}}mm;left: {{$layout->qb_logo_left}}mm"><img src="{{ asset('storage/'.$company->logo) }}" height="45"/></div>
            <div id="voucher_no" style="position: absolute; top: {{$layout->voucher_no_top}}mm; left: {{$layout->voucher_no_left}}mm; font-family: arial; font-size: 13px; font-weight:bold; color: black;">Voucher No : {{$voucher->prefix}}-{{$voucher->voucher_no}}-{{$voucher->suffix}}</div>
            <div id="voucher_date"  style="position: absolute; top: {{$layout->voucher_date_top}}mm; left: {{$layout->voucher_date_left}}mm; font-family: arial; font-size: 13px; font-weight:bold; color: black;">Voucher Date : {{date('d-M-y',strtotime($voucher->voucher_date))}}</div>
            <div id="payee_name" style="@if($layout->payee_name != 1) display:none; @endif position: absolute; top: {{$layout->payee_name_top}}mm; left: {{$layout->payee_name_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Payee Name : {{$voucher->payee_name}}</div>
            <div id="cheque_name" style="@if($layout->cheque_no != 1) display:none; @endif position: absolute; top: {{$layout->cheque_no_top}}mm; left: {{$layout->cheque_no_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Cheque No : {{$voucher->cheque_no}}</div>
            <div id="cheque_date" style="@if($layout->cheque_date != 1) display:none; @endif position: absolute; top: {{$layout->cheque_date_top}}mm; left: {{$layout->cheque_date_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Cheque Date : @if($voucher->cheque_date != "1970-01-01") {{date('d-M-y',strtotime($voucher->cheque_date))}} @endif</div>
            <div id="received_from" style="@if($layout->received_from != 1) display:none; @endif position: absolute; top: {{$layout->received_from_top}}mm; left: {{$layout->received_from_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Received From : {{$voucher->received_from}}</div>
            <div id="location" style="@if($layout->location != 1) display:none; @endif position: absolute; top: {{$layout->location_top}}mm; left: {{$layout->location_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Location : {{$voucher->location}}</div>
            <div id="reference_no" style="@if($layout->reference_no != 1) display:none; @endif position: absolute; top: {{$layout->reference_no_top}}mm; left: {{$layout->reference_no_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">QB Ref No : {{$voucher->reference_no}}</div>

            <div id="tableDiv" style="position: absolute; top: {{$layout->table_top}}mm; left: {{$layout->table_left}}mm; width: 95% !important;color:black;font-size:13px;font-family:arial">
              <table cellpadding="0" cellspacing="0" style="width:100% !important;font-size:13px">
                <thead>
                  <th class="account_code" style="border-top:1px solid black; border-bottom:1px solid black; border-left:1px solid black;text-align:center;">Account Code & Name</th>
                  <th style="border-top:1px solid black; border-bottom:1px solid black; border-left:1px solid black;text-align:center;">Memo</th>
                  <th class="customer_job" style="@if($layout->customer_job != 1) display:none; @endif border-top:1px solid black; border-bottom:1px solid black; border-left:1px solid black;text-align:center;">Customer:Job/Project</th>
                  <th class="class" style="@if($layout->class != 1) display:none; @endif border-top:1px solid black; border-bottom:1px solid black; border-left:1px solid black;text-align:center;">Class</th>
                  <th class="name" style="@if($layout->name != 1) display:none; @endif border-top:1px solid black; border-bottom:1px solid black; border-left:1px solid black;text-align:center;">Name</th>
                  <th style="text-align:right;border-top:1px solid black; border-bottom:1px solid black; border-left:1px solid black;text-align:center;">Debit</th>
                  <th style="text-align:right;border-top:1px solid black; border-bottom:1px solid black; border-left:1px solid black;border-right:1px solid black;text-align:center;">Credit</th>
                </thead>

                <tbody>
                    @foreach($voucher_details as $detail)
                        <tr>
                            <td class="account_code" style="border-bottom:1px solid black; border-left:1px solid black;">{{$detail->account_code_name}}</td>
                            <td style="border-bottom:1px solid black; border-left:1px solid black;">{{$detail->memo}}</td>
                            <td class="customer_job" style="@if($layout->customer_job != 1) display:none; @endif border-bottom:1px solid black; border-left:1px solid black;">{{$detail->customer_job_project_name}}</td>
                            <td class="class" style="@if($layout->class != 1) display:none; @endif border-bottom:1px solid black; border-left:1px solid black;">{{$detail->class}}</td>
                            <td class="name" style="@if($layout->name != 1) display:none; @endif border-bottom:1px solid black; border-left:1px solid black;">{{$detail->customer_job_project_name}}</td>
                            <td style="text-align:right;border-bottom:1px solid black; border-left:1px solid black;text-align:right;">{!! number_formatting($detail->debit) !!}</td>
                            <td style="text-align:right;border-bottom:1px solid black; border-left:1px solid black;border-right:1px solid black;text-align:right;">{!! number_formatting($detail->credit) !!}</td>
                        </tr>
                    @endforeach
                    <tr>
                      <th id="table_total" colspan="{{$colspan}}" style="border-bottom:1px solid black; border-left:1px solid black;border-bottom: 1px solid black;text-align:right;">Total</th>
                      <th style="border-bottom:1px solid black; border-left:1px solid black;border-bottom: 1px solid black;text-align:right;">{!! number_formatting($voucher->total_debit) !!}</th>
                      <th style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black;border-bottom: 1px solid black;text-align:right;">{!! number_formatting($voucher->total_credit) !!}</th>
                    </tr>
                </tbody>
              </table>

              <div style="font-weight: bold;margin-top:5px">Amount in Word : {{$voucher->amount_in_word}}</div>
              
              <div id="signatory" style="padding-top:80px;width: 100% !important; color:black;font-size:13px;font-family:arial">
                <div>
  
                  <table style="width:100%">
                    @php
                      use App\Signatory;
                      $query = strtolower(str_replace("-", "_", $type));
                      $signatories = Signatory::where($query,1)->get();
                    @endphp
                    
                    <tr>
                    @foreach($signatories as $signatory)
                      <td style="text-align:center;">__________________<br>{{$signatory->name}}</td>
                    @endforeach
                    </tr>
                    
                  </table>
                  
                </div>
              </div>

            </div>

          </div>
    </div>
</div>

<script>
    var mywindow = window.open('', 'PRINT');
    mywindow.document.write('<style>td,th{padding:5px}</style>');
    mywindow.document.write(document.getElementById('printArea').innerHTML);
    
    var redirect_to = '';
    var layout_type = '{{$layout->type}}';
    if(layout_type == "Cash-Payment-Voucher") {redirect_to = 'tr-cash-payment-voucher';}
    else if(layout_type == "Bank-Payment-Voucher") {redirect_to = 'tr-bank-payment-voucher';}
    else if(layout_type == "Cash-Receipt-Voucher") {redirect_to = 'tr-cash-receipt-voucher';}
    else if(layout_type == "Bank-Receipt-Voucher") {redirect_to = 'tr-bank-receipt-voucher';}
    else if(layout_type == "Contra-Voucher") {redirect_to = 'tr-contra-voucher';}
    else if(layout_type == "Journal-Voucher") {redirect_to = 'tr-journal-voucher';}

    setTimeout(function () {
        mywindow.focus();
        mywindow.print();
        mywindow.close();
        window.location = '/'+redirect_to;
    }, 1000);
    
</script>
@endsection
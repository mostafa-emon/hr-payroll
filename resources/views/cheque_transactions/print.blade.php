@extends('layouts.master')

@section('content')
  <style>
    #containment-wrapper {
      border: 1px solid #909497;
      background-size: 2mm 2mm;
      background-image:
      linear-gradient(to right, #D7DBDD 1px, transparent 1px),
      linear-gradient(to bottom, #D7DBDD 1px, transparent 1px);
    }
  </style>

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/cheque-transactions') }}">Cheque</a>
      <span class="breadcrumb-item active">Print</span>
    </nav>
  </div>
 
  <div class="br-pagebody">
      <div class="row">
        <div class="col-md-12 mg-t-10 d-flex align-items-center justify-content-center bg-white">
          
          <div class="card pd-0 bd-0 pd-30 table-responsive">
            <div id="printArea">
              <div id="containment-wrapper" style="height: {{$layout->height}}mm; width: {{$layout->width}}mm; position: relative">
                <div id="acpay" class="draggable ui-widget-content" style="position: absolute;top:{{$layout->ac_payee_only_top}}mm;left:{{$layout->ac_payee_only_left}}mm;@if($transaction->ac_payee_only == 0) display:none; @endif"><img src="{{ asset('img/acpay.png') }}"/></div>
                <div id="date" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->date_top}}mm; left: {{$layout->date_left}}mm; letter-spacing: {{$layout->date_letter_spacing}}px; font-family: Courier; font-size: {{$layout->date_font_size}}px; color: black; @if($layout->date == 0) display:none; @endif">@if($layout->date_format == "DDMMYYYY"){{ date('dmY',strtotime($transaction->date))}}@else{{ date('mdY',strtotime($transaction->date))}}@endif</div>
                <div id="payee" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->payee_top}}mm; left: {{$layout->payee_left}}mm; letter-spacing: {{$layout->payee_letter_spacing}}px; font-family: Arial; font-size: {{$layout->payee_font_size}}px; color: black; @if($layout->payee == 0) display:none; @endif">{{$transaction->cheque_name}}</div>
                <div id="amount" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->amount_top}}mm; left: {{$layout->amount_left}}mm; letter-spacing: {{$layout->amount_letter_spacing}}px; font-family: Arial; font-size: {{$layout->amount_font_size}}px; color: black; @if($layout->amount == 0) display:none; @endif">{{ $transaction->amount }}</div>
                <div id="amount_in_word_line_1" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->amount_in_word_line_1_top}}mm; left: {{$layout->amount_in_word_line_1_left}}mm; letter-spacing: {{$layout->amount_in_word_letter_spacing}}px; font-family: Arial; font-size: {{$layout->amount_in_word_font_size}}px; color: black; @if($layout->amount_in_word_line_1 == 0) display:none; @endif">{{ $transaction->amount_in_word_line_1 }}</div>
                <div id="amount_in_word_line_2" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->amount_in_word_line_2_top}}mm; left: {{$layout->amount_in_word_line_2_left}}mm; letter-spacing: {{$layout->amount_in_word_letter_spacing}}px; font-family: Arial; font-size: {{$layout->amount_in_word_font_size}}px; color: black; @if($layout->amount_in_word_line_2 == 0) display:none; @endif">{{ $transaction->amount_in_word_line_2 }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <script>
    var printConf   = '{{$layout->printer_setup}}'.split("_");
    var mywindow = window.open('', 'PRINT');
    mywindow.document.write('<style>#containment-wrapper{margin-left:'+printConf[1]+';margin-top:'+printConf[0]+'; transform: rotate('+printConf[2]+'deg);</style>');
    mywindow.document.write(document.getElementById('printArea').innerHTML);

    setTimeout(function () {
        mywindow.focus();
        mywindow.print();
        mywindow.close();
        window.location = "/create-cheque"
    }, 1000);

  </script>
@endsection
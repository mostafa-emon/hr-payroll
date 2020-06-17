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
      else if($layout->type == "Bank-Payment-Voucher") { $colspan = 4;
        if($layout->customer_job != 1){ $colspan = $colspan - 1; }
        if($layout->class != 1){ $colspan = $colspan - 1; }
        if($layout->name == 1){ $colspan = $colspan + 1; }
      }
      else if($layout->type == "Cash-Receipt-Voucher") { $colspan = 3;
        if($layout->class != 1){ $colspan = $colspan - 1; }
        if($layout->customer_job == 1){ $colspan = $colspan + 1; }
        if($layout->name == 1){ $colspan = $colspan + 1; }
      }
      else if($layout->type == "Bank-Receipt-Voucher") { $colspan = 3;
        if($layout->class != 1){ $colspan = $colspan - 1; }
        if($layout->customer_job == 1){ $colspan = $colspan + 1; }
        if($layout->name == 1){ $colspan = $colspan + 1; }
      }
      else if($layout->type == "Contra-Voucher") { $colspan = 3;
        if($layout->class != 1){ $colspan = $colspan - 1; }
        if($layout->customer_job == 1){ $colspan = $colspan + 1; }
        if($layout->name == 1){ $colspan = $colspan + 1; }
      }
      else if($layout->type == "Journal-Voucher") { $colspan = 3;
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
            <div id="qblogo" style="position: absolute;top: {{$layout->qb_logo_top}}mm;left: {{$layout->qb_logo_left}}mm"><img src="{{ asset('img/qblogo.png') }}" height="35"/></div>
            <div id="voucher_no" style="position: absolute; top: {{$layout->voucher_no_top}}mm; left: {{$layout->voucher_no_left}}mm; font-family: arial; font-size: 13px; font-weight:bold; color: black;">Voucher No : {{$settings->voucher_prefix}}{{$voucher->voucher_no}}{{$settings->voucher_suffix}}</div>
            <div id="voucher_date"  style="position: absolute; top: {{$layout->voucher_date_top}}mm; left: {{$layout->voucher_date_left}}mm; font-family: arial; font-size: 13px; font-weight:bold; color: black;">Voucher Date : {{date('d-M-y',strtotime($voucher->voucher_date))}}</div>
            <div id="payee_name" style="@if($layout->payee_name != 1) display:none; @endif position: absolute; top: {{$layout->payee_name_top}}mm; left: {{$layout->payee_name_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Payee Name : {{$voucher->payee_name}}</div>
            <div id="cheque_name" style="@if($layout->cheque_no != 1) display:none; @endif position: absolute; top: {{$layout->cheque_no_top}}mm; left: {{$layout->cheque_no_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Cheque No : {{$voucher->cheque_no}}</div>
            <div id="cheque_date" style="@if($layout->cheque_date != 1) display:none; @endif position: absolute; top: {{$layout->cheque_date_top}}mm; left: {{$layout->cheque_date_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Cheque Date : {{$voucher->cheque_date}}</div>
            <div id="received_from" style="@if($layout->received_from != 1) display:none; @endif position: absolute; top: {{$layout->received_from_top}}mm; left: {{$layout->received_from_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Received From : {{$voucher->received_from}}</div>
            <div id="location" style="@if($layout->location != 1) display:none; @endif position: absolute; top: {{$layout->location_top}}mm; left: {{$layout->location_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Location : {{$voucher->location}}</div>
            <div id="reference_no" style="@if($layout->reference_no != 1) display:none; @endif position: absolute; top: {{$layout->reference_no_top}}mm; left: {{$layout->reference_no_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black;">Reference No : {{$voucher->reference_no}}</div>

            <div id="tableDiv" style="position: absolute; top: {{$layout->table_top}}mm; left: {{$layout->table_left}}mm; width: 95% !important;color:black;font-size:13px;font-family:arial">
              <table cellpadding="0" cellspacing="0" style="width:100% !important;font-size:13px">
                <thead>
                  <th class="account_code" style="border-top:1px solid black; border-left:1px solid black;text-align:left;">Account Code & Name</th>
                  <th style="border-top:1px solid black; border-left:1px solid black;text-align:left;">Memo</th>
                  <th class="customer_job" style="@if($layout->customer_job != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;text-align:left;">Customer:Job/Project</th>
                  <th class="class" style="@if($layout->class != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;text-align:left;">Class</th>
                  <th class="name" style="@if($layout->name != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;text-align:left;">Name</th>
                  <th style="text-align:right;border-top:1px solid black; border-left:1px solid black;text-align:right;">Debit</th>
                  <th style="text-align:right;border-top:1px solid black; border-left:1px solid black;border-right:1px solid black;text-align:right;">Credit</th>
                </thead>

                <tbody>
                    @php $total_debit = 0; $total_credit = 0; @endphp
                    @foreach($voucher_details as $detail)
                        @php 
                            $total_debit = $total_debit + $detail->debit;
                            $total_credit = $total_credit + $detail->credit;
                        @endphp
                        <tr>
                            <td class="account_code" style="border-top:1px solid black; border-left:1px solid black;">{{$detail->account_code_name}}</td>
                            <td style="border-top:1px solid black; border-left:1px solid black;">{{$detail->memo}}</td>
                            <td class="customer_job" style="@if($layout->customer_job != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;">{{$detail->customer_job_project_name}}</td>
                            <td class="class" style="@if($layout->class != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;">{{$detail->class}}</td>
                            <td class="name" style="@if($layout->name != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;">{{$detail->customer_job_project_name}}</td>
                            <td style="text-align:right;border-top:1px solid black; border-left:1px solid black;text-align:right;">{{$detail->debit}}</td>
                            <td style="text-align:right;border-top:1px solid black; border-left:1px solid black;border-right:1px solid black;text-align:right;">{{$detail->credit}}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                  <th id="table_total" colspan="{{$colspan}}" style="border-top:1px solid black; border-left:1px solid black;border-bottom: 1px solid black;text-align:center;">Total</th>
                  <th style="border-top:1px solid black; border-left:1px solid black;border-bottom: 1px solid black;text-align:right;">{{$total_debit}}</th>
                  <th style="border-top:1px solid black; border-left:1px solid black; border-right:1px solid black;border-bottom: 1px solid black;text-align:right;">{{$total_credit}}</th>
                </tfoot>
              </table>

              <div style="font-weight: bold;margin-top:5px">Amount in Word :</div>
            </div>

            <div id="signatory" style="position: absolute; top: {{$layout->signatory_top}}mm; width: 100% !important; color:black;font-size:13px;font-family:arial">
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

<script>
    /*
    var mywindow = window.open('', 'PRINT');
    mywindow.document.write('<style>td,th{padding:5px}</style>');
    mywindow.document.write(document.getElementById('printArea').innerHTML);
    */
    var redirect_to = '';
    var layout_type = '{{$layout->type}}';
    if(layout_type == "Cash-Payment-Voucher") {redirect_to = 'tr-cash-payment-voucher';}
    else if(layout_type == "Bank-Payment-Voucher") {redirect_to = 'tr-bank-payment-voucher';}
    else if(layout_type == "Cash-Receipt-Voucher") {redirect_to = 'tr-cash-receipt-voucher';}
    else if(layout_type == "Bank-Receipt-Voucher") {redirect_to = 'tr-bank-receipt-voucher';}
    else if(layout_type == "Contra-Voucher") {redirect_to = 'tr-contra-voucher';}
    else if(layout_type == "Journal-Voucher") {redirect_to = 'tr-journal-voucher';}

    var value = '500'
    
    if(value != ''){ 

        var removeUnwanted = value.replace(/[^0-9.]/g, "")

        var makeDecimal  = (Math.round(removeUnwanted * 100) / 100).toFixed(2);
        var splitDecimal = makeDecimal.split(".");
        var mainPart     = splitDecimal[0];
        var decimalPart  = splitDecimal[1];

        var amount = mainPart

        var amount_in_word_format = '{{ $settings->amount_in_word_format }}';
        
        if(amount_in_word_format == 'crore_lakh_thousand' || amount_in_word_format == 'crore_lac_thousand') {
          
          var words = new Array();
          words[0] = '';
          words[1] = 'One';
          words[2] = 'Two';
          words[3] = 'Three';
          words[4] = 'Four';
          words[5] = 'Five';
          words[6] = 'Six';
          words[7] = 'Seven';
          words[8] = 'Eight';
          words[9] = 'Nine';
          words[10] = 'Ten';
          words[11] = 'Eleven';
          words[12] = 'Twelve';
          words[13] = 'Thirteen';
          words[14] = 'Fourteen';
          words[15] = 'Fifteen';
          words[16] = 'Sixteen';
          words[17] = 'Seventeen';
          words[18] = 'Eighteen';
          words[19] = 'Nineteen';
          words[20] = 'Twenty';
          words[30] = 'Thirty';
          words[40] = 'Forty';
          words[50] = 'Fifty';
          words[60] = 'Sixty';
          words[70] = 'Seventy';
          words[80] = 'Eighty';
          words[90] = 'Ninety';
          amount = amount.toString();
          var atemp = amount.split(".");
          var number = atemp[0].split(",").join("");
          var n_length = number.length;
          var words_string = "";
          if (n_length <= 9) {
              var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
              var received_n_array = new Array();
              for (var i = 0; i < n_length; i++) {
                  received_n_array[i] = number.substr(i, 1);
              }
              for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                  n_array[i] = received_n_array[j];
              }
              for (var i = 0, j = 1; i < 9; i++, j++) {
                  if (i == 0 || i == 2 || i == 4 || i == 7) {
                      if (n_array[i] == 1) {
                          n_array[j] = 10 + parseInt(n_array[j]);
                          n_array[i] = 0;
                      }
                  }
              }
              value = "";
              for (var i = 0; i < 9; i++) {
                  if (i == 0 || i == 2 || i == 4 || i == 7) {
                      value = n_array[i] * 10;
                  } else {
                      value = n_array[i];
                  }
                  if (value != 0) {
                      words_string += words[value] + " ";
                  }
                  if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                      words_string += "Crore ";
                  }
                  if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                    if(amount_in_word_format == 'crore_lakh_thousand') {
                      words_string += "Lakh ";
                    }else if(amount_in_word_format == 'crore_lac_thousand') {
                      words_string += "Lac ";
                    } 
                  }
                  if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                      words_string += "Thousand ";
                  }
                  if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                      words_string += "Hundred ";
                  } else if (i == 6 && value != 0) {
                      words_string += "Hundred ";
                  }
              }
              words_string = words_string.split("  ").join(" ");
          }
        }
        else if(amount_in_word_format == 'billion_million_thousand'){
            var th = ['','thousand', 'million', 'billion', 'trillion'];
            var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine'];
            var tn=['ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen'];
            var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

            var s = amount;
            alert(amount_in_word_format);
        }
        alert(amount_in_word_format);
    }
    /*
    setTimeout(function () {
        mywindow.focus();
        mywindow.print();
        mywindow.close();
        window.location = '/'+redirect_to;
    }, 1000);
    */
</script>
@endsection
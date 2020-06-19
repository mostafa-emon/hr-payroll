@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <span class="breadcrumb-item active">Voucher Preview</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Voucher Preview</h4>
  </div>

  <form id="thisForm" action="{{ url('voucher/add') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="type" value="{{$voucher_type}}"/>
    <input type="hidden" name="api_type" value="{{$api_type}}"/>
    <input type="hidden" name="document_id" value="{{$data['id']}}"/>
    <input type="hidden" name="print_status" value="{{$print_status}}"/>

    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-control-label">Voucher No: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="voucher_no" placeholder="Enter Voucher No" @if($data['voucher_no'] != "") value="{{$data['voucher_no']}}" @endif>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Voucher Date: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="voucher_date" placeholder="Enter Voucher Date" @if($data['voucher_date'] != "") value="{{ date('d-m-Y',strtotime($data['voucher_date']))}}" @endif>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">QB Ref No:</label>
                <input class="form-control" type="text" name="reference_no" placeholder="Enter Reference No" @if($data['reference_no'] != "") value="{{$data['reference_no']}}" @endif>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Payee Name:</label>
                <input class="form-control" type="text" name="payee_name" placeholder="Enter Payee Name" @if($data['payee_name'] != "") value="{{$data['payee_name']}}" @endif>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Received From:</label>
                <input class="form-control" type="text" name="received_from" placeholder="Enter Received From" @if($data['received_from'] != "") value="{{$data['received_from']}}" @endif>
              </div>
            </div>

            <div class="col-md-4">
                <div class="form-group bd-t-0-force">
                    <label class="form-control-label">Cheque No:</label>
                    <input class="form-control" type="text" name="cheque_no" placeholder="Enter Cheque Number" @if($data['cheque_no'] != "") value="{{$data['cheque_no']}}" @endif>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group bd-t-0-force mg-md-l--1">
                    <label class="form-control-label">Cheque Date:</label>
                    <input class="form-control" type="text" id="cheque_date" name="cheque_date" placeholder="Enter Cheque Date" autocomplete="off" @if($data['cheque_date'] != "") value="{{ date('d-m-Y',strtotime($data['cheque_date']))}}" @endif>
                </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Location:</label>
                <input class="form-control" type="text" name="location" placeholder="Enter Location" @if($data['location'] != "") value="{{$data['location']}}" @endif>
              </div>
            </div>
          </div>
        </div>

        <br>
        
        <div class="bd bd-gray-300 rounded table-responsive">
          <table class="table table-striped mg-b-0">
            <thead>
              <tr>
                <th>Account Code & Name</th>
                <th>Memo</th>
                <th>Customer:Job/Project/Name</th>
                <th>Class</th>
                <th>Debit</th>
                <th>Credit</th>
              </tr>
            </thead>
            <tbody>
              @php $total_debit = 0; $total_credit = 0; @endphp
              @if($data['transactions'] != [])
              @foreach($data['transactions'] as $row)
              @php
                if($row['debit'] != ""){
                  $total_debit = $total_debit + $row['debit'];
                }
                if($row['credit'] != ""){
                  $total_credit = $total_credit + $row['credit'];
                }
              @endphp
              <tr>
                <td>
                  {{$row['account_code_name']}}
                  <input type="hidden" name="account_code_name[]" value="{{$row['account_code_name']}}"/>
                </td>
                <td>
                  {{$row['memo']}}
                  <input type="hidden" name="memoDetails[]" value="{{$row['memo']}}"/>
                </td>
                <td>
                  {{$row['customer_job_project_name']}}
                  <input type="hidden" name="customer_job_project_name[]" value="{{$row['customer_job_project_name']}}"/>
                </td>
                <td>
                  {{$row['class']}}
                  <input type="hidden" name="class[]" value="{{$row['class']}}"/>
                </td>
                <td>
                  {{$row['debit']}}
                  <input type="hidden" name="debit[]" value="{{$row['debit']}}"/>
                </td>
                <td>
                  {{$row['credit']}}
                  <input type="hidden" name="credit[]" value="{{$row['credit']}}"/>
                </td>
              </tr>
              @endforeach
              @endif
              <tr>
                <td colspan="4" style="text-align:center;font-weight:bold;">Total</td>
                <td style="font-weight:bold;">{{$total_debit}}</td>
                <td style="font-weight:bold;">{{$total_credit}}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <br>

        <div class="form-layout form-layout-2">
          <div class="row no-gutters">
            <div class="col-md-3">
              <div class="form-group">
                <label class="form-control-label mg-b-0-force">Voucher Format: <span class="tx-danger">*</span></label>
                    <select name="voucher_format_id" class="form-control mg-l--4">
                      <option value="">Default</option>
                      @foreach($voucher_formats as $voucher_format)
                        <option value="{{$voucher_format->id}}">{{$voucher_format->title}}</option>
                      @endforeach
                    </select> 
              </div>
            </div>

            <input type="hidden" name="total_debit" value="{{$total_debit}}"/>
            <input type="hidden" id="total_credit" name="total_credit" value="{{$total_credit}}"/>
            <input type="hidden" id="amount_in_word" name="amount_in_word"/>
            <input type="hidden" id="currency_full_name" value="{{$currency->full_name}}"/>
            <input type="hidden" id="currency_fraction_name" value="{{$currency->fraction_name}}"/>
            
            <input type="hidden" name="memo" value="{{$data['memo']}}"/>
            <div class="col-md-9">
              <div class="form-group mg-md-l--1">
                <a onclick="calculateAmountInWord()" class="btn btn-success pointer" style="width:100px;color:white;">Print</a>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </form>

@endsection

<script>
  function calculateAmountInWord() {
      var value = $('#total_credit').val();
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
            s = s.toString();
            s = s.replace(/[\, ]/g,'');
            if (s != parseFloat(s)) return 'not a number';
            var x = s.indexOf('.');
            if (x == -1)
            x = s.length;
            if (x > 15)
            return 'too big';
            var n = s.split('');
            var str = '';
            var sk = 0;
            for (var i=0; i < x; i++)
            {
              if ((x-i)%3==2)
              {
                if (n[i] == '1')
                {
                  str += tn[Number(n[i+1])] + ' ';
                  i++;
                  sk=1;
                }
                else if (n[i]!=0)
                {
                  str += tw[n[i]-2] + ' ';
                  sk=1;
                }
              }
              else if (n[i]!=0)
              {
                str += dg[n[i]] +' ';
                if ((x-i)%3==0) str += 'hundred ';
                sk=1;
              }
              if ((x-i)%3==1)
              {
                if (sk)
                  str += th[(x-i-1)/3] + ' ';
                  sk=0;
              }
            }
            if (x != s.length)
            {
              var y = s.length;
              str += 'point ';
              for (var i=x+1; i<y; i++)
              str += dg[n[i]] +' ';
            }
            var final = str.replace(/\s+/g,' ');
            var words_string = final.replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())))
        }

        // DECIMAL PART START
          var th = ['','thousand', 'million', 'billion', 'trillion'];
          var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine'];
          var tn=['ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen'];
          var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

          var s = decimalPart;
          s = s.toString();
          s = s.replace(/[\, ]/g,'');
          if (s != parseFloat(s)) return 'not a number';
          var x = s.indexOf('.');
          if (x == -1)
          x = s.length;
          if (x > 15)
          return 'too big';
          var n = s.split('');
          var str = '';
          var sk = 0;
          for (var i=0; i < x; i++)
          {
            if ((x-i)%3==2)
            {
              if (n[i] == '1')
              {
                str += tn[Number(n[i+1])] + ' ';
                i++;
                sk=1;
              }
              else if (n[i]!=0)
              {
                str += tw[n[i]-2] + ' ';
                sk=1;
              }
            }
            else if (n[i]!=0)
            {
              str += dg[n[i]] +' ';
              if ((x-i)%3==0) str += 'hundred ';
              sk=1;
            }
            if ((x-i)%3==1)
            {
              if (sk)
                str += th[(x-i-1)/3] + ' ';
                sk=0;
            }
          }
          if (x != s.length)
          {
            var y = s.length;
            str += 'point ';
            for (var i=x+1; i<y; i++)
            str += dg[n[i]] +' ';
          }
          var final = str.replace(/\s+/g,' ');
          var decimalString = final.replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())))
        // DECIMAL PART END

        // START MECHANISM
        if(words_string != "") {
          words_string = $('#currency_full_name').val() + ' ' + words_string;
        }

        if(decimalString != "") {
          decimalString = 'and ' + $('#currency_fraction_name').val() + ' ' + decimalString;
        }

        var fullString = words_string + decimalString + 'Only'
        $('#amount_in_word').val(fullString);

      }
      document.getElementById("thisForm").submit();
    }
</script>
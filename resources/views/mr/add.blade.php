@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/mr') }}">MR</a>
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Add MR</h4>
  </div>

  <form action="{{ url('mr/add') }}" method="POST">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Purpose:</label>
                <input class="form-control" type="text" name="purpose" placeholder="Enter Purpose">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label mg-b-0-force">Payment Method: <span class="tx-danger">*</span></label>
                    <select name="payment_method" class="form-control mg-l--4" onchange="setAmount();datePickerAction()">
                        <option value="">-- select method --</option>
                        @foreach($payment_methods as $payment_method)
                            <option value="{{ $payment_method->method_name }}">{{ $payment_method->method_name }}</option>
                        @endforeach
                    </select> 
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">MR Number:  @if($settings->mr_number == "auto") (N/A) @endif</label>
                <input class="form-control" type="text" name="invoice_no" placeholder="Enter Invoice No." @if($settings->mr_number == "auto") readonly @else required @endif>
              </div>
            </div>

            <div class="col-md-6 mg-t--1 mg-md-t-0">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Customer:  <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="customer_name" value="{{ $data['received_from'] }}" readonly>
              </div>
            </div>

            <div class="col-md-3 mg-t--1 mg-md-t-0">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label mg-b-0-force">Currency: <span class="tx-danger">*</span></label>
                  <select name="currency" class="form-control mg-l--4" onchange="setCurrency(this.value)">
                      <option value="" disabled selected>Select Currency</option>
                      @foreach($currencies as $currency)
                          <option value="{{ $currency->full_name }}_{{ $currency->fraction_name }}" @if($currency->full_name == $defaults->full_name) selected @endif>{{ $currency->full_name }}</option>
                      @endforeach
                  </select> 
                  <input type="hidden" id="currency_full_name" value="BDT"/>
                  <input type="hidden" id="currency_fraction_name" value="Paisa"/>
              </div>
            </div>

            <div class="col-md-3 mg-t--1 mg-md-t-0">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Amount: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" id="realAmount" name="amount" readonly>
                <input type="hidden" id="amount_in_words" name="amount_in_words" readonly/>
              </div>
            </div>

            <div class="col-md-6">
                <div class="form-group bd-t-0-force">
                    <label class="form-control-label">Bank Name:</label>
                    <input class="form-control" type="text" name="bank_name" placeholder="Enter Bank Name">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group bd-t-0-force mg-md-l--1">
                    <label class="form-control-label">Cheque No:</label>
                    <input class="form-control" type="text" name="cheque_no" placeholder="Enter Cheque Number">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group bd-t-0-force mg-md-l--1">
                    <label class="form-control-label">Cheque Date:</label>
                    <input class="form-control" type="text" id="cheque_date" name="cheque_date" placeholder="Enter Cheque Date" autocomplete="off">
                </div>
            </div>

          </div>

          <div class="form-layout-footer bd pd-20 bd-t-0">
            <input type="hidden" name="customer_address" value="{{$data['customer_address']}}"/>
            <input type="submit" value="Submit" class="btn btn-info pointer"/>
          </div>

        </div>
      </div>
    </div>
  </form>

  <script>

    var value = "{{$data['TotalAmt']}}"

    function setAmount() {
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

              //COMMA SEPARATE START
              var croreFormat = mainPart.toString();
              var lastThree = croreFormat.substring(croreFormat.length-3);
              var otherNumbers = croreFormat.substring(0,croreFormat.length-3);
              if(otherNumbers != '')
                  lastThree = ',' + lastThree;
              croreFormat = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
              croreFormat = croreFormat + '.' + decimalPart
              
              $('#realAmount').val(croreFormat);
              // COMMA SEPARATE END

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

            //COMMA SEPARATE START
            var millionFormat = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            
            $('#realAmount').val(millionFormat);
            //COMMA SEPARATE END

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

        $('#amount_in_words').val(fullString);

      }else{
        $('#realAmount').val('');
        $('#amount_in_words').val('');
      }
    }

    function datePickerAction() {
      $( "#cheque_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
    } 

    function setCurrency(value){
      var currency = value.split("_");
      $('#currency_full_name').val(currency[0])
      $('#currency_fraction_name').val(currency[1])
    }
  </script>
@endsection
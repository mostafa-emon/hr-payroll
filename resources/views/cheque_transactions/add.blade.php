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
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>
  
  <form action="{{ url('cheque-transactions/add') }}" method="POST">
    {{ csrf_field() }}
  <div class="br-pagebody">
      <div class="row">
        @if($layout != "")
        <div class="col-md-9 mg-t-10 d-flex align-items-center justify-content-center bg-white">
          
          <div class="card pd-0 bd-0 pd-30 table-responsive">
            <div id="printArea">
              <div id="containment-wrapper" style="height: {{$layout->height}}mm; width: {{$layout->width}}mm; position: relative">
                <div id="acpay" class="draggable ui-widget-content" style="position: absolute;top:{{$layout->ac_payee_only_top}}mm;left:{{$layout->ac_payee_only_left}}mm;@if($layout->ac_payee_only == 0) display:none; @endif"><img src="{{ asset('img/acpay.png') }}"/></div>
                <div id="date" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->date_top}}mm; left: {{$layout->date_left}}mm; letter-spacing: {{$layout->date_letter_spacing}}px; font-family: Courier; font-size: {{$layout->date_font_size}}px; color: black; @if($layout->date == 0) display:none; @endif">@if($layout->date_format == "DDMMYYYY")DDMMYYYY @else MMDDYYYY @endif</div>
                <div id="payee" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->payee_top}}mm; left: {{$layout->payee_left}}mm; letter-spacing: {{$layout->payee_letter_spacing}}px; font-family: Arial; font-size: {{$layout->payee_font_size}}px; color: black; @if($layout->payee == 0) display:none; @endif">Payee</div>
                <div id="amount" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->amount_top}}mm; left: {{$layout->amount_left}}mm; letter-spacing: {{$layout->amount_letter_spacing}}px; font-family: Arial; font-size: {{$layout->amount_font_size}}px; color: black; @if($layout->amount == 0) display:none; @endif">Amount</div>
                <div id="amount_in_word_line_1" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->amount_in_word_line_1_top}}mm; left: {{$layout->amount_in_word_line_1_left}}mm; letter-spacing: {{$layout->amount_in_word_letter_spacing}}px; font-family: Arial; font-size: {{$layout->amount_in_word_font_size}}px; color: black; @if($layout->amount_in_word_line_1 == 0) display:none; @endif">Amount in words line #1</div>
                <div id="amount_in_word_line_2" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->amount_in_word_line_2_top}}mm; left: {{$layout->amount_in_word_line_2_left}}mm; letter-spacing: {{$layout->amount_in_word_letter_spacing}}px; font-family: Arial; font-size: {{$layout->amount_in_word_font_size}}px; color: black; @if($layout->amount_in_word_line_2 == 0) display:none; @endif">Amount in words line #2</div>
              </div>
            </div>
          </div>
        </div>
        @endif

        <div class="col-md-3 mg-t-10">
          <div class="card bd-0 shadow-base pd-30">
            {{--
            @if($layout !="")
            <div class="row pd-b-20">
              <div class="col-md-6">
                <select class="form-control" id="printer">
                  @foreach($printers as $printer)
                    <option value="{{$printer->top}}_{{$printer->left}}_{{$printer->rotate}}">{{$printer->print_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <div class="pd-b-10">
                  <a class="btn btn-info btn-block pointer text-white" onclick="PrintElem()">Print Preview</a>
                </div>
              </div>
            </div>
            @endif
            --}}
            
            @if($bank_id != null && $bank_id != "" && $layout == "")
            <div class="alert alert-primary pd-10 mg-b-10" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              No layout found!
            </div>
            @endif
            <div>
              <select class="form-control" name="bank_name" onchange="bank_onchage(this.value)" required>
                <option disabled selected value="">Select Bank</option>
                @foreach($banks as $bank)
                  <option value="{{$bank->id}}" @if($bank_id == $bank->id) selected @endif>{{$bank->name}}</option>
                @endforeach
              </select>
            </div>

            @if($layout != "")
            <div class="pd-t-10">
              <select class="form-control" name="ac_number" onchange="get_cheque_books(this.value)" required>
                <option disabled selected value="">Select Account</option>
                @foreach($accounts as $account)
                  <option value="{{$account->id}}">{{$account->ac_number}}</option>
                @endforeach
              </select>
            </div>

            <div class="pd-t-10">
              <select id="cheque_books" name="book_no" class="form-control" onchange="get_cheques(this.value)" required>
                <option selected disabled>Select Book</option>
              </select>
            </div>

            <div class="pd-t-10">
              <select id="cheques" id="cheque_no" name="cheque_no" class="form-control" required>
                <option selected disabled>Select Cheque</option>
              </select>
            </div>

            <div class="pd-t-10">
              <select class="form-control" name="cheque_name" onchange="setChequeName(this.value)" required>
                <option disabled selected value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                  <option value="{{$supplier->cheque_name}}">{{$supplier->name}}</option>
                @endforeach
              </select>
            </div>
            
            <div class="pd-t-10">
              <input type="text" id="chooseDate" class="form-control" name="date_field" onchange="setChequeDate(this.value)" placeholder="date" required autocomplete="off"/>
            </div>

            <div class="pd-t-10">
              <input type="number" class="form-control" name="amount" oninput="setChequeAmount(this.value)" placeholder="amount" required/>
              <input type="hidden" id="amount_in_word_line_1_input" name="amount_in_word_line_1_input"/>
              <input type="hidden" id="amount_in_word_line_2_input" name="amount_in_word_line_2_input"/>
            </div>

            <div class="pd-t-15">
              <label class="ckbox pointer">
                <input type="checkbox" id="ac_pay_checkbox" onclick="hideShowElement('ac_pay')" name="ac_payee_only" value="1" checked><span>A/C Payee Only</span>
              </label>
            </div>

            <input type="hidden" id="currency_full_name" value="BDT"/>
            <input type="hidden" id="currency_fraction_name" value="Paisa"/>

            <div class="pd-t-15">
              <input type="submit" value="Create Cheque" class="pd-15 btn btn-success btn-block pointer"/>
            </div>
            @endif
          </div>
        </div>
        
      </div>
  </div>
  </form>
  
  <script>
    function bank_onchage(bank_id) {
      window.location = '/cheque-transactions/add/'+bank_id;
    }

    @if($layout != "")
    function hideShowElement(value) {
      if ($('#ac_pay_checkbox').is(':checked')) {
        $('#acpay').show();
      }else{
        $('#acpay').hide();
      }
    }

    /*
    function PrintElem(){
        var printer     = $('#printer').val();
        var printConf   = printer.split("_");
        
        var mywindow = window.open('', 'PRINT');
        mywindow.document.write('<style>#containment-wrapper{margin-left:'+printConf[1]+';margin-top:'+printConf[0]+'; transform: rotate('+printConf[2]+'deg)}</style>');
        mywindow.document.write(document.getElementById('printArea').innerHTML);

        setTimeout(function () {
            mywindow.focus();
            mywindow.print();
            mywindow.close();
        }, 500);

        return true;
    }
    */

    function get_cheque_books(account_id) {
      $.ajax({
          type: 'GET',
          url: '/get-cheque-book-by-account/'+account_id,
          success:function(data) {
            $('#cheque_books').html('');
            $('#cheque_books').append('<option value="" disabled selected>Select Book</option>');
            $('#cheque_books').append(data);
          }
      });

      $.ajax({
          type: 'GET',
          url: '/get-account-currency/'+account_id,
          success:function(data) {
            var currency = JSON.parse(data);
            $('#currency_full_name').val(currency.full_name);
            $('#currency_fraction_name').val(currency.fraction_name);
          }
      });

      var date_formatting = '{{$layout->date_format}}'
      if(date_formatting == "DDMMYYYY") {
        $( "#chooseDate" ).datepicker({ dateFormat: 'dd-mm-yy' });
      }else if(date_formatting == "MMDDYYYY") {
        $( "#chooseDate" ).datepicker();
      }
    }

    function get_cheques(book_id) {
      $.ajax({
          type: 'GET',
          url: '/get-cheques-by-book/'+book_id,
          success:function(data) {
            $('#cheques').html('');
            $('#cheques').append('<option value="" disabled selected>Select Cheque</option>');
            $('#cheques').append(data);
          }
      });
    }
    
    function setChequeName(name) {
      $('#payee').text(name);
    }

    function setChequeDate(date) {
      var formatted = date.replace(/[^0-9 ]/g, "")
      $('#date').text(formatted);
    }

    function setChequeAmount(value) {
      if(value != ''){ 
        var makeDecimal  = (Math.round(value * 100) / 100).toFixed(2);
        var splitDecimal = makeDecimal.split(".");
        var mainPart     = splitDecimal[0];
        var decimalPart  = splitDecimal[1];
        
        var amount = mainPart

        var amount_in_word_format = '{{ $setting->amount_in_word_format }}';
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
              $('#amount').text(croreFormat);
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
            $('#amount').text(millionFormat);
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
          decimalString = ' and ' + $('#currency_fraction_name').val() + ' ' + decimalString;
        }

        var fullString = words_string + decimalString + ' Only'
        if(fullString.length > '{{ $layout->amount_in_word_max_character }}') {
          var first_line = fullString.substring(0,'{{ $layout->amount_in_word_max_character }}');
          var lastIndex = first_line.lastIndexOf(" ");
          var first = first_line.replace(/ [^ ]+$/, "");
          var second_line = fullString.substring(lastIndex);
        }
        else{
          var first  = fullString
          var second_line = '' 
        }

        $('#amount_in_word_line_1').text(first);
        $('#amount_in_word_line_2').text(second_line);
        
        $('#amount_in_word_line_1_input').val(first);
        $('#amount_in_word_line_2_input').val(second_line);

      }else{
        $('#amount').text('Amount');
        $('#amount_in_word_line_1').text('Amount in words line #1');
        $('#amount_in_word_line_2').text('Amount in words line #2');
      }
    }
    @endif
  </script>
@endsection
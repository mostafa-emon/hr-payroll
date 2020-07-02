@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
        <a class="breadcrumb-item" href="{{ url('mr') }}">Report</a>
        <span class="breadcrumb-item active">Void Cheque</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Void Cheques</h4>
    </div>
  </div>

  <div class="br-pagebody pd-t-15">
    <div class="br-section-wrapper">

        <form action="{{ url('void-cheque') }}" method="POST">
            {{ csrf_field() }}
        <div class="row mg-b-30 b">
            <div class="col-md-2">
                <label class="tx-black tx-13">Bank</label>
                <select class="form-control" name="bank_id" onchange="get_accounts(this.value)">
                <option value="All" @if($bank_name == "All") selected @endif>All</option>
                @foreach($banks as $bk)
                    <option value="{{$bk->id}}" @if($bank_name == $bk->name) selected @endif>{{$bk->name}}</option>
                @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="tx-black tx-13">Accounts</label>
                <select id="account_id" name="account_id" onchange="get_cheque_books(this.value)" class="form-control mg-l--4">
                  <option value="All" @if($ac_number == "All") selected @endif>All</option>
                  @if($accounts != "")
                    @foreach($accounts as $ac)
                      <option value="{{$ac->id}}" @if($ac_number == $ac->ac_number) selected @endif>{{$ac->ac_number}}</option>
                    @endforeach
                  @endif
                </select>
            </div>

            <div class="col-md-2">
              <label class="tx-black tx-13">Cheque Books</label>
              <select id="cheque_books" name="book_no" class="form-control" required>
                <option value="All" @if($cheque_book == "All") selected @endif>All</option>
                @if($cheque_books != "")
                  @foreach($cheque_books as $cb)
                    <option value="{{$cb->book_no}}" @if($cheque_book == $cb->book_no) selected @endif>{{$cb->book_no}}</option>
                  @endforeach
                @endif
              </select>
            </div>

            <div class="col-md-2">
                <label class="tx-black tx-13">From Date</label>
                <input type="text" id="dtpick1" name="from_date" value="{{$from_date}}" class="form-control" autocomplete="off"/>
            </div>

            <div class="col-md-2">
                <label class="tx-black tx-13">To Date</label>
                <input type="text" id="dtpick2" name="to_date" value="{{$to_date}}" class="form-control" autocomplete="off"/>
            </div>

            <div class="col-md-2">
              <label class="tx-black tx-13">Payee Name</label>
              <input type="text" name="cheque_name" value="{{$cheque_name}}" class="form-control"/>
            </div>
  
            <div class="col-md-2">
              <label class="tx-black tx-13">Amount</label>
              <input type="text" name="amount" value="{{$formatted_amount}}" oninput="setChequeAmount(this.value)" class="form-control"/>
              <input type="hidden" id="realAmount" name="formatted_amount" value="{{$formatted_amount}}" class="form-control"/>
            </div>

            <div class="col-md-2" style="margin-top:27px">
                <input type="submit" class="btn btn-primary pointer" value="Search"/>
            </div>
        
        </div>
        </form>

        <div class="text-right mg-b-15">
          <a class="btn btn-info btn-sm pointer" id="excelButton" href="">Excel</a>
          <a class="btn btn-success btn-sm pointer" onclick="printElem()" href="javascript:void(0)">Print</a>
        </div>
  
        <style>
          table {
            border-collapse: collapse;
          }
          th, td {
            border: 1px solid black;
            font-family:arial;
            font-size:13px;
            padding:5px;
          }
          .no-border{border:none;}
        </style>
        
        <div id="printArea" class="table-responsive" style="color:black; margin-top:-20px;">
          <div class="div-padding-30">
            @include('reports.exports.void_cheque_table',$cheques)
          </div>
        </div>
    </div>
  </div>

  <script>
    var amount_in_word_format = '{{ $setting->amount_in_word_format }}';
    var removeUnwanted = '{{$total}}'.replace(/[^0-9.]/g, "")
    var makeDecimal  = (Math.round(removeUnwanted * 100) / 100).toFixed(2);
    var splitDecimal = makeDecimal.split(".");
    var mainPart     = splitDecimal[0];
    var decimalPart  = splitDecimal[1];

    if(amount_in_word_format == 'crore_lakh_thousand' || amount_in_word_format == 'crore_lac_thousand') {
      var croreFormat = mainPart.toString();
      var lastThree = croreFormat.substring(croreFormat.length-3);
      var otherNumbers = croreFormat.substring(0,croreFormat.length-3);
      if(otherNumbers != '')
          lastThree = ',' + lastThree;
      croreFormat = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
      croreFormat = croreFormat + '.' + decimalPart
      document.getElementById("grandTotal").innerHTML = croreFormat;
      document.getElementById("excelButton").href="/export-void-cheque?bank_id={{$bank_name}}&account_id={{$ac_number}}&book_no={{$cheque_book}}&from_date={{$from_date}}&to_date={{$to_date}}&total="+croreFormat; 
    }else{
      var millionFormat = '{{$total}}'.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      document.getElementById("grandTotal").innerHTML = millionFormat;
      document.getElementById("excelButton").href="/export-void-cheque?bank_id={{$bank_name}}&account_id={{$ac_number}}&book_no={{$cheque_book}}&from_date={{$from_date}}&to_date={{$to_date}}&total="+millionFormat; 
    }

    function printElem(){
      var mywindow = window.open('', 'PRINT');
      mywindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid black;font-family:arial;font-size:13px;padding:7px;} .no-border{border:none;}</style>');
      mywindow.document.write(document.getElementById('printArea').innerHTML);

      setTimeout(function () {
          mywindow.focus();
          mywindow.print();
          mywindow.close();

          //window.location = "/mr"
      }, 1000);
    }

    function get_accounts(bank_id) {
      $.ajax({
          type: 'GET',
          url: '/get-account-by-bank/'+bank_id,
          success:function(data) {
            $('#account_id').html('');
            $('#account_id').append('<option value="All" @if($ac_number == "All") selected @endif>All</option>');
            $('#account_id').append(data);
          }
      });
    }

    function get_cheque_books(account_id) {
      $.ajax({
          type: 'GET',
          url: '/get-cheque-book-by-account/'+account_id,
          success:function(data) {
            $('#cheque_books').html('');
            $('#cheque_books').append('<option value="All" @if($ac_number == "All") selected @endif>All</option>');
            $('#cheque_books').append(data);
          }
      });
    }

    function setChequeAmount(value) {
      if(value != ''){ 

        var removeUnwanted = value.replace(/[^0-9.]/g, "")

        var makeDecimal  = (Math.round(removeUnwanted * 100) / 100).toFixed(2);
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
            $('#amount').text(millionFormat);
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
          decimalString = ' and ' + $('#currency_fraction_name').val() + ' ' + decimalString;
        }

        var fullString = words_string + decimalString + ' Only'
        if(fullString.length > '100') {
          var first_line = fullString.substring(0,'100');
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
        $('#realAmount').val('');
        $('#amount_in_word_line_1').text('Amount in words line #1');
        $('#amount_in_word_line_2').text('Amount in words line #2');
      }
    }
  </script>

@endsection
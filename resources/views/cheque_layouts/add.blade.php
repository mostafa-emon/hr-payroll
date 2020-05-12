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
    #acpay{ cursor: move; }
    #date{ cursor: move; }
    #payee{ cursor: move; }
    #amount{ cursor: move; }
    #amount_in_word_line_1{ cursor: move; }
    #amount_in_word_line_2{ cursor: move; }

    #date_sizes {display:none;}
    #date_list:hover #date_sizes {display:block;}

    #amount_sizes {display:none;}
    #amount_list:hover #amount_sizes {display:block;}

    #payee_sizes {display:none;}
    #payee_list:hover #payee_sizes {display:block;}

    #amount_word_sizes {display:none;}
    #amount_word_list:hover #amount_word_sizes {display:block;}
  </style>

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/cheque-layouts') }}">Cheque Format</a>
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <form action="{{ url('cheque-layouts/add') }}" method="POST">
    {{ csrf_field() }}
  <div class="br-pagebody">
      <div class="row">

        <div class="col-md-9 mg-t-10 d-flex align-items-center justify-content-center bg-white">
          
          <div class="card pd-0 bd-0 pd-30 table-responsive">
            <div id="display" class="tx-black pd-b-5 collapse">Top: <input type="text" id="top" class="wd-40"/> &nbsp;Left: <input type="text" id="left" class="wd-40"/></div>

            <div id="printArea">
              <div id="containment-wrapper" style="height: 89mm; width: 191mm; position: relative">
                <div id="acpay" onclick="acpayDrag();" class="draggable ui-widget-content" style="position: absolute;top:0mm;left:0mm"><img src="{{ asset('img/acpay.png') }}"/></div>
                <div id="date" onclick="dateDrag()" class="draggable ui-widget-content" style="position: absolute; top: 7mm; left: 139mm; letter-spacing: 12px; font-family: Courier; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 10px; border-right: 7px solid red;">DDMMYYYY</div>
                <div id="payee" onclick="payeeDrag()" class="draggable ui-widget-content" style="position: absolute; top: 22mm; left: 15mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Payee</div>
                <div id="amount" onclick="amountDrag()" class="draggable ui-widget-content" style="position: absolute; top: 38mm; left: 154mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 50px; border-right: 7px solid red;">Amount</div>
                <div id="amount_in_word_line_1" onclick="amountWord1Drag()" class="draggable ui-widget-content" style="position: absolute; top: 31mm; left: 30mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 50px; border-right: 7px solid red;">Amount in words line #1</div>
                <div id="amount_in_word_line_2" onclick="amountWord2Drag()" class="draggable ui-widget-content" style="position: absolute; top: 40mm; left: 8mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 50px; border-right: 7px solid red;">Amount in words line #2</div>
              </div>
            </div>

            <div class="tx-teal pd-t-20 tx-16">** Click on elements to activate, then drag to set the position.</div>
          </div>
        </div>
        
        <div class="col-md-3 mg-t-10">
          <div class="card bd-0 shadow-base pd-30">

            <div>
              <select class="form-control" id="printer" name="printer_setup">
                @foreach($printers as $printer)
                  <option value="{{$printer->top}}_{{$printer->left}}_{{$printer->rotate}}">{{$printer->print_name}}</option>
                @endforeach
              </select>
            </div>

            <div class="pd-t-10 pd-b-10 text-right">
                <a class="btn btn-info pointer text-white" onclick="PrintElem()">Print Preview</a>
            </div>

            <div>
              <div class="tx-black pd-b-5">Height (mm): <input type="text" class="form-control" name="height" oninput="divHeight(this.value)" value="89"/></div>
            </div>

            <div class="pd-t-5 pd-b-20">
              <div class="tx-black pd-b-5">Width(mm): <input type="text" class="form-control" name="width" oninput="divWidth(this.value)" value="191"/></div>
            </div>

            <ul class="list-group">
              <li class="list-group-item" id="date_list">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('date')" id="date_checkbox" name="date" value="1" checked><span>Date</span>
                </label>
                <input type="hidden" id="date_top" name="date_top" value="7" placeholder="top" class="form-control"/>
                <input type="hidden" id="date_left" name="date_left" value="139" placeholder="left" class="form-control"/>
              
                <div id="date_sizes">
                  <div class="pd-t-10">
                    <label class="tx-black">Date Format:</label>
                    <select class="form-control" name="date_format" onchange="set_date_format(this.value)">
                      <option value="DDMMYYYY">DD-MM-YYYY</option>
                      <option value="MMDDYYYY">MM-DD-YYYY</option>
                    </select>
                  </div>
                  <div class="pd-t-10">
                    <label class="tx-black">Font Size: (px)</label>
                    <input type="text" oninput="dateFontSize(this.value)" name="date_font_size" value="16" placeholder="font size" class="form-control"/>
                  </div>
                  <div class="pd-t-10">
                    <label class="tx-black">Letter Spacing: (px)</label>
                    <input type="text" oninput="dateLetterSpacing(this.value)" name="date_letter_spacing" value="12" placeholder="letter spacing" class="form-control"/>
                  </div>
                </div>
              </li>
              <li class="list-group-item" id="payee_list">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('payee')" id="payee_checkbox" name="payee" value="1" checked><span>Payee</span>
                </label>
                <input type="hidden" id="payee_top" name="payee_top" value="22" placeholder="top" class="form-control"/>
                <input type="hidden" id="payee_left" name="payee_left" value="15" placeholder="left" class="form-control"/>
                
                <div id="payee_sizes">
                  <div class="pd-t-10">
                    <label class="tx-black">Font Size: (px)</label>
                    <input type="text" oninput="payeeFontSize(this.value)" name="payee_font_size" value="16" placeholder="font size" class="form-control"/>
                  </div>
                  <div class="pd-t-10">
                    <label class="tx-black">Letter Spacing: (px)</label>
                    <input type="text" oninput="payeeLetterSpacing(this.value)" name="payee_letter_spacing" value="0" placeholder="letter spacing" class="form-control"/>
                  </div>
                </div>
              </li>
              <li class="list-group-item" id="amount_list">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount')" id="amount_checkbox" name="amount" value="1" checked><span>Amount</span>
                </label>
                <input type="hidden" id="amount_top" name="amount_top" value="38" placeholder="top" class="form-control"/>
                <input type="hidden" id="amount_left" name="amount_left" value="154" placeholder="left" class="form-control"/>
                
                <div id="amount_sizes">
                  <div class="pd-t-10">
                    <label class="tx-black">Font Size: (px)</label>
                    <input type="text" oninput="amountFontSize(this.value)" name="amount_font_size" value="16" placeholder="font size" class="form-control"/>
                  </div>
                  <div class="pd-t-10">
                    <label class="tx-black">Letter Spacing: (px)</label>
                    <input type="text" oninput="amountLetterSpacing(this.value)" name="amount_letter_spacing" value="0" placeholder="letter spacing" class="form-control"/>
                  </div>
                </div>
              </li>
              <li class="list-group-item" id="amount_word_list">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount_word_1')" id="amount_word_1_checkbox" name="amount_in_word_line_1" value="1" checked><span>Amount in words line #1</span>
                  <input type="hidden" id="amount_in_word_line_1_top" value="31" name="amount_in_word_line_1_top" placeholder="top" class="form-control"/>
                  <input type="hidden" id="amount_in_word_line_1_left" value="30" name="amount_in_word_line_1_left" placeholder="left" class="form-control"/>
                </label>
                <input type="hidden" id="amount_in_word_line_1_top" value="31" name="amount_in_word_line_1_top" placeholder="top" class="form-control"/>
                <input type="hidden" id="amount_in_word_line_1_left" value="30" name="amount_in_word_line_1_left" placeholder="left" class="form-control"/>
                
                <div id="amount_word_sizes">
                  <div class="pd-t-10">
                    <label class="tx-black">Font Size: (px)</label>
                    <input type="text" oninput="amountWordFontSize(this.value)" name="amount_in_word_font_size" value="16" placeholder="font size" class="form-control"/>
                  </div>
                  <div class="pd-t-10">
                    <label class="tx-black">Letter Spacing: (px)</label>
                    <input type="text" oninput="amountWordSpacing(this.value)" name="amount_in_word_letter_spacing" value="0" placeholder="letter spacing" class="form-control"/>
                  </div>
                  <div class="pd-t-10">
                    <label class="tx-black">Max Character:</label>
                    <input type="text" name="amount_in_word_max_character" value="45" placeholder="line #1 max character" class="form-control"/>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount_word_2')" id="amount_word_2_checkbox" name="amount_in_word_line_2" value="1" checked><span>Amount in words line #2</span>
                </label>
                <input type="hidden" id="amount_in_word_line_2_top" value="40" name="amount_in_word_line_2_top" placeholder="top" class="form-control"/>
                <input type="hidden" id="amount_in_word_line_2_left" value="8" name="amount_in_word_line_2_left" placeholder="left" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('ac_pay')" id="ac_pay_checkbox" name="ac_payee_only" value="1" checked><span>AC Payee</span>
                </label>
                <input type="hidden" id="ac_payee_only_top" value="0" name="ac_payee_only_top" placeholder="top" class="form-control"/>
                <input type="hidden" id="ac_payee_only_left" value="0" name="ac_payee_only_left" placeholder="left" class="form-control"/>
              </li>
            </ul>

            <div class="pd-t-25">
              <select class="form-control" name="bank_id" required>
                <option disabled selected value="">Select Bank</option>
                @foreach($banks as $bank)
                  <option value="{{$bank->id}}">{{$bank->name}}</option>
                @endforeach
              </select>
            </div>

            <div class="pd-t-15">
              <input type="submit" value="Save Layout" class="pd-15 btn btn-success btn-block pointer"/>
            </div>

          </div>
        </div>
        
      </div>
  </div>
  </form>

  <script>
    function divHeight(height){
      document.getElementById("containment-wrapper").style.height = height+"mm";
    }

    function divWidth(width){
      document.getElementById("containment-wrapper").style.width = width+"mm";
    }

    function hideShowElement(value) {
      if(value == "date") {
        if ($('#date_checkbox').is(':checked')) {
          $('#date').show();
        }else{
          $('#date').hide();
        }
      }

      else if(value == "payee") {
        if ($('#payee_checkbox').is(':checked')) {
          $('#payee').show();
        }else{
          $('#payee').hide();
        }
      }

      else if(value == "amount") {
        if ($('#amount_checkbox').is(':checked')) {
          $('#amount').show();
        }else{
          $('#amount').hide();
        }
      }

      else if(value == "ac_pay") {
        if ($('#ac_pay_checkbox').is(':checked')) {
          $('#acpay').show();
        }else{
          $('#acpay').hide();
        }
      }

      else if(value == "amount_word_1") {
        if ($('#amount_word_1_checkbox').is(':checked')) {
          $('#amount_in_word_line_1').show();
        }else{
          $('#amount_in_word_line_1').hide();
        }
      }

      else if(value == "amount_word_2") {
        if ($('#amount_word_2_checkbox').is(':checked')) {
          $('#amount_in_word_line_2').show();
        }else{
          $('#amount_in_word_line_2').hide();
        }
      }
    }

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

    function acpayDrag(){
      var sAcpayPosition = "{}",
      acpayPositions = JSON.parse(sAcpayPosition);
      $.each(acpayPositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#acpay").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          acpayPositions[this.id] = ui.position
          document.getElementById('ac_payee_only_top').value = Math.round(acpayPositions.acpay.top * 0.2645833333);
          document.getElementById('ac_payee_only_left').value = Math.round(acpayPositions.acpay.left * 0.2645833333);

          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(acpayPositions.acpay.top * 0.2645833333);
          document.getElementById('left').value = Math.round(acpayPositions.acpay.left * 0.2645833333);
        }
      });
    }

    function dateDrag(){
      var sDatePosition = "{}",
      datePositions = JSON.parse(sDatePosition);
      $.each(datePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#date").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          datePositions[this.id] = ui.position
          document.getElementById('date_top').value = Math.round(datePositions.date.top * 0.2645833333);
          document.getElementById('date_left').value = Math.round(datePositions.date.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(datePositions.date.top * 0.2645833333);
          document.getElementById('left').value = Math.round(datePositions.date.left * 0.2645833333);
        }
      });
    }

    function payeeDrag(){
      var sPayeePosition = "{}",
      payeePositions = JSON.parse(sPayeePosition);
      $.each(payeePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#payee").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          payeePositions[this.id] = ui.position
          document.getElementById('payee_top').value = Math.round(payeePositions.payee.top * 0.2645833333);
          document.getElementById('payee_left').value = Math.round(payeePositions.payee.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(payeePositions.payee.top * 0.2645833333);
          document.getElementById('left').value = Math.round(payeePositions.payee.left * 0.2645833333); 
        }
      });
    }

    function amountDrag(){
      var sAmountPosition = "{}",
      amountPositions = JSON.parse(sAmountPosition);
      $.each(amountPositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#amount").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          amountPositions[this.id] = ui.position
          document.getElementById('amount_top').value = Math.round(amountPositions.amount.top * 0.2645833333);
          document.getElementById('amount_left').value = Math.round(amountPositions.amount.left * 0.2645833333);
        
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(amountPositions.amount.top * 0.2645833333);
          document.getElementById('left').value = Math.round(amountPositions.amount.left * 0.2645833333);
        }
      });
    }

    function amountWord1Drag(){
      var sAmountWord1Position = "{}",
      amountWord1Positions = JSON.parse(sAmountWord1Position);
      $.each(amountWord1Positions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#amount_in_word_line_1").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          amountWord1Positions[this.id] = ui.position
          document.getElementById('amount_in_word_line_1_top').value = Math.round(amountWord1Positions.amount_in_word_line_1.top * 0.2645833333);
          document.getElementById('amount_in_word_line_1_left').value = Math.round(amountWord1Positions.amount_in_word_line_1.left * 0.2645833333);

          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(amountWord1Positions.amount_in_word_line_1.top * 0.2645833333);
          document.getElementById('left').value = Math.round(amountWord1Positions.amount_in_word_line_1.left * 0.2645833333);
        }
      });
    }

    function amountWord2Drag(){
      var sAmountWord2Position = "{}",
      amountWord2Positions = JSON.parse(sAmountWord2Position);
      $.each(amountWord2Positions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#amount_in_word_line_2").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          amountWord2Positions[this.id] = ui.position
          document.getElementById('amount_in_word_line_2_top').value = Math.round(amountWord2Positions.amount_in_word_line_2.top * 0.2645833333);
          document.getElementById('amount_in_word_line_2_left').value = Math.round(amountWord2Positions.amount_in_word_line_2.left * 0.2645833333);

          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(amountWord2Positions.amount_in_word_line_2.top * 0.2645833333);
          document.getElementById('left').value = Math.round(amountWord2Positions.amount_in_word_line_2.left * 0.2645833333);
        }
      });
    }
    
    function amountFontSize(value){
      document.getElementById("amount").style.fontSize  = value+'px';
    }

    function amountLetterSpacing(value){
      document.getElementById("amount").style.letterSpacing = value+'px';
    }

    function payeeFontSize(value){
      document.getElementById("payee").style.fontSize  = value+'px';
    }

    function payeeLetterSpacing(value){
      document.getElementById("payee").style.letterSpacing = value+'px';
    }

    function dateFontSize(value){
      document.getElementById("date").style.fontSize  = value+'px';
    }

    function dateLetterSpacing(value){
      document.getElementById("date").style.letterSpacing = value+'px';
    }

    function amountWordFontSize(value){
      document.getElementById("amount_in_word_line_1").style.fontSize  = value+'px';
      document.getElementById("amount_in_word_line_2").style.fontSize  = value+'px';
    }

    function amountWordSpacing(value){
      document.getElementById("amount_in_word_line_1").style.letterSpacing  = value+'px';
      document.getElementById("amount_in_word_line_2").style.letterSpacing  = value+'px';
    }

    function set_date_format(value){
      document.getElementById("date").innerHTML  = value;
    }
  </script>
@endsection
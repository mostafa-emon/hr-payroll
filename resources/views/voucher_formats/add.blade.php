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
    #qblogo{ cursor: move; }
    #voucher_no{ cursor: move; }
    #voucher_date{ cursor: move; }
    #payee_name{ cursor: move; }
    #cheque_name{ cursor: move; }
    #cheque_date{ cursor: move; }
    #received_from{ cursor: move; }
    #amount{ cursor: move; }
    #amount_in_word_line_1{ cursor: move; }
    #amount_in_word_line_2{ cursor: move; }
  </style>

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/voucher-formats') }}">Voucher Formats</a>
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <form action="{{ url('voucher-formats/add') }}" method="POST">
    {{ csrf_field() }}
    @php if($settings->voucher_size == "half_page"){ $page_height = 149; } else{ $page_height = 297; } @endphp
    
    <input type="hidden" class="form-control" name="type" value="{{$type}}"/>
  
  <div class="br-pagebody">
      <div class="row">

        <div class="col-md-9 mg-t-10 d-flex align-items-center justify-content-center bg-white">
          
          <div class="card pd-0 bd-0 pd-30 table-responsive">
            <div id="display" class="tx-black pd-b-5 collapse">Top: <input type="text" id="top" class="wd-40"/> &nbsp;Left: <input type="text" id="left" class="wd-40"/></div>

            <div id="printArea">
              <div id="containment-wrapper" style="height: {{$page_height}}mm; width: 210mm; position: relative">
                <div style="margin-top:3mm;text-align:center;color:black;font-size:13px;font-weight:bold">
                  <div style="font-size: 16px;">{{$company->name}}</div>
                  <div style="width:70mm;margin-left:70mm;">{{$company->address}}</div>
                  <div style="margin-top:8px">{{ str_replace("-", " ", $type) }}</div>
                </div>
                <div id="qblogo" onclick="qbLogoDrag();" class="draggable ui-widget-content" style="position: absolute;top:3.5mm;right:10mm"><img src="{{ asset('img/qblogo.png') }}" height="35"/></div>
                <div id="voucher_no" onclick="voucherNoDrag()" class="draggable ui-widget-content" style="position: absolute; top: 10mm; left: 139mm; font-family: arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 10px; border-right: 7px solid red;">Voucher No:</div>
                <div id="voucher_date" onclick="voucherDateDrag()" class="draggable ui-widget-content" style="position: absolute; top: 7mm; left: 139mm; font-family: arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 10px; border-right: 7px solid red;">Voucher Date: </div>
                <div id="payee_name" onclick="payeeNameDrag()" class="draggable ui-widget-content" style="position: absolute; top: 25mm; left: 15mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Payee Name</div>
                <div id="cheque_name" onclick="chequeNameDrag()" class="draggable ui-widget-content" style="position: absolute; top: 28mm; left: 15mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Cheque name</div>
                <div id="cheque_date" onclick="chequeDateDrag()" class="draggable ui-widget-content" style="position: absolute; top: 34mm; left: 15mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Cheque Date</div>
                <div id="received_from" onclick="receivedFromDrag()" class="draggable ui-widget-content" style="position: absolute; top: 40mm; left: 15mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Received From</div>
                
                <div id="amount" onclick="amountDrag()" class="draggable ui-widget-content" style="position: absolute; top: 50mm; left: 154mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 50px; border-right: 7px solid red;">Amount</div>
                <div id="amount_in_word_line_1" onclick="amountWord1Drag()" class="draggable ui-widget-content" style="position: absolute; top: 60mm; left: 30mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 50px; border-right: 7px solid red;">Amount in words line #1</div>
                <div id="amount_in_word_line_2" onclick="amountWord2Drag()" class="draggable ui-widget-content" style="position: absolute; top: 70mm; left: 8mm; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 50px; border-right: 7px solid red;">Amount in words line #2</div>
              </div>
            </div>

            <div class="tx-teal pd-t-20 tx-16">** Click on elements to activate, then drag to set the position.</div>
          </div>
        </div>
        
        <div class="col-md-3 mg-t-10">
          <div class="card bd-0 shadow-base pd-30">

            <div class="pd-t-10 pd-b-10 text-right">
                <a class="btn btn-info pointer text-white" onclick="PrintElem()">Print Preview</a>
            </div>

            <div>
              <div class="tx-black pd-b-5">Title: <input type="text" class="form-control" name="title"/></div>
            </div>

            <ul class="list-group">
              <li class="list-group-item" id="date_list">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('date')" id="date_checkbox" name="date" value="1" checked><span>Date</span>
                </label>
                <input type="hidden" id="date_top" name="date_top" value="7" placeholder="top" class="form-control"/>
                <input type="hidden" id="date_left" name="date_left" value="139" placeholder="left" class="form-control"/>
              </li>
              <li class="list-group-item" id="payee_list">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('payee')" id="payee_checkbox" name="payee" value="1" checked><span>Payee</span>
                </label>
                <input type="hidden" id="payee_top" name="payee_top" value="22" placeholder="top" class="form-control"/>
                <input type="hidden" id="payee_left" name="payee_left" value="15" placeholder="left" class="form-control"/>
              </li>
              <li class="list-group-item" id="amount_list">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount')" id="amount_checkbox" name="amount" value="1" checked><span>Amount</span>
                </label>
                <input type="hidden" id="amount_top" name="amount_top" value="38" placeholder="top" class="form-control"/>
                <input type="hidden" id="amount_left" name="amount_left" value="154" placeholder="left" class="form-control"/>
              </li>
              <li class="list-group-item" id="amount_word_list">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount_word_1')" id="amount_word_1_checkbox" name="amount_in_word_line_1" value="1" checked><span>Amount in words line #1</span>
                  <input type="hidden" id="amount_in_word_line_1_top" value="31" name="amount_in_word_line_1_top" placeholder="top" class="form-control"/>
                  <input type="hidden" id="amount_in_word_line_1_left" value="30" name="amount_in_word_line_1_left" placeholder="left" class="form-control"/>
                </label>
                <input type="hidden" id="amount_in_word_line_1_top" value="31" name="amount_in_word_line_1_top" placeholder="top" class="form-control"/>
                <input type="hidden" id="amount_in_word_line_1_left" value="30" name="amount_in_word_line_1_left" placeholder="left" class="form-control"/>
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

            <div class="pd-t-15">
              <input type="submit" value="Save Layout" class="pd-15 btn btn-success btn-block pointer"/>
            </div>

          </div>
        </div>
        
      </div>
  </div>
  </form>

  <script>
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

    function qbLogoDrag(){
      var sQBLogoPosition = "{}",
      qbLogoPositions = JSON.parse(sQBLogoPosition);
      $.each(qbLogoPositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#qblogo").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          qbLogoPositions[this.id] = ui.position
          document.getElementById('ac_payee_only_top').value = Math.round(qbLogoPositions.qblogo.top * 0.2645833333);
          document.getElementById('ac_payee_only_left').value = Math.round(qbLogoPositions.qblogo.left * 0.2645833333);

          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(qbLogoPositions.qblogo.top * 0.2645833333);
          document.getElementById('left').value = Math.round(qbLogoPositions.qblogo.left * 0.2645833333);
        }
      });
    }

    function voucherNoDrag(){
      var sVoucherNo = "{}",
      voucherNo = JSON.parse(sVoucherNo);
      $.each(voucherNo, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#voucher_no").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          voucherNo[this.id] = ui.position
          document.getElementById('date_top').value = Math.round(voucherNo.voucher_no.top * 0.2645833333);
          document.getElementById('date_left').value = Math.round(voucherNo.voucher_no.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(voucherNo.voucher_no.top * 0.2645833333);
          document.getElementById('left').value = Math.round(voucherNo.voucher_no.left * 0.2645833333);
        }
      });
    }

    function voucherDateDrag(){
      var sVoucherDate = "{}",
      voucherDate = JSON.parse(sVoucherDate);
      $.each(voucherDate, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#voucher_date").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          voucherDate[this.id] = ui.position
          document.getElementById('date_top').value = Math.round(voucherDate.voucher_date.top * 0.2645833333);
          document.getElementById('date_left').value = Math.round(voucherDate.voucher_date.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(voucherDate.voucher_date.top * 0.2645833333);
          document.getElementById('left').value = Math.round(voucherDate.voucher_date.left * 0.2645833333);
        }
      });
    }

    function payeeNameDrag(){
      var sPayeeNamePosition = "{}",
      payeeNamePositions = JSON.parse(sPayeeNamePosition);
      $.each(payeeNamePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#payee_name").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          payeeNamePositions[this.id] = ui.position
          document.getElementById('payee_top').value = Math.round(payeeNamePositions.payee_name.top * 0.2645833333);
          document.getElementById('payee_left').value = Math.round(payeeNamePositions.payee_name.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(payeeNamePositions.payee_name.top * 0.2645833333);
          document.getElementById('left').value = Math.round(payeeNamePositions.payee_name.left * 0.2645833333); 
        }
      });
    }

    function chequeNameDrag(){
      var sChequeNamePosition = "{}",
      chequeNamePositions = JSON.parse(sChequeNamePosition);
      $.each(chequeNamePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#cheque_name").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          chequeNamePositions[this.id] = ui.position
          document.getElementById('payee_top').value = Math.round(chequeNamePositions.cheque_name.top * 0.2645833333);
          document.getElementById('payee_left').value = Math.round(chequeNamePositions.cheque_name.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(chequeNamePositions.cheque_name.top * 0.2645833333);
          document.getElementById('left').value = Math.round(chequeNamePositions.cheque_name.left * 0.2645833333); 
        }
      });
    }

    function chequeDateDrag(){
      var sChequeDatePosition = "{}",
      chequeDatePositions = JSON.parse(sChequeDatePosition);
      $.each(chequeDatePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#cheque_date").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          chequeDatePositions[this.id] = ui.position
          document.getElementById('payee_top').value = Math.round(chequeDatePositions.cheque_date.top * 0.2645833333);
          document.getElementById('payee_left').value = Math.round(chequeDatePositions.cheque_date.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(chequeDatePositions.cheque_date.top * 0.2645833333);
          document.getElementById('left').value = Math.round(chequeDatePositions.cheque_date.left * 0.2645833333); 
        }
      });
    }

    function receivedFromDrag(){
      var sReceivedFromPosition = "{}",
      receivedFromPositions = JSON.parse(sReceivedFromPosition);
      $.each(receivedFromPositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#received_from").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          receivedFromPositions[this.id] = ui.position
          document.getElementById('payee_top').value = Math.round(receivedFromPositions.received_from.top * 0.2645833333);
          document.getElementById('payee_left').value = Math.round(receivedFromPositions.received_from.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(receivedFromPositions.received_from.top * 0.2645833333);
          document.getElementById('left').value = Math.round(receivedFromPositions.received_from.left * 0.2645833333); 
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
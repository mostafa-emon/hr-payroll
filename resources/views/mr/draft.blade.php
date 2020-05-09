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
        <div style="font-family: Arial; padding:30px">
            <div style="float: left;">
              <h1 style="font-size: 20px; font-weight: bold;">Business Data Automation</h1>
              <div>Ta-115 Gulshan Badda Link Road,</div>
              <div>Phone: +8801828123466, Email: sales@quickbooksbd.com</div>
              <div>Website: www.quickbooksbd.com</div>
            </div>
        
            <div style="float: right; height:58px;margin-top: 10px;">
                <img src="{{asset('storage/'.$company->logo)}}" height="100"/>
            </div>
        
            <h3 style="text-align: center; font-size: 27px; font-weight: bold; padding-top: 150px;">Money Receipt</h3>
        
            <div style="font-weight: bold; font-size: 19px;">Received Form</div>
        
            <div style="border: 2px solid; width: 35%; height: auto; padding-bottom: 10px; padding-top: 10px; padding-left: 10px; padding-right: 5px;" >
              <div>Omicon Technologies Limited</div>
              <div>House # 76, Road # 3, Gulshan-3</div>
              <div>Dhaka-1212, Bangladesh.</div>
            </div>
        
            <div style="float: right; margin-top:-90px;  padding-bottom: 30px;">
              <div>
                <div style="font-weight: bold; padding-right: 145px;">Money Receipt No</div>
                <div style="float: right; border: 1px solid; height: 22px; width: 47%; margin-top: -24px; text-align: center; padding-top: 4px;">I
                </div>
              </div><br>
              <div>
                <div style="font-weight: bold; padding-right: 145px;">Money Receipt Date</div>
                <div style="float: right; border: 1px solid; height: 22px; width: 47%; margin-top: -24px; text-align: center; padding-top: 4px;">am
                </div>
              </div><br>
              <div>
                <div style="font-weight: bold; padding-right: 145px;">Payment Method</div>
                <div style="float: right; border: 1px solid; height: 22px; width: 47%; margin-top: -24px; text-align: center; padding-top: 4px;">Gadha
                </div>
              </div>
            </div>
            
            <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
              <thead>
                <tr>
                  <th style="text-align: center; border: 1px solid black;">Sl No</th>
                  <th style="text-align: center; border: 1px solid black;">Currency</th>
                  <th style="text-align: center; border: 1px solid black;">Cheque No</th>
                  <th style="text-align: center; border: 1px solid black;">Cheque Date</th>
                  <th style="text-align: center; border: 1px solid black;">Bank Name</th>
                  <th style="text-align: center; border: 1px solid black;">Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center; border: 1px solid black;">1</td>
                  <td style="text-align: center; border: 1px solid black;">{{$transaction->currency}}</td>
                  <td style="text-align: center; border: 1px solid black;">{{$transaction->cheque_no}}</td>
                  <td style="text-align: center; border: 1px solid black;">{{date('d-m-Y',strtotime($transaction->cheque_date))}}</td>
                  <td style="text-align: center; border: 1px solid black;">{{$transaction->bank_name}}</td>
                  <td style="text-align: center; border: 1px solid black;">{{$transaction->amount}}</td>
                </tr>
        
                <tr>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;">&nbsp;</td>
                </tr>
        
                <tr>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;">&nbsp;</td>
                </tr>
        
                <tr>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;">&nbsp;</td>
                </tr>
        
                <tr>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;">&nbsp;</td>
                </tr>
        
                <tr>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;">&nbsp;</td>
                </tr>
        
                <tr>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;">&nbsp;</td>
                </tr>
        
                <tr>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;">&nbsp;</td>
                </tr>
        
                <tr>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;">&nbsp;</td>
                </tr>
        
                <tr>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;"></td>
                  <td style="text-align: center; border: 1px solid black;">&nbsp;</td>
                </tr>
        
                <tr style="border: 1px solid black;">
                  <td style="text-align: center;"></td>
                  <td style="text-align: center;"></td>
                  <td style="text-align: center;"></td>
                  <td style="text-align: center;"></td>
                  <td style="text-align: right;">Total</td>
                  <td style="text-align: center; border: 1px solid black;">{{$transaction->amount}}</td>
                </tr>
              </tbody>
            </table>
        
            <div style="margin-top: 30px;">
              <div style="float: left;">Amount In Word
              </div>
              <div style="float: left; padding-left: 20px;">{{$transaction->amount_in_word}}
              </div>
              <br>
              <div style="float: left; padding-left: 138px; margin-top: -13px;">_________________________________________________________________
              </div>
            </div>
            <br>
        
            <div style="margin-top: 30px;">
              <div style="float: left;">Purpose
              </div>
              <div style="float: left; padding-left: 76px;">{{$transaction->purpose}}
              </div>
              <br>
              <div style="float: left; padding-left: 136px; margin-top: -13px;">_________________________________________________________________
              </div>
            </div>
            <br>
        
            <div style="margin-top: 70px; float: left; margin-bottom: 80px;">
              <div style="text-align: center;">
              </div>
              <br>
              <div style="margin-top: -32px;">__________________
              </div><br>
              <div style="margin-left: 35px; margin-top: -16px;">Received By
              </div>
            </div>
        
            <div style="margin-top: 70px; float: right; margin-bottom: 80px;">
              <div style="text-align: center;">
              </div>
              <br>
              <div style="margin-top: -32px;">______________________
              </div><br>
              <div style="margin-left: 45px; margin-top: -16px;">Authorized By
              </div>
            </div>
        </div>
    </div>
</div>

<script>
    var mywindow = window.open('', 'PRINT');
    mywindow.document.write(document.getElementById('printArea').innerHTML);

    setTimeout(function () {
        mywindow.focus();
        mywindow.print();
        mywindow.close();
    }, 500);

</script>
@endsection
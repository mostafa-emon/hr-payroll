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
        <div style="font-family: Arial, Helvetica, sans-serif;padding:30px;">
            <div style="float:left;">
                <div>Business Data Automation</div>																
                <div>Ta-115 Gulshan Badda Link Road,</div>																	
                <div>Middle Badda, Dhaka-1212, Bangladesh.</div>																	
                <div>Phone: +8801828123466, Email: sales@quickbooksbd.com</div>																
                <div>Website: www.quickbooksbd.com</div>
            </div>
            <div style="float:right;">
                <img src="{{asset('storage/logo/')}}"/>
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
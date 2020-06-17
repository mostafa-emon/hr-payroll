@extends('layouts.master')

@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
        <span class="breadcrumb-item active">Voucher Print</span>
    </nav>
</div>

<div class="br-pagebody">
    <div id="printArea">
        asdfasdf
    </div>
</div>

<script>
    var mywindow = window.open('', 'PRINT');
    
    mywindow.document.write(document.getElementById('printArea').innerHTML);

    setTimeout(function () {
        mywindow.focus();
        mywindow.print();
        mywindow.close();

        //window.location = ""
    }, 1000);

</script>
@endsection
<table style="width:100%;">
    <thead>
        
      <tr>
        <td colspan="7" class="no-border" style="text-align: center; font-size:17px; font-weight:bold;">{{ $company->name}}</td>
      </tr>
      <tr>
        <td colspan="7" class="no-border" style="text-align: center;font-size:15px; font-weight:bold;">Issued Vouchers</td>
      </tr>
      <tr>
        <td colspan="7" class="no-border" style="text-align: center;font-size:13px; font-weight:bold;">From {{ date('d-M-Y',strtotime($from_date)) }} to {{ date('d-M-Y',strtotime($to_date)) }}</td>
      </tr>
      <tr>
        <th style="text-align: center">Sl</th>
        <th>Voucher Type</th>
        <th style="text-align: left">TRX Date</th>
        <th style="text-align: left">QB REF NO.</th>
        <th style="text-align: left">Payee Name</th>
        <th style="text-align: left">Memo</th>
        <th style="text-align: left">Total Amount</th>
      </tr>
    </thead>
    <tbody>
      @php $total = 0; @endphp
      @foreach ($vouchers as $voucher)
      @php $total = $total + $voucher->total_credit; @endphp
      <tr>
        <td style="text-align: center">{{$loop->iteration}}</td>
        <td>{{ $voucher->type }}</td>
        <td> {{ $voucher->voucher_date }} </td>
        <td> {{ $voucher->reference_no }} </td>
        <td> {{ $voucher->payee_name }} </td>
        <td> {{ $voucher->memo }} </td>
        <td style="text-align: right"> {{ $voucher->total_credit }} </td>
      </tr>
      @endforeach

      <tr>
        <th colspan="6" style="text-align:right">Total</th>
        <th style="text-align:right" id="grandTotal">{{$total}}</th>
      </tr>
    </tbody>
  </table>
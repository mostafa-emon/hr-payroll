<table style="width:100%;">
    <thead>
        
      <tr>
        <td colspan="8" class="no-border" style="text-align: center; font-size:17px; font-weight:bold;">{{ $company->name}}</td>
      </tr>
      <tr>
        <td colspan="8" class="no-border" style="text-align: center;font-size:15px; font-weight:bold;">Issued Money Receipt</td>
      </tr>
      <tr>
        <td colspan="8" class="no-border" style="text-align: center;font-size:13px; font-weight:bold;">From {{ date('d-M-Y',strtotime($from_date)) }} to {{ date('d-M-Y',strtotime($to_date)) }}</td>
      </tr>
      <tr>
        <th style="text-align: center">Sl</th>
        <th style="text-align: center">Voucher Type</th>
        <th style="text-align: left">TRX Date</th>
        <th style="text-align: left">REF NO.</th>
        <th style="text-align: left">Payee Name</th>
        <th style="text-align: left">Memo</th>
        <th style="text-align: left">Total Amount</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($vouchers as $voucher)
      <tr>
        <td style="text-align: center">{{$loop->iteration}}</td>
        <td style="text-align: center">{{ $voucher->type }}</td>
        <td> {{ $voucher->voucher_date }} </td>
        <td> {{ $voucher->reference_no }} </td>
        <td> {{ $voucher->payee_name }} </td>
        <td> {{ $voucher->memo }} </td>
        <td> {{ $voucher->total_credit }} </td>
      </tr>
      @endforeach

      <tr>
        <th colspan="6" style="text-align:right">Total</th>
        <th style="text-align:right" id="grandTotal">{{--$total--}}</th>
      </tr>
    </tbody>
  </table>
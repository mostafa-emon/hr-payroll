<table style="width:100%;">
    <thead>
        
      <tr>
        <td colspan="6" class="no-border" style="text-align: center; font-size:17px; font-weight:bold;">{{ $company->name}}</td>
      </tr>
      <tr>
        <td colspan="6" class="no-border" style="text-align: center;font-size:15px; font-weight:bold;">Void Money Receipt</td>
      </tr>
      <tr>
        <td colspan="6" class="no-border" style="text-align: center;font-size:13px; font-weight:bold;">From {{ date('d-M-Y',strtotime($from_date)) }} to {{ date('d-M-Y',strtotime($to_date)) }}</td>
      </tr>
      <tr>
        <th style="text-align: center">Sl</th>
        <th style="text-align: center">Date</th>
        <th style="text-align: center">MR Number</th>
        <th style="text-align: center">Customer</th>
        <th style="text-align: center">Pay Method</th>
        <th style="text-align: center">Amount</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($money_receipts as $mr)
      <tr>
        <td style="text-align: center">{{$loop->iteration}}</td>
        <td style="text-align: center">{{ date('d-m-Y', strtotime($mr->created_at))}}</td>
        <td>{{$mr->site_office_prefix}}{{$mr->invoice_no}}{{$mr->site_office_suffix}}</td>
        <td>{{$mr->customer_name}}</td>
        <td>{{$mr->payment_method}}</td>
        <td style="text-align: right">{{ $mr->amount }}</td>
      </tr>
      @endforeach

      <tr>
        <th colspan="5" style="text-align:right">Total</th>
        <th style="text-align:right" id="grandTotal">{{$total}}</th>
      </tr>
    </tbody>
  </table>
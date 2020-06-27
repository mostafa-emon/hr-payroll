<table style="width:100%;">
    <thead>
        
      <tr>
        <td colspan="11" class="no-border" style="text-align: center; font-size:17px; font-weight:bold;">{{ $company->name}}</td>
      </tr>
      <tr>
        <td colspan="11" class="no-border" style="text-align: center;font-size:15px; font-weight:bold;">Void Vouchers</td>
      </tr>
      <tr>
        <td colspan="11" class="no-border" style="text-align: center;font-size:13px; font-weight:bold;">From {{ date('d-M-Y',strtotime($from_date)) }} to {{ date('d-M-Y',strtotime($to_date)) }}</td>
      </tr>
      <tr>
        <th style="text-align: center">Sl</th>
        <th style="text-align: center">Voucher Type</th>
        <th style="text-align: center">Voucher Date</th>
        <th style="text-align: center">Voucher No</th>
        <th style="text-align: center">QB Option</th>
        <th style="text-align: center">QB REF NO.</th>
        <th style="text-align: center">Payee Name</th>
        <th style="text-align: center">Paid From</th>
        <th style="text-align: center">Deposit To</th>
        <th style="text-align: center">Memo</th>
        <th style="text-align: center">Total Amount</th>
      </tr>
    </thead>
    <tbody>
      @php $total = 0; @endphp
      @foreach ($vouchers as $voucher)
      @php $total = $total + $voucher->total_credit; @endphp
      <tr>
        <td style="text-align: center">{{$loop->iteration}}</td>
        <td>
          @if( $voucher->type == "Cash-Payment-Voucher") CPV @endif
          @if( $voucher->type == "Bank-Payment-Voucher") BPV @endif
          @if( $voucher->type == "Cash-Receipt-Voucher") CRV @endif
          @if( $voucher->type == "Bank-Receipt-Voucher") BRV @endif
          @if( $voucher->type == "Contra-Voucher") CONV @endif
          @if( $voucher->type == "Journal-Voucher") JV @endif
        </td>
        <td>{{date('d-M-Y',strtotime($voucher->voucher_date)) }}</td>
        <td>{{ $voucher->prefix }}{{ $voucher->voucher_no }}{{ $voucher->suffix }} </td>
        <td>
          @if($voucher->api_type == "bill_payment") Pay Bills
          @elseif($voucher->api_type == "na") 
          @else {{ ucfirst($voucher->api_type) }}
          @endif
        </td>
        <td style="text-align: center"> {{ $voucher->reference_no }}</td>
        <td>{{ $voucher->payee_name }}</td>
        <td>{{ $voucher->paid_from }}</td>
        <td>{{ $voucher->deposit_to }}</td>
        <td>{{ $voucher->memo }}</td>
        <td style="text-align: right">{{ $voucher->total_credit }}</td>
      </tr>
      @endforeach

      <tr>
        <th colspan="10" style="text-align:right">Total</th>
        <th style="text-align:right" id="grandTotal">{{$total}}</th>
      </tr>
    </tbody>
  </table>
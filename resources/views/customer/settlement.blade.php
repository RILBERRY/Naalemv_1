@extends('/customer/master')
@section('content')  
    <div class="pageDisplayHeader">Settlement</div>
    <div class="ContentDisplayer ">
      <table id="BoatList">
        <tr>
          <th>Date</th>
          <th>House Name</th>
          <th>Package No</th>
          <th style="text-align:right;">Total</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
        @foreach($transaction as $trans)
        <tr>
          <td>{{date('d-m-Y h:i a', strtotime($trans->created_at))}}</td>
          <td>{{$trans->CustAddress}}</td>
          <td>MG-{{$trans->id}}</td>
          <td style="text-align:right;" >{{number_format($trans->total,2)}}</td>
          @if($trans->paymentStatus=="CREDIT")
          <td style="color:red;">{{$trans->paymentStatus}}</td>
          <td><a href="#">Payment</a></td>
          @else
          <td style="color:green;">{{$trans->paymentStatus}}</td>
          <td></td>
         @endif
        </tr> 
        @endforeach
       
      </table>
    </div>
    
@endsection
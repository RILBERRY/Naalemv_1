@extends('/customer/master')
@section('content')  
    <div class="pageDisplayHeader">Transaction</div>
    <div class="ContentDisplayer ">
        <table id="BoatList">
            <tr>
              <th>Date</th>
              <th>House Name</th>
              <th>Package No</th>
              <th>From</th>
              <th>To</th>
              <th>Status</th>
            </tr>
            @foreach($transaction as $trans)
            <tr>
              <td>{{date('d-m-Y h:i a', strtotime($trans->created_at))}}</td>
              <td>{{$trans->CustAddress}}</td>
              <td>MG-{{$trans->id}}</td>
              <td>{{$trans->from}}</td>
              <td>{{$trans->to}}</td>
              <td>{{$trans->status}}</td>
             
            </tr> 
            @endforeach
           
          </table>
      </div>
    
@endsection
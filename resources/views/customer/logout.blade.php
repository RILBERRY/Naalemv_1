@extends('/customer/master')
@section('content')  
    <div class="pageDisplayHeader">Logout</div>
    <div class="ContentDisplayer ">
      <form action="/logout" method="POST" class="dialogBox">
          @csrf
        <p> Are you sure?</p>
        <button type="submit" onclick="saving()">Logout</button>
      </form>
    </div>
    
@endsection
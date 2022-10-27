@extends('/customer/master')
@section('content')  
    <div class="pageDisplayHeader">Setting</div>
    <div class="ContentDisplayer ">
      <form action="/setting/change" method="POST" class="dialogBox" >
          @csrf
        <h3>Change Password</h3>
        <div class="formCont">
          <input type="password" name="old_pass" placeholder="Old Password">
          <input type="password" name="new_pass" placeholder="New Password">
          <input type="password" name="con_pass" placeholder="New Password Confirmation">
        </div>
        <button type="submit">Change</button>
      </form>
    </div>
    
@endsection
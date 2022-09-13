<!DOCTYPE html>
@extends('/eng/baseTemp')
@section('content')   



    <!-- users details -->
    @if(auth()->user()->rank == "OWNER" )
    <div class="ContContainer" id="users">
        <h4>USERS</h4> 
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col col-1">Name</div>
                <div class="col col-2">Role</div>
                <div class="col col-2">Contact</div>
                <div class="col col-4">Status</div>
            </li>
            @foreach($users as $user)
            <li class="table-row" onclick="NewUser('{{$user->id}}')">
                <div class="col col-1" id="name{{$user->id}}" data-label="Des">{{$user->fullname}}</div>
                <div class="col col-2" id="rank{{$user->id}}" data-label="U-Price">{{$user->rank}}</div>
                <div class="col col-2" id="contact{{$user->id}}" data-label="U-Price">{{$user->contact}}</div>
                <div class="col col-4" id="status{{$user->id}}" data-label="S-Total" >{{$user->status === 1?'has Access':'No Access'}}</div>
            </li>
            @endforeach
            <div class="MiniBtn middle" onClick="NewUser()"> + </div>
        </ul>
    </div>
    @endif
    
    <form action="/setting/change" method="POST" class="ContContainer" id="changePass">
        @csrf
        <h4>Change Password</h4> 
        <input type="password" name="old_pass" placeholder="Old Password" class="inputField inputSmall" >
        <input type="password" name="new_pass" placeholder="New Password" class="inputField inputSmall" >
        <input type="password" name="con_pass" placeholder="Confirm Password"class="inputField inputSmall" >
        <button type="submit" name="Submit"  class="FormBtn inputSmall ">UPDATE</button>
    </form>

    @if(auth()->user()->rank == "OWNER" )
    {{-- pop up form for creating new crew user --}}
    @if ($errors->any())
        <div id="alertMSG" class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="loginForm popForm" id="popForm" style="display:none; margin-top:20px; " >
        <form class="loginFormCont" action="/setting/user" method="POST">
            <h2>Create New User</h2>
            @csrf
            <input type="text" name="Fname" placeholder="Full Name" class="inputField ">
            <input type="number" name="contact" placeholder="Mobile Number" class="inputField">
            <input type="text" name="email" placeholder="Email" class="inputField">
            <input type="password" name="password" placeholder="Password" class="inputField">
            <input type="password" name="password_confirmation" placeholder="Password Confirmation" class="inputField">
            <button type="submit" name="submit" class="FormBtn" onclick="saving()" >Create</button>
            <button onclick="NewUserClose()" class="FormBtn CancelBtn">Cancel</button>
        </form>
    </div>
        
    <div class="loginForm popForm" id="popFormEdit" style="display:none; margin-top:20px; " >
        <form class="loginFormCont" id="editForm" action="/setting/user/" method="POST">
            <h2>Edit User</h2>
            @csrf
            <input type="hidden" name="_method" value="patch">
            <input type="text" id="name" name="Fname" placeholder="Full Name" class="inputField ">
            <input type="number" id="contact" name="contact" placeholder="Mobile Number" class="inputField">
            <input type="text" id="email" name="email" placeholder="Email" class="inputField">
            <input type="password" name="password" placeholder="Password" class="inputField">
            <input type="password" name="password_confirmation" placeholder="Password Confirmation" class="inputField">
            <select name="Status" id="status"  class="inputField">
                <option value="0">Remove Access</option>
                <option value="1">has Access</option>
            </select>
            <button type="submit" name="submit" class="FormBtn">Update</button>
            <button onclick="NewUserClose('out')" class="FormBtn CancelBtn">Cancel</button>
        </form>
        
    </div>
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function NewUser(input){
            document.getElementById('users').style.display='none';
            document.getElementById('changePass').style.display='none';
            if(input){
                document.getElementById('popFormEdit').style.display='block';
                FillForm(input);
            }else{
                document.getElementById('popForm').style.display='block';
                
            }
        }
        function NewUserClose(input){
            event.preventDefault();
            if(input){
                document.getElementById('popFormEdit').style.display='none';
            }else{
                document.getElementById('popForm').style.display='none';
            }
            document.getElementById('users').style.display='block';
            document.getElementById('changePass').style.display='block';
        }
        function FillForm(id){
            $('#name').val($('#name'+id).text());
            $('#contact').val($('#contact'+id).text());
            $('#name').val($('#name'+id).text());
            $('#editForm').attr('action', '/setting/user/'+id);
            $('#status'+id)!=='has Access' ? $('#status').val(1): $('#status').val(0);
        }
    </script>


@endsection
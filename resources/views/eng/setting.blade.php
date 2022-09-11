<!DOCTYPE html>
@extends('/eng/baseTemp')
@section('content')   

    <!-- users details -->
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
            <li class="table-row" onclick="{{$user->id}}">
                <div class="col col-1" data-label="Des">{{$user->fullname}}</div>
                <div class="col col-2" data-label="U-Price">{{$user->rank}}</div>
                <div class="col col-2" data-label="U-Price">{{$user->contact}}</div>
                <div class="col col-4" data-label="S-Total" onclick="">{{$user->status === 1?'has Access':'No Access'}}</div>
            </li>
            @endforeach
            <div class="MiniBtn middle" onClick="NewUser()"> + </div>
        </ul>
    </div>
    
    <div class="ContContainer" id="changePass">
        <h4>Change Password</h4> 
        <a href="/setting"><button class="MiniBtn" onClick=""> clear </button></a>
        <input type="password" placeholder="Old Password" class="inputField inputSmall" >
        <input type="password" placeholder="New Password" class="inputField inputSmall" >
        <input type="password" placeholder="Confirm Password"class="inputField inputSmall" >
        <button type="submit" name="Submit" value="SaveCust" class="FormBtn inputSmall ">UPDATE</button>
    </div>

    {{-- pop up form for creating new crew user --}}
    <div class="loginForm popForm" id="popForm" style="display:none" >
        @if ($errors->any())
            <div id="alertMSG" class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="loginFormCont" action="/register" method="POST">
            <h2>Create New User</h2>
            @csrf
            <input type="text" name="Fname" placeholder="Fullsdf Name" class="inputField ">
            <input type="number" name="contact" placeholder="Mobile Number" class="inputField">
            <input type="text" name="email" placeholder="Email" class="inputField">
            <input type="password" name="password" placeholder="Password" class="inputField">
            <input type="password" name="password_confirmation" placeholder="Password Confirmation" class="inputField">

            <button type="submit" name="submit" class="FormBtn">Create</button>
            <button onclick="NewUserClose()" class="FormBtn CancelBtn">Cancel</button>
        </form>
        
    </div>

    <script>
        function NewUser(){
            document.getElementById('popForm').style.display='block';
            document.getElementById('users').style.display='none';
            document.getElementById('changePass').style.display='none';
        }
        function NewUserClose(){
            event.preventDefault();
            document.getElementById('popForm').style.display='none';
            document.getElementById('users').style.display='block';
            document.getElementById('changePass').style.display='block';
        }
    </script>


@endsection
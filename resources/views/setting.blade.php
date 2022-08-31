<!DOCTYPE html>
@extends('/baseTemp')
@section('content')   
{{-- boat details --}}
    <div class="ContContainer">
        <h4>BOAT DETAILS</h4> 
        <input type="text" value="Boat Name: {{$VesselInfo->name }}" class="inputField inputSmall" readonly>
        <input type="text" value="Owner: {{Auth::user()->fullname }}" class="inputField inputSmall" readonly>
        <input type="text" value="Contact Number: {{Auth::user()->contact }}" class="inputField inputSmall" readonly>
        <input type="text" value="Boat Island:  {{$VesselInfo->island }}" class="inputField inputSmall" readonly>
        <button class="MiniBtn" onClick=""> Edit</button>
    </div>
    
    <!-- users details -->
    <div class="ContContainer">
        <h4>USERS</h4> 
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col col-1">Name</div>
                <div class="col col-2">Contact</div>
                <div class="col col-4">Status</div>
            </li>
            
            <li class="table-row">
                <div class="col col-1" data-label="Des">Adam Ali</div>
                <div class="col col-2" data-label="U-Price">9101010</div>
                <div class="col col-4" data-label="S-Total" onclick="">Active</div>
            </li>
            <button class="MiniBtn" onClick=""> + </button>
        </ul>
    </div>
    
    <div class="ContContainer">
        <h4>Change Password</h4> 
        <a href="/setting"><button class="MiniBtn" onClick=""> clear </button></a>
        <input type="password" placeholder="Old Password" class="inputField inputSmall" >
        <input type="password" placeholder="New Password" class="inputField inputSmall" >
        <input type="password" placeholder="Confirm Password"class="inputField inputSmall" >
        <button type="submit" name="Submit" value="SaveCust" class="FormBtn inputSmall ">UPDATE</button>
    </div>



    {{-- pop up form for creating new crew user --}}
    <div class="loginForm popForm">
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
            <input type="text" name="Fname" placeholder="Full Name" class="inputField">
            <input type="number" name="contact" placeholder="Mobile Number" class="inputField">
            <input type="hidden" name="boatid" value="{{$VesselInfo->id }}" class="inputField">
            <input type="text" name="email" placeholder="Email" class="inputField">
            <input type="password" name="password" placeholder="Password" class="inputField">
            <input type="password" name="password_confirmation" placeholder="Password Confirmation" class="inputField">
            <button type="submit" name="submit" class="FormBtn">Create</button>
            <a onclick="UserClos()" class="FormBtn CancelBtn">Cancel</a>
        </form>
    </div>


@endsection
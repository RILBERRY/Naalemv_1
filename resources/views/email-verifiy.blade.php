<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('Customer.css')}}">
    <title>Customer portal</title>
</head>
<body class="HeadContainer">
    @if (session('status_success'))
    <div id="alertMSG" class="alert alert-success">
        {{ session('status_success') }}
    </div>
    @endif
    @if (session('status_error'))
        <div id="alertMSG" class="alert alert-danger">
            {{ session('status_error') }}
        </div>
    @endif
    <div class="sideNav">
        <h3 class="LogoHeader">Naale MV</h3>
        {{-- <div class="Nav">
            <a href="dashboard">Dashboard</a>
            <a href="schedule">Schedule</a>
            <a href="transaction">Transaction</a>
            <a href="settlement">Settlement</a>
            <a href="setting">Setting</a>
            <a href="logout">Logout</a>
        </div> --}}
    </div>
    <div class="mainContainer">
        <div class="pageDisplayHeader">Email verification</div>
        <div class="ContentDisplayer ">
            <form action="/logout" method="POST" class="dialogBox">
                <p> Please Verifiy your email to continue</p>
                <p> or </p>
              @csrf
            <button type="submit" onclick="saving()">Logout</button>
          </form>
        </div>
    </div>
    <script>
        setTimeout(function(){
            if(document.getElementById('alertMSG')){
                document.getElementById('alertMSG').style.display = 'none';
                console.log(document.getElementById('alertMSG').style.display);
            }
        },3000);
    </script>

</body>
</html>
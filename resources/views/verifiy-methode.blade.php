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
    </div>
    <div class="mainContainer">
        <div class="pageDisplayHeader">Verification</div>
        <div class="ContentDisplayer ">
            <form action="/send-otp" method="POST" class="dialogBox">
                <p> Choose Method to varify</p><br>
                <select name="varify_method" class="inputField" style=""> <br>
                    <option value="SMS">SMS</option>
                    <option value="Email">Email</option>
                </select>
              @csrf
            <button type="submit">Send Otp</button>
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
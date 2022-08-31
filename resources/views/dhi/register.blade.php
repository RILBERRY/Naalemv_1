<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Naale MV - Portal</title>
</head>
<body>
    <div class="MaxContainer">
        <h3 class="PageTitle">Naale MV</h3>
        <div class="mainCont">
            <div class="imgCont">
                <img src="{{asset('img/BG-IMG-LOGIN.png')}}" alt="" srcset="">
            </div>
            <div class="loginForm">
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
                   @csrf
                    <input type="text" name="Fname" placeholder="Full Name" class="inputField">
                    <input type="number" name="contact" placeholder="Mobile Number" class="inputField">
                    <input type="text" name="bname" placeholder="Boat Name" class="inputField">
                    <input type="text" name="boatLoc" placeholder="Boat Island " class="inputField">
                    <input type="text" name="boatRegNo" placeholder="Boat Registration No " class="inputField">
                    <input type="text" name="email" placeholder="Email" class="inputField">
                    <input type="password" name="password" placeholder="Password" class="inputField">
                    <input type="password" name="password_confirmation" placeholder="Password Confirmation" class="inputField">
                    <button type="submit" class="FormBtn">Register</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function(){
            document.getElementById('alertMSG').style.display = "none";
        }, 5000);
    </script>
</body>
</html>
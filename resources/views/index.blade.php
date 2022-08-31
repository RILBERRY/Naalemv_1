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
            @if ($errors->any())
                <div id="alertMSG" class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="loginForm">
                <form class="loginFormCont" action="/login" method="POST">
                    @csrf
                    <input type="number" name="contact" placeholder="Mobile Number" class="inputField">
                    <input type="password" name="password" placeholder="Password" class="inputField">
                    <button type="submit" class="FormBtn">LOGIN</button>
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
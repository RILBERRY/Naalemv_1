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
    <div id="loading">
        <i class="fas fa-spinner fa-pulse"></i>
    </div> 
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
                    <select name="iscustomer" id="iscust" onchange="isCustomer('iscust')" class="inputField">
                        <option value="boat">boat</option>
                        <option value="customer">customer</option>
                    </select>
                    <input type="text" name="email" placeholder="email" class="inputField">
                    <input type="text" name="bname" id="bname" placeholder="Boat Name" class="inputField">
                    <input type="text" name="boatLoc" id="boatLoc" placeholder="Boat Island " class="inputField">
                    <input type="text" name="boatRegNo" id="boatRegNo" placeholder="Boat Registration No " class="inputField">
                    <input type="password" name="password" placeholder="Password" class="inputField">
                    <input type="password" name="password_confirmation" placeholder="Password Confirmation" class="inputField">
                    <button type="submit" class="FormBtn" onclick="saving()" >Register</button>
                    <div class="RegBtn">
                        <a href="/login" class="regLink">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function(){
            document.getElementById('alertMSG').style.display = "none";
        }, 5000);
        function isCustomer(input){
            var selected = document.getElementById(input).value;
            if(selected == "customer"){
                document.getElementById('bname').style.display = "none";
                document.getElementById('boatLoc').style.display = "none";
                document.getElementById('boatRegNo').style.display = "none";
            }else{
                document.getElementById('bname').style.display = "block";
                document.getElementById('boatLoc').style.display = "block";
                document.getElementById('boatRegNo').style.display = "block";

            }
        }
    </script>
</body>
</html>
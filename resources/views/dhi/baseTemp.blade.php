<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Luxurious+Roman&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/abd32b9c39.js" crossorigin="anonymous"></script>
    <title>Naale MV - ފުރަތަމަ ސަފުހާ</title>
</head>
<body>
    <div class="MaxContainer">
        <div class="NavCloser" id="NavCloser" onclick="CloseNav()"></div>
        <div class="topCont">
            <div class="Logo">
                <h2>Naale MV</h2>
                <h4>{{Auth::user()->boatname }}</h4>
            </div>
            @if(Str::upper(Request::path()) == "SETTING")
            <form action="/logout" method="POST">
                @csrf
                <li id="NavL4"><button class="BtnNone" type="Submit">އެޕް އިން ނިއްވާލާ <i style="font-size:18px; padding:5px;" class="fas fa-sign-out-alt"></i></button></li>
            </form>
            @endif
            
        </div>
        <h3 class="pageTitle">{{Str::upper(Request::path())}}</h3>
        @if(Str::upper(Request::path()) == "SETTING")
            <div class="mainContainer p10 SFix">
        @else
        <div class="mainContainer p10">
        @endif
            <!-- Contents will be loaded hear from the database -->
            @yield('content')
            
            <!-- end of the content -->
        </div>
        <div class="navBar" id="NavBar">
            <li id="NavL3"><a href="/dashboard"><i class="fas fa-home" style="font-size:24px; padding:5px;" ></i><br>ފުރަތަމް ޕޭޖު</a></li>
            <li id="NavL3"><a href="/create"><i class="fas fa-ship" style="font-size:24px; padding:5px 0px;" ></i><i class="fas fa-plus-circle"style="font-size:18px;"></i><br> މުދާ އަރުވާ</a></li>
            <li id="NavL3"><a href="/collect"><i class="fas fa-ship" style="font-size:24px; padding:5px 0px;"><i class="fas fa-arrow-circle-down"style="font-size:18px;"></i></i><br>މުދާ ބާލަން </a></li>
            <li id="NavL3"><a href="/setting"><i class="fas fa-user-cog" style="font-size:24px; padding:5px 0px;"></i><br>ސެޓިންގސް</a></li>
        </div>

    </div>
    
    <script>
        function CloseNav(){
            document.getElementById('NavCloser').style.display = 'none';
            document.getElementById('popUpContainer').style.display = 'none';
            document.getElementById('AddItem').style.display ='none';
            document.getElementById('EditItem').style.display = 'none';
        }
        setTimeout(function(){
            if(document.getElementById('alertMSG')){
                document.getElementById('alertMSG').style.display = "none";
            }
        }, 5000);
    </script>
</body>
</html>
@extends('/dhi/baseTemp')
@section('content')
    <h4 class="Note">Scan QR from viber</h4>
    <img src="img/ViberBotQR.png" alt="" srcset="" class="ViberBotQR">

    <a href="/customer">
        <button class="addButton SaveBtn" onclick="saving()" >
            <h3>Done</h3>
        </button>
    </a>
@endsection
@extends('/eng/baseTemp')
@section('content')

<input type="text" name="search" placeholder="Search Island Name or code" class="inputField inputSmall" id="CateSearch">
    <div class="cardHolder" id="cardItems">
        @foreach($allIslands as $Island)
        <div class="islandCard" onClick="SelectedIsland('{{$Island->id}}')" >
            <div class="islandDetails">
                <p>Island Code: {{$Island -> code}}</p>
                <p>Island Name : {{$Island -> name}}</p>
            </div>
        </div>
        @endforeach

        
    </div>
    <div class="addButton BtnCont" onclick="PopUpContainer('add_island')">
        <h3>+ New Island</h3>
    </div>

    @if ($errors->any())
        <div id="alertMSG" class="alert alert-danger">
            <ul  >
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/dashboard/island" method="POST" id="popUpContainer">
        @csrf
        <h3>Add new Island</h3>
        <input type="text" name="atoll" placeholder="Atoll" class="inputField">    
        <input type="text" name="name" placeholder="Island Name" class="inputField">    
        <input type="text" name="code" placeholder="Island Code" class="inputField">    
        <button class="CateSaveBtn" onclick="PopUpContainer('add_island')" onclick="saving()">
            <h3>Save</h3>
        </button>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>

        
        function PopUpContainer(_input){
            if(document.getElementById('popUpContainer').style.display == 'block'){
                saving();
            }
            if(_input =="add_island"){
                document.getElementById('popUpContainer').style.display = 'block';
                document.getElementById('NavCloser').style.display = 'block';
            }
        }
        function SelectedIsland(islandID){
            window.location.href = "/customer?island="+islandID;
        }
    </script>

@endsection
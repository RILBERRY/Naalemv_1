@extends('/dhi/baseTemp')
@section('content')

    <div class="search">
        <input  type="text" name="" placeholder="Search By number, house name, load no" class="inputField inputSmall ">
    </div>
    <div class="ContContainer">
        <h4 class="TitleHeading">----------- items in Boat ----------- </h4>
        @foreach($AllPackage as $_AllPackage)
        @if($_AllPackage->status != "COLLECTED")
        <a class="textDecod"href="clam?packid={{$_AllPackage->id}}">
            <div class="ItemCont">
                <h4 class="LoadNo"><strong>Package : </strong> MG-L-{{$_AllPackage->id}}</h4>
                <h4 class="ItemDes" ><strong>House name:</strong> {{$_AllPackage->CustAddress}} </h4>
            </div>
        </a>
        @endif
        @endforeach
        
    </div>
    
    <div class="ContContainer">
        <h4 class="TitleHeading">------------ Collected items ------------ </h4>
        @foreach($AllPackage as $_AllPackage)
        @if($_AllPackage->status == "COLLECTED")
        <a class="textDecod"href="clam?packid={{$_AllPackage->id}}">
            <div class="ItemCont CollectedCol">
                <h4 class="LoadNo"><strong>Load : </strong> MG-2021-{{$_AllPackage->id}}</h4>
                <h4 class="ItemDes" ><strong>House name:</strong> {{$_AllPackage->CustAddress}} </h4>
            </div>
        </a>
        @endif
        @endforeach
    </div>

   

@endsection
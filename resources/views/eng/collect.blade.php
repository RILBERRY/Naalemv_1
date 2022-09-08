@extends('/eng/baseTemp')
@section('content')

    <div class="search">
        <input  type="text" name="q" id="q" placeholder="Search By number, house name, load no" class="inputField inputSmall ">
    </div>
    
    <div class="ContContainer" id="items">
        <h4 class="TitleHeading"> -- items in Boat -- </h4>
        @foreach($AllPackage as $_AllPackage)
        @if($_AllPackage->status  == "LOADED")
        <a class="textDecod"href="clam?packid={{$_AllPackage->id}}">
            <div class="ItemCont">
                <h4 class="LoadNo"><strong>Package : </strong> MG-L-{{$_AllPackage->id}}</h4>
                <h4 class="ItemDes" ><strong>House name:</strong> {{$_AllPackage->CustAddress}} </h4>
                <h4 class="ItemDes" ><strong>House name:</strong> {{$_AllPackage->to}} </h4>
            </div>
        </a>
        @endif
        @endforeach
        
    </div>
    
    <div class="ContContainer" id="colItem">
        <h4 class="TitleHeading"> -- Collected items -- </h4>
        @foreach($AllPackage as $_AllPackage)
        @if($_AllPackage->status == "COLLECTED")
        <a class="textDecod"href="clam?packid={{$_AllPackage->id}}">
            <div class="ItemCont CollectedCol">
                <h4 class="LoadNo"><strong>Load : </strong> MG-2021-{{$_AllPackage->id}}</h4>
                <h4 class="ItemDes" ><strong>House name:</strong> {{$_AllPackage->CustAddress}} </h4>
                <h4 class="ItemDes" ><strong>House name:</strong> {{$_AllPackage->to}} </h4>
            </div>
        </a>
        @endif
        @endforeach
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $('#q').keyup(function(){
            var apiUrl = "/collect/search?q="+ document.getElementById('q').value;
            document.getElementById('colItem').innerHTML = "";
            document.getElementById('colItem').style.display = 'none';
            document.getElementById('items').innerHTML = "<h4 class='TitleHeading'>----------- Search result ----------- </h4>";
            $.ajax({url: apiUrl, success: function(result){
                console.log(result);
                $(result).each(function(index) {
                    if(result[index].status  == "LOADED"){
                        document.getElementById('items').innerHTML  += "<a class='textDecod' href='clam?packid="+result[index].id+"'</a>"+
                            "<div class='ItemCont'>"+
                                "<h4 class='LoadNo'><strong>Package : </strong> MG-L-"+result[index].id+"</h4>"+
                                "<h4 class='ItemDes' ><strong>House name:</strong> "+result[index].CustAddress+"</h4>"+
                                "<h4 class='ItemDes' ><strong>House name:</strong> "+result[index].to+"</h4>"+
                            "</div>"+
                        "</a>"
                    }else{
                        document.getElementById('items').innerHTML  += "<a class='textDecod' href='clam?packid="+result[index].id+"'</a>"+
                            "<div class='ItemCont CollectedCol'>"+
                                "<h4 class='LoadNo'><strong>Package : </strong> MG-L-"+result[index].id+"</h4>"+
                                "<h4 class='ItemDes' ><strong>House name:</strong> "+result[index].CustAddress+"</h4>"+
                                "<h4 class='ItemDes' ><strong>House name:</strong> "+result[index].to+"</h4>"+
                            "</div>"+
                        "</a>"
                    }
                });
            }});
            document.getElementById('items').innerHTML
        });
    </script>
        
@endsection
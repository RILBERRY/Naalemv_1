@extends('/eng/baseTemp')
@section('content')

<input type="text" name="search" placeholder="Search Category Name" class="inputField inputSmall" id="CateSearch">
    <div class="cardHolder" id="cardItems">
        @foreach($allCategories as $category)
        {{-- <a href="create?cateid={{$category -> id}}"> --}}
        <div class="card" onClick="AddNewItem('{{$category->id}}')" >
            <img src="img/{{$category -> img_path}}" alt="" srcset="" class="cardImg">
            <div class="cardDetail">
                <p>{{$category -> cate_name}}</p>
                <p>MVR {{$category -> unit_price}}/PER EACH</p>
            </div>
        </div>
        @endforeach

        
    </div>
    <div class="addButton BtnCont" onclick="PopUpContainer('category')">
        <h3>+ New Category</h3>
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
    <form action="/dashboard" method="POST" enctype="multipart/form-data" id="popUpContainer">
        @csrf
        <h3>Add new Category</h3>
        <input type="text" name="cate_name" placeholder="Category Name" class="inputField">
        <input type="number" name="unit_price" placeholder="Unit Price" step="0.01" class="inputField">
        <input type="file" name="img" class="inputField"><br>
        
        <button class="CateSaveBtn" onclick="PopUpContainer('category')" onclick="saving()">
            <h3>Save</h3>
        </button>
    </form>

    <div class="CateContainer" id="CC">
        <h2 class="closer"onclick="Closer()">X</h2>
        <h3 class="Cateheading">Categories</h3>
        <div class="cardHolder">
            @foreach($allCategories as $category)
            <div class="card" onClick="AddNewItem('{{$category->id}}')">
                <input type="hidden" id="name{{$category->id}}" value="{{$category->cate_name}}">
                <input type="hidden" id="price{{$category->id}}" value="{{$category->unit_price}}">
                <img src="img/{{$category -> img_path}}" alt="" srcset="" class="cardImg">
                <div class="cardDetail">
                    <p>{{$category -> cate_name}}</p>
                    <p>MVR {{$category -> unit_price}}/PER EACH</p>
                </div>
            </div>
            @endforeach 
        </div>
        <div class="addButton" onclick="PopUpContainer('category')">
            <h3>+ New Category</h3>
        </div>
    </div>
    <form action="/create" method="POST" enctype="multipart/form-data" class="popUpContainer" id="AddItem">
        @csrf
        <h3 id="AddHeading">Add Goain items</h3>
        <input type="number" name="qty" placeholder="Number of pieces" value="1"  class="inputField">
        <input type="number" id="unit_price" name="unit_price" value="" step="0.01" class="inputField">
        <input type="hidden" id="CateID" name="cateID" value="" >
        <input type="file" style="display:none;"  name="img" class="inputField"><br>
        @if(Session::has('newpackage'))
            <input type="hidden" id="packID" name="packID" value="{{Session::get('newpackage')->id}}" >
        @endif
        <button Type="submit" class="CateSaveBtn posRela" name="submit" value="AddItem_Guest" onclick="saving()">
            <h3 >ADD</h3>
        </button>
    </form>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $('#CateSearch').keyup(function(){
            var apiUrl = "searchcate?s="+ document.getElementById('CateSearch').value;
            document.getElementById('cardItems').innerHTML = "";
            $.ajax({url: apiUrl, success: function(result){
                $(result).each(function(index) {
                    document.getElementById('cardItems').innerHTML  += "<div class='card' onClick='AddNewItem("+result[index].id+")' >"+
                    "<img src='img/"+result[index].img_path+"' alt='' srcset='' class='cardImg'>"+
                    "<div class='cardDetail'>"+
                        "<p>"+result[index].cate_name+"</p>"+
                        "<p>MVR "+result[index].unit_price+"/PER EACH</p>"+
                    "</div>"+
                "</div>"
                });
            }});
            document.getElementById('cardItems').innerHTML
        });
        
        function PopUpContainer(_input){
            if(document.getElementById('popUpContainer').style.display == 'block'){
                saving();
            }
            if(_input =="category"){
                document.getElementById('popUpContainer').style.display = 'block';
                document.getElementById('NavCloser').style.display = 'block';
            }
        }
        function AddNewItem(_ItemID){
            var name = "name"+_ItemID;
            var price = "price"+_ItemID;
            var _name = document.getElementById(name).value;
            var _price = document.getElementById(price).value;
            document.getElementById('AddHeading').innerHTML = "Add " +_name + " ";
            document.getElementById('unit_price').value = _price;
            document.getElementById('CateID').value = _ItemID;
            document.getElementById('NavCloser').style.display = 'block';
            document.getElementById('AddItem').style.display ='block';
        }
    </script>

@endsection
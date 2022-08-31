<!DOCTYPE html>
@extends('/baseTemp')
@section('content')   
@if(Session()->has('NewCustomer') && Session::get('NewCustomer')->CustNumber != 0)
        <div class="ContContainer">
            <h4>CUSTOMER DETAILS</h4>
            <input type="number" name="CustNumber" value="{{Session::get('NewCustomer')->CustNumber}}" class="inputField inputSmall">
            <input type="text" name="CustName" value="{{Session::get('NewCustomer')->CustName}}" class="inputField inputSmall">
            <input type="text" name="CustAddress" value="{{Session::get('newpackage')->CustAddress}}" class="inputField inputSmall">
            <select class="inputField inputSmall greytextBorder" name="LFrom" id="">
                <option value="{{Session::get('newpackage')->from}}" >{{Session::get('newpackage')->from}}</option>
            </select>
            <select class="inputField inputSmall greytextBorder " name="ULTo" id="">
                <option value="{{Session::get('newpackage')->to}}" >{{Session::get('newpackage')->to}}</option>
            </select>
        </div>
    @else
        <form action="/customer" method="POST" class="ContContainer">
            @csrf
            @if ($errors->any())
                <div id="alertMSG" class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h4>CUSTOMER DETAILS</h4>
            <input type="number" name="CustNumber" placeholder="Mobile Number" class="inputField inputSmall" onChange="CheckCustomer()" id="CustNo">
            <input type="text" name="CustName" placeholder="Name" class="inputField inputSmall" id="CustName">
            <input type="text" name="CustAddress" placeholder="House Name" class="inputField inputSmall" >
            <select class="inputField inputSmall greytextBorder" name="LFrom" id="">
                <option value="" >Load From</option>
                <option value="K.MALE" >male'</option>
            </select>
            <select class="inputField inputSmall greytextBorder " name="ULTo" id="">
                <option value="" >Un-Load To</option>
                <option value="L.ISDHOO" >L-Isdhoo</option>
            </select>
            <button type="submit" name="Submit" value="SaveCust" class="FormBtn inputSmall ">SAVE</button>
        </form>
    
    @endif

    <!-- Items Loaded Container -->
    <div class="ContContainer">
        <h4>LOAD DETAILS</h4>
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col col-1">Details</div>
                <div class="col col-2">cost</div>
                <div class="col col-3">qty</div>
                <div class="col col-4">Total</div>
            </li>
            @if($Shipments ?? '')
            @foreach($Shipments as $items)
            <li class="table-row" onclick="EditItem({{$items->id}})">
                @foreach($allCategories as $cate)
                @if($cate->id == $items->category_id)
                <div class="col col-1" id="Ename{{$items->id}}" data-label="Des">{{$cate->cate_name}}</div>
                @endif
                @endforeach
                <div class="col col-2" id="Eqty{{$items->id}}" data-label="U-Price">{{$items->qty}}</div>
                <div class="col col-3" id="Eprice{{$items->id}}"data-label="qty">{{$items->unit_price}}</div>
                <div class="col col-4" data-label="S-Total">{{$items->unit_price * $items->qty}}</div>
            </li>
            @endforeach
            @endif 
        </ul>
        @if($Shipments ?? '') 
        <p class="Summary" id="summary">Total {{$Total}} MVR</p>

        @endif
        <button class="FormBtn inputSmall w-25 addBtn" onClick="openCate()"> + ADD NEW</button>
    </div>
@if(Session()->has('NewCustomer'))
<form action="confirm" method="post">
@csrf
<input type="hidden" name="packageID" value="{{Session::get('newpackage')->id}}">
@endif 
    <div class="ContContainer">
        <h4>PAYMENT DETAILS</h4>
        <select class="inputField inputSmall  greytextBorder" name="payOption" id="payOption" onchange="PaymentDetail('payOption')">
            <option value="POD" >Pay On Delivery</option>
            <option value="NOW" >Pay Now</option>
        </select>
        <div class="PaymentPopup">
            <select class="inputField inputSmall greytextBorder " name="payType" id="payType" onchange="PaymentDetail('payType')">
                <option value="CASH" >Cash</option>
                <option value="TRANSFER" >Transfer</option>
            </select>
            <input type="file" id="paySlip" name="paySlip" placeholder="Name" class="inputField inputSmall">
        </div>
    </div>
    <div class="BtnCont">

        @if(Session()->has('NewCustomer') && Session()->get('NewCustomer')->CustNumber)
        <button class="addButton SaveBtn" name="SubmitType" value="SAVE" type="submit">
            <h3>Save</h3>
        </button><br> <br>
        @endif
        @if(Session()->has('NewCustomer'))
        <button class="addButton CancelBtn " name="SubmitType" value="CANCEL" type="submit">
            <h3>RESET FORM</h3>
        </button>
        @endif
    </div>
    
@if(Session()->has('NewCustomer'))
</form>    

@endif  
    
    <div id="CBC">
    </div>

    <div class="CateContainer" id="CC">
        <h2 class="closer"onclick="Closer()">X</h2>
        <h3 class="Cateheading">Categories</h3>
        <div class="cardHolder">
            @foreach($allCategories as $category)
            <div class="card" onClick="AddNewItem({{$category->id}})">
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
    @if ($errors->any())
        <div id="alertMSG" class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- TO ADD NEW CATEGORY TO THE APP --}}
    <form action="/dashboard" method="POST" enctype="multipart/form-data" class="popUpContainer" id="popUpContainer">
        @csrf
        <h3>Add new Category</h3>
        <input type="text" name="cate_name" placeholder="Category Name" class="inputField">
        <input type="number" name="unit_price" placeholder="Unit Price" step="0.01" class="inputField">
        <input type="file" name="img" class="inputField"><br>
        
        <button class="CateSaveBtn posRela" onclick="PopUpContainer('category')">
            <h3>Save</h3>
        </button>
    </form>
    {{-- TO ADD NEW ITEM TO CUSTOMERS LIST --}}
    <form action="/create" method="POST" enctype="multipart/form-data" class="popUpContainer" id="AddItem">
        @csrf
        <h3 id="AddHeading">Add Goain items</h3>
        <input type="number" name="qty" placeholder="Number of pieces" value="1" class="inputField">
        <input type="number" id="unit_price" name="unit_price"  step="0.01" class="inputField">
        <input type="hidden" id="CateID" name="cateID" value="" >
        <input type="file" style="display:none;"  name="img" class="inputField"><br>
        @if(Session::has('newpackage'))
            <input type="hidden" id="packID" name="packID" value="{{Session::get('newpackage')->id}}" >
        @endif
        <button Type="submit" class="CateSaveBtn posRela" name="submit" value="AddItem">
            <h3 >ADD</h3>
        </button>
    </form>
    {{-- TO EDIT ITEMS FROM CUSTOMERS LIST --}}
    <form action="/create" method="POST" enctype="multipart/form-data" class="popUpContainer" id="EditItem">
        @csrf
        @method('delete')
        <h3 id="EAddHeading">EDIT Goain items</h3>
        <input type="number" id="Eqty" name="qty" placeholder="Number of pieces"  class="inputField">
        <input type="number" id="Eunit_price" name="unit_price" value="" step="0.01" class="inputField">
        <input type="hidden" id="ECateID" name="cateID" value="" >
        @if(Session::has('newpackage'))
            <input type="hidden" id="packID" name="packID" value="{{Session::get('newpackage')->id}}" >
        @endif
        <input type="Submit" value="delete" name="submit" class="inputField delBtn"><br>
        
        <button Type="submit" class="CateSaveBtn posRela" name="submit" value="AddItem" >
            <h3 id="Update">ADD</h3>
        </button>
    </form>

    
    <Script>
       
        @if(Session::has('newpackage') && Session::get('NewCustomer')->CustNumber != 0)
        function openCate(){
            document.getElementById('CBC').style.display = 'block';
            document.getElementById('CC').style.display = 'block';
        }
        @else
        function openCate(){
            alert('Create and save the customer details First.');
        }
        @endif
        function Closer(){
            document.getElementById('CBC').style.display = 'none';
            document.getElementById('CC').style.display = 'none';
        }
        function PopUpContainer(_input){
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
        function EditItem(_ItemID){
            var Ename = "Ename"+_ItemID;
            var qty = "Eqty"+_ItemID;
            var price = "Eprice"+_ItemID;
            var _Ename = document.getElementById(Ename).innerHTML;
            var _qty = document.getElementById(qty).innerHTML;
            var _price = document.getElementById(price).innerHTML;
            document.getElementById('EAddHeading').innerHTML = "Edit " +_Ename + " items";
            document.getElementById('Eqty').value = _qty;
            document.getElementById('Eunit_price').value = _price;
            document.getElementById('ECateID').value = _ItemID;
            document.getElementById('NavCloser').style.display = 'block';
            document.getElementById('EditItem').style.display ='block';
            document.getElementById('Update').innerHTML = "UPDATE";
            document.getElementById('EditItem').action = "/create/"+_ItemID;

        }
        function PaymentDetail(_input){
            if(document.getElementById(_input).value == "POD"){
                document.getElementById('payType').style.display ="none";
                document.getElementById('paySlip').style.display ="none";

            }else if(document.getElementById(_input).value == "NOW"){
                document.getElementById('payType').style.display ="block";
                if(document.getElementById('payType').value == "TRANSFER"){
                    document.getElementById('paySlip').style.display ="block";
                }

            }else if(document.getElementById(_input).value == "CASH"){
                document.getElementById('paySlip').style.display ="none";

            }else if(document.getElementById(_input).value == "TRANSFER"){
                document.getElementById('paySlip').style.display ="block";

            }
        }

    </Script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function CheckCustomer(){
            var CustUrl = "customerinfo?custno="+ document.getElementById('CustNo').value;
            $.ajax({url: CustUrl, success: function(result){
                document.getElementById('CustName').value = result[0].CustName;
            }});
            console.log(CustUrl);
        };
    </script>
    
        
@endsection
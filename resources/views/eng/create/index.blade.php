@extends('eng/baseTemp')
@section('content')  
<div id="loading">
<i class="fas fa-spinner fa-pulse"></i>
</div> 
   

    <!-- Customer Info -->
    @include('eng.create.customer_detail')

    <!-- Items Loaded Container -->
    @include('eng.create.load_detail')

    <!-- payment details -->
    @include('eng.create.form_btn')
 
    
    <div id="CBC">
    </div>

    @include('eng.create.pop_up')

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

    
    
    @if(Session::has('newpackage') && Session::get('NewCustomer')->CustNumber != 0)
    <Script>
        function openCate(){
            document.getElementById('CBC').style.display = 'block';
            document.getElementById('CC').style.display = 'block';
        }
    </Script>
    @else
        
        <Script>
            function openCate(){
                alert('Create and save the customer details First.');
            }
            </Script>
        @endif
    <Script>
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
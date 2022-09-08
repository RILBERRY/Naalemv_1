<!DOCTYPE html>
@extends('/eng/baseTemp')
@section('content')   
    <div class="ContContainer">
        <h4>CUSTOMER DETAILS</h4>
        <input type="number" name="CustNumber" value="{{$laodCustomer[0]->CustNumber}}" class="inputField inputSmall">
        <input type="text" name="CustName" value="{{$laodCustomer[0]->CustName}}" class="inputField inputSmall">
        <input type="text" name="CustAddress" value="{{$load[0]->CustAddress}}" class="inputField inputSmall">
        <select class="inputField inputSmall greytextBorder" name="LFrom" id="">
            <option value="{{$load[0]->from}}" >{{$load[0]->from}}</option>
        </select>
        <select class="inputField inputSmall greytextBorder " name="ULTo" id="">
            <option value="{{$load[0]->to}}" >{{$load[0]->to}}</option>
        </select>
    </div>

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
            @if($itemsLoaded ?? '')
            @foreach($itemsLoaded as $items)
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
             
        <p class="Summary" id="summary">Total {{$Total}} MVR</p>
        @if($load[0]->status != "COLLECTED")
        <button class="FormBtn inputSmall w-25 addBtn" id="EditSH" onClick="Eidt()">EDIT</button>
        <label name="" id="ES" value="0" style="display:none" >Click above items to edit</label>
        @endif
    </div>
@if($load[0]->status == "COLLECTED")
    <form action="collect" method="get" >
@else
    <form action="/clam" method="POST" enctype="multipart/form-data">
@endif
    @csrf
    @if (session('status'))
        <div id="alertMSG" class="alert alert-danger">
            {{ session('status') }}
        </div>
    @endif
    @if($load[0]->status == "COLLECTED")
        @if($load[0]->payment_status)
            @if($load[0]->payment_status->payslip != null)
                <a href="img/{{$load[0]->payment_status->payslip}}" target="_blank"  class="TransferLink"><i class="fas fa-file-image" style="font-size:24px"></i> View transfer Slip</a>
            @endif
            <div class="StampCol">
                <p class="Col">Collected</p>
                <p class="PAID">{{$load[0]->payment_status->paymentType}} - PAYMENT</p>
            </div>
            <div class="BtnCont">
            <button class="addButton SaveBtn" id="CCBtn" type="submit" >
                <h3 >Back</h3>
            </button>
            </div>
        @endif
    @else
        @if($load[0]->payment_status)
            <div class="ContContainer">
                <h4>PAYMENT DETAILS</h4>
                @if($load[0]->payment_status->paymentType == "CASH")
                    <div class="StampCol">
                        <p class="PAID">Total : {{$load[0]->payment_status->total}}</p>
                        <p class="PAID">{{$load[0]->payment_status->paymentType}} - PAYMENT</p>
                    </div>
                @else
                    <a href="img/{{$load[0]->payment_status->payslip}}" target="_blank"  class="TransferLink"><i class="fas fa-file-image" style="font-size:24px"></i> View transfer Slip</a>
                @endif
            </div>
        @else
            <div class="ContContainer">
                <select class="inputField inputSmall  greytextBorder" name="payOption" id="payOption" onchange="PaymentDetail('payOption')">
                    <option value="POD" >Pay On Delivery</option>
                    <option value="NOW" >Pay Now</option>
                </select>
                <div class="PaymentPopup">   
                    <select class="inputField inputSmall greytextBorder " name="payType" id="payType" onchange="PaymentDetail('payType')">
                        <option value="CASH" >Cash</option>
                        <option value="TRANSFER" >Transfer</option>
                    </select>
                    <input type="file" id="paySlip" name="paySlip" placeholder="Name" class="inputField ">
                </div>
            </div>
        @endif
        <input type="hidden" name="packageID" value="{{$load[0]->id}}"> 
        <input type="hidden" name="shipmentTotal" value="{{$Total}}"> 
        <div class="BtnCont">
            <button class="addButton SaveBtn" id="CCBtn" type="submit" onclick="saving()" >
                <h3 onclick="IsEditing()">Collected</h3>
            </button>
        </div>
    @endif
</form>    

    @if ($errors->any())
        <div id="alertMSG" class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
   
    <form action="/edit/0" method="post" enctype="multipart/form-data" class="popUpContainer"  id="EditItem">
        @csrf
        <input type="hidden" name="_method" value="patch" >
        <input type="hidden" name="shipmentID" value="{{$load[0]->id}}" >
        <h3 id="AddHeading">Add Goain items</h3>
        <input type="number" id="Eqty" name="qty" placeholder="Number of pieces"  class="inputField">
        <input type="number" id="Eunit_price" name="unit_price" value="" step="0.01" class="inputField">
        <input type="hidden" id="ECateID" name="cateID" value="" >
        
        <button Type="submit" class="CateSaveBtn posRela" name="submit" value="edit" onclick="PopUpContainer('category')" onclick="saving()">
            <h3 id="Update">ADD</h3>
        </button><br><br>
        <button type="Submit" value="delete" name="submit" class=" CateSaveBtn posRela delBtn">
            <h3 >DELETE</h3>
        </button>
    </form>

    
    <Script>
        @if(Session::has('newpackage'))
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
      

        function EditItem(_ItemID){
            if(document.getElementById('ES').value == 1){  
                var Ename = "Ename"+_ItemID;
                var qty = "Eqty"+_ItemID;
                var price = "Eprice"+_ItemID;
                var _Ename = document.getElementById(Ename).innerHTML;
                var _qty = document.getElementById(qty).innerHTML;
                var _price = document.getElementById(price).innerHTML;
                document.getElementById('AddHeading').innerHTML = "Edit item " +_Ename + " ";
                document.getElementById('Eqty').value = _qty;
                document.getElementById('Eunit_price').value = _price;
                document.getElementById('ECateID').value = _ItemID;
                document.getElementById('NavCloser').style.display = 'block';
                document.getElementById('EditItem').style.display ='block';
                document.getElementById('Update').innerHTML = "UPDATE";
                document.getElementById('EditItem').action = "/edit/"+_ItemID;
            }else{
                alert("To edit items. Click EDIT button first")
            }

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

        function Eidt(){
            if(document.getElementById('EditSH').innerHTML == "EDIT"){
                document.getElementById('EditSH').innerHTML = "DONE";
                document.getElementById('ES').value = 1;
                document.getElementById('ES').style.display = "block";
                document.getElementById('CCBtn').enabled = false;


            }else{
                document.getElementById('EditSH').innerHTML = "EDIT";
                document.getElementById('ES').value = 0;
                document.getElementById('ES').style.display = "none";
                document.getElementById('CCBtn').enabled = true;
            }
        }
        function IsEditing(){
            if(document.getElementById('CCBtn').enabled == false){
                alert("You are in edit mode. Please Click DONE")
            }
        }

    </Script>
    
        
@endsection
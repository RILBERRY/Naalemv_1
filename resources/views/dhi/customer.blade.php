<!DOCTYPE html>
@extends('/dhi/baseTemp')
@section('content')         
    <!-- customer Details Container -->
    <form action="/customer" method="POST" class="ContContainer">
        @csrf
        @if ($errors->any())
            <div id="alert" class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h4>CUSTOMER DETAILS</h4>
        <input type="number" name="CustNumber" placeholder="މުދަލުގެ ވެރިފަރާތުގެ ނަންބަރު" class="inputField inputSmall">
        <input type="text" name="CustName" placeholder="މުދަލުގެ ވެރިފަރާތުގެ ނަން" class="inputField inputSmall">
        <input type="text" name="CustAddress" placeholder="މުދާފނުވާ ގޭގެ ންނަ" class="inputField inputSmall">
        <select class="inputField inputSmall greytextBorder" name="LFrom" id="">
            <option value="" >މުދާ އެރުވި ރަށުގެ ނަން</option>
            <option value="K.MALE" >male'</option>
        </select>
        <select class="inputField inputSmall greytextBorder " name="ULTo" id="">
            <option value="" >މުދާ ބާލާނެ ރަށުގެ ނަން</option>
            <option value="L.ISDHOO" >L-Isdhoo</option>
        </select>
        <button type="submit" name="Submit" value="SaveCust" class="FormBtn inputSmall ">SAVE</button>
    </form>
    <!-- Items Loaded Container -->
    <div class="ContContainer">
        <h4>މުދަލުގެ ތަފުސީލް</h4>
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col col-1">ތަފުސީލް</div>
                <div class="col col-2">ރޭޓު</div>
                <div class="col col-3">އަދަދު</div>
                <div class="col col-4">ޖުމުލަ</div>
            </li>
            <li class="table-row">
                <div class="col col-1" data-label="Des">BOX</div>
                <div class="col col-2" data-label="U-Price">$15</div>
                <div class="col col-3" data-label="qty">3</div>
                <div class="col col-4" data-label="S-Total">$45.00</div>
            </li>
            <li class="table-row">
                <div class="col col-1" data-label="Des">BOX</div>
                <div class="col col-2" data-label="U-Price">$15</div>
                <div class="col col-3" data-label="qty">3</div>
                <div class="col col-4" data-label="S-Total">$45.00</div>
            </li>
            
            <p class="Summary">Total $90.00</p>
            <button type="submit" class="FormBtn inputSmall w-25 addBtn"> + ADD NEW</button>
        </div>
        
        <div class="ContContainer">
            <h4>PAYMENT DETAILS</h4>
            <select class="inputField inputSmall  greytextBorder" name="" id="">
                <option value="" >Pay On Delivery</option>
                <option value="" >Pay Now</option>
            </select>
            <div class="PaymentPopup">
                <select class="inputField inputSmall greytextBorder " name="" id="">
                    <option value="" >Cash</option>
                    <option value="" >Transfer</option>
                </select>
                <input type="file" name="" placeholder="Name" class="inputField inputSmall">
        </div>

        <p class="Summary">Total $90.00</p>
    </div>
    <a href="/confirm.html">
        <button class="addButton SaveBtn">
            <h3>Save</h3>
        </button>
    </a>

        
@endsection
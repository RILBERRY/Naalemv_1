@extends('/baseTemp')
@section('content')
            
    <!-- customer Details Container -->
    <div class="ContContainer">
        <h4>CUSTOMER DETAILS</h4>
        <input type="number" name="" placeholder="Mobile Number" class="inputField inputSmall">
        <input type="text" name="" placeholder="Name" class="inputField inputSmall">
        <select class="inputField inputSmall greytextBorder" name="" id="">
            <option value="" >Load From</option>
            <option value="" >male'</option>
        </select>
        <select class="inputField inputSmall greytextBorder " name="" id="">
            <option value="" >Un-Load To</option>
            <option value="" >L-Isdhoo</option>
        </select>
        <!-- <button type="submit" class="FormBtn inputSmall ">SAVE</button> -->
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
        </ul>  
        <p class="Summary">Total $90.00</p>
        <button type="submit" class="FormBtn inputSmall w-25 addBtn"> EDIT</button>
    </div>
        
    <div class="ContContainer">
        <h4>PAYMENT DETAILS</h4>
        <select class="inputField inputSmall greytextBorder " name="" id="">
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
    </div>

    <div class="ContContainer">
        <h4>COLLETION DETAILS</h4>
        <div class="PaymentPopup">
            <input type="text" name="" placeholder="Mobile no" class="inputField inputSmall">
            <!-- <input type="text" name="" placeholder="otp" class="inputField inputSmall"> -->
        </div>
    </div>
    <a href="/confirm.html">
    <button class="addButton SaveBtn">
        <h3>COLLECT</h3>
    </button>
    </a>
            
@endsection
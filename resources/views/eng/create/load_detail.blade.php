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
            <li class="table-row" onclick="EditItem('{{$items->id}}')">
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
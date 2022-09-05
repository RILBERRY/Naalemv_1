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
        <button type="submit" name="Submit" value="SaveCust" class="FormBtn inputSmall " onclick="saving()">SAVE</button>
    </form>

@endif

@if(Session()->has('NewCustomer'))
<form action="confirm" method="post">
@csrf
<input type="hidden" name="packageID" value="{{Session::get('newpackage')->id}}">
@endif 

    @include('eng.create.payment_detail')

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
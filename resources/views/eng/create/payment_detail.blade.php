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

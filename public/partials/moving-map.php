
<div id="address-popup" class="mfp-hide white-popup-block">
    <h3 class="heading-popup">Please Select Your Addresses</h3>
    <div class="row">
        <div class="moving-from-div">
            <input type="text" id="address_0" name="address_0" class="addresspicker columns " placeholder="MOVING FROM*"> 
            <a href="#" class="no-address no-address-0">I can&apos;t find my address</a>
        </div>
        <div class="moving-to-div">
            <input type="text" id="address_1"  name="address_1"class="addresspicker columns " placeholder="MOVING TO*">
            <a href="#" class="no-address no-address-1">I can&apos;t find my address</a>
        </div>

    </div>   
    <div class="moving-map-cls">
        <div id ="map"></div>
    </div>
    <input type="hidden" name="distance" value=""/>
    <input class="hours" type="hidden" name="time" value=""/>
    <input type="button" class="popup-submit-field" name="addresses-ok" value="Addresses Are Correct"/>
</div>
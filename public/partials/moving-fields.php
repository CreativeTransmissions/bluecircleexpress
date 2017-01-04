<div class="row"> 
    <div class="columns small-12 medium-6 bt-flabels__wrapper"> 
        <input type="text" required id="moving-from" name="moving_from" class="popup-with-form moving-from" placeholder="MOVING FROM*">
        <span class="bt-flabels__error-desc">Required Move From</span>
     </div>
    <div class="columns small-12 medium-6 bt-flabels__wrapper"> 
        <input type="text" required name="moving_to" id="moving-to"class="popup-with-form moving-to"  placeholder="MOVING TO*"><span class="bt-flabels__error-desc">Required Move To</span>
    </div>
</div>
<div class="row"> 
    <div class="columns small-12 bt-flabels__wrapper">  
        <input type="hidden"  name="delivery_date" id="delivery_date">
    	<input type="hidden"  name="delivery_time" id="delivery_time" value="<?php echo date("H:i:s")?>">
    	<input type="text" required id="collection_date" class="datepicker moving-date" placeholder="MOVING DATE*">
    	<span class="bt-flabels__error-desc">Required Move Date</span> </div>
</div>

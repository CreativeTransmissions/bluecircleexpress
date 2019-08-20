<?php 
switch ($this->show_deliver_and_return) {
		case 'Ask': ?>
        <div class="half left">

                <div class="bt-flabels__wrapper">
                    <div class="half left">
                        <div class="radio-label">
                            <label for="one_way" class="radio-placeholder radio-label">One Way</label>
                            <input type="radio" id="deliver_and_return1" name="deliver_and_return" value="0" checked="checked" />
                           <span class="checkmark"></span>
                        </div>
                    </div>
                    <div class="half right">
                        <div class="radio-label deliver-return">
                            <label for="deliver_and_return" class="radio-placeholder radio-label double-height">Deliver and Return</label>
                            <input type="radio" id="deliver_and_return2" name="deliver_and_return" value="1"/>
                            <span class="checkmark"></span>
                        </div>
                    </div>
                </div>

            <p class="radio-group-label">Deliver from collection to destination and then return to the collection address</p>			    
        </div>
<?php  	break;
		case 'Always': ?>
		<input type="hidden" id="deliver_and_return" name="deliver_and_return" value="1"/>
<?php  	break;
		case 'Never': ?>
		<input type="hidden" id="deliver_and_return" name="deliver_and_return" value="0"/>
<?php  	break;
	}; ?>
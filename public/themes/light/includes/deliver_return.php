<?php 
switch ($this->show_deliver_and_return) {
		case 'Ask': ?>
		<div class="full">
			<div class="bt-flabels__wrapper">
				<p class="radio-group-label">Deliver from collection to destination and then return to the collection address</p>
				    <input type="radio" id="deliver_and_return1" name="deliver_and_return" value="0" checked="checked" /><label for="one_way" class="radio-label" >One Way</label>
				    <input type="radio" id="deliver_and_return2" name="deliver_and_return" value="1"/><label for="deliver_and_return" class="radio-label">Deliver and Return</label>
			</div>
		</div> 
<?php  	break;
		case 'Always': ?>
		<input type="hidden" id="deliver_and_return" name="deliver_and_return" value="1"/>
<?php  	break;
		case 'Never': ?>
		<input type="hidden" id="deliver_and_return" name="deliver_and_return" value="0"/>
<?php  	break;
	}; ?>
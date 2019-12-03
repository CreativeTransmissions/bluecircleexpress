<input id="rate_hour" class="hourlyRate" type="hidden" name="rate_hour" value=""/>
<input type="hidden" name="distance" value=""/>
<input class="hours" type="hidden" name="time" value=""/>
<input type="hidden" name="return_distance" value=""/>
<input class="return_hours" type="hidden" name="return_time" value=""/>
<input class="hourCost" type="hidden" name="time_cost" value=""/>
<input class="noticeCost" type="hidden" name="notice_cost" value=""/>
<input class="distanceCost" type="hidden" name="distance_cost" value=""/>
<input class="totalCost" type="hidden" name="total" value=""/>
<input class="basicCost" type="hidden" name="basic_cost" value=""/>
<input type="hidden" name="action" value="tq_pro4_get_quote"/>
<input type="hidden" id="rate_tax" name="rate_tax" value=""/>
<input type="hidden" id="tax_cost" name="tax_cost" value=""/>
<input type="hidden" id="breakdown" name="breakdown" value=""/>
<input type="hidden" id="surcharge_areas" name="surcharge_areas" value=""/>
<input type="hidden" id="journey_type" name="journey_type" value=""/>

<?php
    $has_services = $this->has_services(); 
    $has_vehicles = $this->has_vehicles();
	if(!$has_vehicles){
		echo '<input type="hidden" name="vehicle_id" value="'.$this->single_vehicle_id.'"/>';
	};

	if(!$has_services){
		echo '<input type="hidden" name="service_id" value="'.$this->single_service_id.'"/>';
	};	
?>
<?php
	echo $message."\r\n\r\n";
	$this->job_details_list('Contact Details',$this->format_customer($this->job['customer'])); 
	$this->job_details_list('Additional Information',$this->format_job($this->job)); 
	$this->job_details_list('Collection Address',$this->format_location($this->job['location_0']));
	$this->job_details_list('Destination Address',$this->format_location($this->job['location_1']));
	$this->job_details_list('Collection Date',$this->job['job_date']);
	$this->job_details_list('Distance and Estated Travel Time',$this->format_journey($this->job['journey']));
	if(isset($this->job['quote'])){
		$this->job_details_list('Cost',$this->format_quote($this->job['quote']));
	};

?>
<?php
	echo $message."\r\n\r\n";
	$this->job_details_list('Contact Details',$this->format_customer($this->job['customer'])); 
	$this->job_details_list('Additional Information',$this->format_job($this->job)); 
	$this->job_details_list('Payment Information',$this->format_job($this->job['payment'])); 

	$this->route_details_list();
	if(isset($this->job['job_date'])){
		$this->job_details_list('Collection Date',$this->job['job_date']);	
	};

	$this->job_details_list('Distance and Travel Time',$this->format_journey($this->job['journey']));
	if(isset($this->job['quote'])){
		$this->job_details_list('Cost',$this->format_quote($this->job['quote']));
	};

?>
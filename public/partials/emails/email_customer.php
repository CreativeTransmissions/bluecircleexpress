<?php
	echo $message."\r\n\r\n";
	$this->job_details_list(self::get_setting('tq_pro_form_options','contact_section_title', 'Contact Section Title'),$this->format_customer($this->job['customer'])); 
	$this->job_details_list('Additional Information',$this->format_job($this->job)); 
	if(!empty($this->job['payment'])){
		$this->job_details_list('Payment Information',$this->job['payment']); 
	};

	$this->route_details_list();
	if(isset($this->job['job_date'])){
		$this->job_details_list('Collection Date',$this->job['job_date']);	
	};

	$this->job_details_list('Distance and Travel Time',$this->format_journey($this->job['journey']));
	if(isset($quote_data)){
		$this->job_details_list('Cost',$quote_data);
	};

?>
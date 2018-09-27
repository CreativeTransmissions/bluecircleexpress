New Job Request received

<?php 
$this->job_details_list('Customer Details',$this->format_customer($this->job['customer'])); 
$this->job_details_list('Additional Info',$this->format_job($this->job)); 

if(!empty($this->job['payment'])){
	$this->job_details_list('Payment Information',$this->job['payment']); 
};
$this->route_details_list();
if(isset($this->job['job_date'])){
	$this->job_details_list('Pick Up Date',$this->job['job_date']);
};
$this->job_details_list('Distance and Travel Time',$this->format_journey($this->job['journey']));
if(isset($this->job['quote'])){
	$this->job_details_list('Cost',$this->format_quote($this->job['quote']));
};
?>
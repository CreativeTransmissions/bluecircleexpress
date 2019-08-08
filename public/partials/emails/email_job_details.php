New Job Request received

<?php 
$this->email_renderer->render(array('header'=>'Customer Details','data'=>$customer_data)); 
$this->email_renderer->render(array('header'=>'Additional Info','data'=>$job_data)); 

if(!empty($this->job['payment'])){
	$this->email_renderer->render(array('header'=>'Payment Information','data'=>$payment_data)); 
};
$this->route_details_list();
if(isset($this->job['job_date'])){
	$this->email_renderer->render(array('header'=>'Pick Up Date','data'=>$this->job['job_date']));
};
$this->email_renderer->render(array('header'=>'Distance and Travel Time','data'=>$journey_data));
if(isset($quote_data)){
	$this->email_renderer->render(array('header'=>'Cost','data'=>$quote_data));
};
?>
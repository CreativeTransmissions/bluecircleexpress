New Job Request received

<?php 
	$this->email_renderer->render(array('header'=>'Customer Details','data'=>$customer_data)); 
	$this->email_renderer->render(array('header'=>'Additional Info','data'=>$job_data)); 

	if(!empty($this->job['payment'])){
		$this->email_renderer->render(array('header'=>'Payment Information','data'=>$payment_data)); 
	};
	$route_params = array('header'=>$this->labels['route_label'], 'labels'=>$this->labels, 'data'=>$formatted_waypoints);
	$this->route_email_renderer->render($route_params);
	if(isset($this->job['job_date'])){
		$this->email_renderer->render(array('header'=>'Pick Up Date','data'=>$this->job['job_date']));
	};
	$this->email_renderer->render(array('header'=>'Distance and Travel Time','data'=>$journey_data));
	if(isset($quote_data)){
		$this->email_renderer->render(array('header'=>'Cost','data'=>$quote_data));
	};
?>
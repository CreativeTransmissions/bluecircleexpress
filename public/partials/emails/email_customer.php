<?php
	echo $message."\r\n\r\n";
	$this->email_renderer->render(array('header'=>$this->labels['contact_details_header'],'data'=>$customer_data)); 
	$this->email_renderer->render(array('header'=>'Job Details','data'=>$job_data)); 
	if(!empty($payment_data)){
		$this->email_renderer->render(array('header'=>'Payment Information','data'=>$payment_data)); 
	};
	$route_params = array('header'=>$this->labels['route_label'], 'labels'=>$this->labels, 'data'=>$formatted_waypoints);
	$this->route_email_renderer->render($route_params);

	if(isset($this->job['job_date'])){
		$this->email_renderer->render(array('header'=>$this->labels['collection_date_label'],'data'=>$this->job['job_date']));
	};

	$this->email_renderer->render(array('header'=>'Distance and Travel Time','data'=>$journey_data));
	if(isset($quote_data)){
		$this->email_renderer->render(array('header'=>'Cost','data'=>$quote_data));
	};

?>
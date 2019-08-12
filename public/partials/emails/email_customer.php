<?php
	echo $message."\r\n\r\n";
	$this->email_renderer->render(array('header'=>$this->labels['collection_date_label'],'data'=>$customer_data)); 
	$this->email_renderer->render(array('header'=>'Additional Information','data'=>$job_data)); 
	if(!empty($payment_data)){
		$this->email_renderer->render(array('header'=>'Payment Information','data'=>$payment_data)); 
	};
	$route_params = array('header'=>$labels['route_label'], 'labels'=>$labels, 'data'=>$formatted_waypoints);
	$this->route_email_renderer->render($route_params);

	if(isset($this->job['job_date'])){
		$this->email_renderer->render(array('header'=>$this->labels['collection_date_label'],'data'=>$this->job['job_date']));
	};

	$this->email_renderer->render(array('header'=>'Distance and Travel Time','data'=>$journey_data));
	if(isset($quote_data)){
		$this->email_renderer->render(array('header'=>'Cost','data'=>$quote_data));
	};

?>
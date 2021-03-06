<div id="job_details" class="job-details">
	<div class="row">
		<?php if(!empty($this->job['customer'])){ ?>
			<div class="half job_details_customer">
				<?php $this->plugin->table_renderer->render(array('header'=>'<h3>Customer Details</h3>',
																	'data'=>$customer_data)); ?>
			</div>
			<div class="half job_details_job">
				<?php if(!empty($job_data)){
							$this->plugin->table_renderer->render(array('header'=>'<h3>Job Details</h3>',
																		'data'=>$job_data));
				} else {
					echo 'NO JOB DATA!';
				} ?>
			</div>
			<?php }; ?>
		</div>
		

	<?php if(!empty($this->job['stops'])){ ?>
		<div class="row">
			<div class="full job_details_job">
			<?php $this->plugin->route_renderer->render(array('header'=>'<h3>Route</h3>',
																		 'data'=>$formatted_waypoints)); ?>
			</div>
		</div>
	<?php }; ?> 
	<div class="row">
	<?php if(isset($this->job['job_date'])){ ?>
		<div class="third job_details_date">
			<?php $this->plugin->table_renderer->render(array('header'=>'<h3>Pick Up Date and Time</h3>',
																'data'=>$this->job['job_date'])); ?>
		</div>
		<?php }; ?>
		<?php if(!empty($journey_data)){ ?>
		<div class="third job_details_journey">
			<?php $this->plugin->table_renderer->render(array('header'=>'<h3>Distance and Travel Time</h3>',
																'data'=>$journey_data)); ?>
		</div>
		<?php }; ?>
		<?php if(isset($quote_data)){ ?>
		<div class="third job_details_quote">
			<?php 
			$this->plugin->table_renderer->render(array('header'=>'<h3>Quote</h3>',
														'data'=>$quote_data)); ?>
		</div>
		<?php }; ?>
	</div>
</div>	
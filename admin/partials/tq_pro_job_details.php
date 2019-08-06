<div id="job_details" class="job-details">
	
	<?php if(!empty($this->job['stops'])){ ?>
		<div class="row">
			<div class="full job_details_job">
			<?php $this->plugin->render_route_details($this->job['stops']); ?>
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
		<?php if(isset($this->job['journey'])){ ?>
		<div class="third job_details_journey">
			<?php $this->plugin->table_renderer->render(array('header'=>'<h3>Distance and Travel Time</h3>',
																'data'=>$this->plugin->format_journey($this->job['journey']))); ?>
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
<div class="row">
	<?php if(!empty($this->job['customer'])){ ?>
		<div class="half job_details_customer">
			<?php $this->plugin->table_renderer->render(array('header'=>'<h3>Customer Details</h3>',
																'data'=>$this->plugin->format_customer($this->job['customer']))); ?>
		</div>
		<div class="half job_details_job">
			<?php $job_data = $this->plugin->format_job($this->job);
					if(!empty($job_data)){
						$this->plugin->table_renderer->render(array('header'=>'<h3>Journey Information</h3>',
																'data'=>$this->plugin->format_job($this->job)));
			} ?>
		</div>
		<?php }; ?>
	</div>
	
</div>

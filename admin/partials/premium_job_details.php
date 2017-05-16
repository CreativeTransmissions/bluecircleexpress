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
			<?php $this->plugin->job_details_table('<h3>Pick Up Date and Time</h3>',$this->job['job_date']); ?>
		</div>
		<?php }; ?>
		<?php if(isset($this->job['journey'])){ ?>
		<div class="half job_details_journey">
			<?php $this->plugin->job_details_table('<h3>Distance and Travel Time</h3>',$this->plugin->format_journey($this->job['journey'])); ?>
		</div>
		<?php }; ?>
		<?php if(isset($this->job['quote'])){ ?>
		<div class="half job_details_quote">
			<?php $this->plugin->job_details_table('<h3>Quote</h3>',$this->plugin->format_quote($this->job['quote'])); ?>
		</div>
		<?php }; ?>
	</div>
<div class="row">
	<?php if(!empty($this->job['customer'])){ ?>
		<div class="half job_details_customer">
			<?php $this->plugin->job_details_table('<h3>Customer Details</h3>',$this->plugin->format_customer($this->job['customer'])); ?>
		</div>
		<div class="half job_details_job">
			<?php $this->plugin->job_details_table('<h3>Delivery Information</h3>',$this->plugin->format_job($this->job)); ?>
		</div>
		<?php }; ?>
	</div>
	
</div>

<?php 
    $has_services = $this->has_services(); 
    $has_vehicles = $this->has_vehicles();
    $using_service_descript = $this->using_service_descript();
    $using_vehicle_descript = $this->using_vehicle_descript();
    $using_vehicle_links = $this->using_vehicle_links();
    $using_service_links = $this->using_service_links();
    $hide_all = ''; ?>
<?php if(($has_services)&&($has_vehicles)){ ?>
<div class="tq-row">
	<div class="tq-col48">
		<div class="tq-row bt-flabels__wrapper">
			<label for="service_id">Service</label>
			<select tabindex="7" name="service_id" id="service_id">
				<?php $this->render_service_options_with_rates(); ?>
			</select>
		</div>
		<div class="tq-row bt-flabels__wrapper">
			<?php 
				if($using_service_descript || $using_service_links){
					include( "service_descriptions.php" );
				};
			?>
		</div>
	</div>
	<div class="tq-col48 right">
		<div class="tq-row bt-flabels__wrapper">
			<label for="vehicle_id">Vehicle</label>
			<select tabindex="8" name="vehicle_id" id="vehicle_id">
				<?php $this->render_vehicle_options_with_rates(); ?>
			</select>
		</div>
	</div>
	<div class="tq-col48 right">
		<div class="tq-row bt-flabels__wrapper">
			<?php 
				if($using_vehicle_descript || $using_vehicle_links){
						include( "vehicle_descriptions.php" );
				};
			?>
		</div>
	</div>		
</div>
<?php }elseif($has_services){ ?>
<div class="tq-row">
	<div class="tq-col48">
		<div class="tq-row bt-flabels__wrapper">
			<label for="service_id">Service</label>
			<select tabindex="7" name="service_id" id="service_id">
				<?php $this->render_service_options_with_rates(); ?>
			</select>
		</div>
		<div class="tq-row bt-flabels__wrapper">
			<?php 
				if($using_service_descript || $using_service_links){
						include( "service_descriptions.php" );
				};
			?>
		</div>
	</div>
</div>
<?php }elseif($has_vehicles){ ?>
	<div class="tq-row">
		<div class="tq-col48">
			<div class="tq-row bt-flabels__wrapper">
				<label for="vehicle_id">Vehicle</label>
				<select tabindex="8" name="vehicle_id" id="vehicle_id">
					<?php $this->render_vehicle_options_with_rates(); ?>
				</select>
			</div>
		</div>
		<div class="tq-col48">
			<div class="tq-row bt-flabels__wrapper">
				<?php 
					if($using_vehicle_descript || $using_vehicle_links){
						include( "vehicle_descriptions.php" );
					};
				?>
			</div>
		</div>		
	</div>
<?php } ?>
<?php 
$has_services = $this->has_services(); 
$has_vehicles = $this->has_vehicles();
$using_service_descript = $this->using_service_descript();
$using_vehicle_descript = $this->using_vehicle_descript();
$hide_all = '';
if(($has_services) && ($has_vehicles)){ ?>
	<div class="service-vehicle-wrap">
		<?php if($has_services){ ?>
		<div class="left half">
			<span class="sub_title"><i class="icon icon-icn-service"></i>Service</span>
			<div class="bt-flabels__wrapper select-wrap">
				<select tabindex="7" name="service_id" id="service_id">
				<?php $this->render_service_options_with_rates(); ?>
				</select>
			</div>
			<div class="bt-flabels__wrapper add-waypoint">
				<?php 
					if($using_service_descript || $using_service_links){
						include( "service_descriptions.php" );
					};
				?>
			</div>
		</div>
		<div class="right half">
			<span class="sub_title"><i class="icon icon-icn-vehicle"></i>Vehicle</span>
			<div class="bt-flabels__wrapper select-wrap">
				<select tabindex="8" name="vehicle_id" id="vehicle_id">
				<?php $this->render_vehicle_options_with_rates(); ?>
				</select>
			</div>
			<div class="bt-flabels__wrapper add-waypoint">
				<?php 
					if($using_vehicle_descript || $using_vehicle_links){
							include( "vehicle_descriptions.php" );
					};
				?>
			</div>
		</div>
		<?php } else { ?>
			<?php if($has_vehicles){ ?>
					<div class="left half">
						<span class="sub_title"><i class="icon icon-icn-service"></i>Vehicle</span>
						<div class="bt-flabels__wrapper select-wrap">
							<select tabindex="8" name="vehicle_id" id="vehicle_id">
								<?php $this->render_vehicle_options_with_rates(); ?>
							</select>
						</div>
						<div class="bt-flabels__wrapper add-waypoint">
							<?php 
								if($using_vehicle_descript || $using_vehicle_links){
									include( "vehicle_descriptions.php" );
								};
							?>
						</div>
					</div>
			<?php }; ?>
			<?php if($has_services){ ?>					
				<div class="left half">
					<span class="sub_title"><i class="icon icon-icn-service"></i>Service</span>
					<div class="bt-flabels__wrapper select-wrap">
						<select tabindex="7" name="service_id" id="service_id">
						<?php $this->render_service_options_with_rates(); ?>
						</select>
					</div>
					<div class="bt-flabels__wrapper add-waypoint">
						<?php 
							if($using_service_descript || $using_service_links){
								include( "service_descriptions.php" );
							};
						?>
					</div>
				</div>			
				<?php }; ?>
			<?php }; ?>
	</div>

<?php } ?>

<?php

	$vehicles = $this->cdb->get_rows('vehicles');
	$descriptions_html = '';
	$style_attribute = '';
	$link_html = '';
	$link_style_attribute = '';
	if(self::using_vehicle_descript()){
		foreach ($vehicles as $key => $vehicle) {
			if($key>0){
				$style_attribute = ' style="display: none;" ';
			};
			$descriptions_html .= '<div class="vehicle select-desc v-desc-'.$vehicle['id'].'" '.$style_attribute.'><p>'.$vehicle['description'];
			$descriptions_html .= '</p></div>';
		}
	}
	if(self::using_vehicle_links()){

		foreach ($vehicles as $key => $vehicle) {
			if($key>0){
				$link_style_attribute = ' style="display: none;" ';
			};
			$link_html .= '<div class="vehicle select-desc v-desc-'.$vehicle['id'].'" '.$link_style_attribute.'>';
			$vehicle_link = self::build_vehicle_link($vehicle);
			$link_html .= '<div class="tq-row">'.$vehicle_link.'</div>';
			$link_html .= '</div>';
		}
	}
	echo $descriptions_html.$link_html;
	
?>
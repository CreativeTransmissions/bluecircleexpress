<?php

	$services = $this->cdb->get_rows('services');
	$descriptions_html = '';
	$style_attribute = '';
	$link_html = '';
	$link_style_attribute = '';
	if(self::using_service_descript()){
	
		foreach ($services as $key => $service) {
			if($key>0){
				$style_attribute = ' style="display: none;" ';
			};
			$descriptions_html .= '<div class="service select-desc v-desc-'.$service['id'].'" '.$style_attribute.'><p>'.$service['description'];
			$descriptions_html .= '</p></div>';
		}
	}
	if(self::using_service_links()){
		$services = $this->cdb->get_rows('services');
		foreach ($services as $key => $service) {
			if($key>0){
				$link_style_attribute = ' style="display: none;" ';
			};
			$link_html .= '<div class="service select-desc v-desc-'.$service['id'].'" '.$link_style_attribute.'>';
			$service_link = self::build_service_link($service);
			$link_html .= '<div class="tq-row">'.$service_link.'</div>';
			$link_html .= '</div>';
		}
	}
	

	echo $descriptions_html.$link_html;
	
?>
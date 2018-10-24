<?php 
    foreach ($this->form_includes as $key => $template) {
        $include_path = "includes/".$template['template'].'.php';
        $hide_section = $template['hidden']; 
        include($include_path);
    };
 ?>


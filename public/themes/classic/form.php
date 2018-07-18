<?php
        $hide_section = $this->form_includes[0]['hidden'];
        include "includes/".$this->form_includes[0]['template'].'.php';
        $hide_section = $this->form_includes[1]['hidden'];
        include "includes/".$this->form_includes[1]['template'].'.php'; ?>
<div class="tq-address-container round">
<?php   $hide_section = $this->form_includes[2]['hidden']; 
        include  "includes/".$this->form_includes[2]['template'].'.php' ;
        $hide_section = $this->form_includes[3]['hidden']; 
        include "includes/".$this->form_includes[3]['template'].'.php';
        $hide_section = $this->form_includes[4]['hidden']; 
        include "includes/".$this->form_includes[4]['template'].'.php';
?>
</div>
<?php include 'includes/form-messages.php';?>
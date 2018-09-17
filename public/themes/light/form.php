    <div class="transit_inner address"> <!-- Delivery Address section start here -->
        <div class="transit_header">
            <h2><?php echo self::get_setting('tq_pro_form_options','search_section_title', 'Enter Addresses'); ?></h2>
        </div>
        <div class="transit_body">
            
            <!-- SEARCH FIELDS STARTS -->
            <?php 
                $hide_section = $this->form_includes[0]['hidden']; 
                include( "includes/".$this->form_includes[0]['template'].'.php' );  ?>
            <!-- SEARCH FIELDS STARTS -->  
           
            <!-- DELIVERY FIELDS STARTS -->
            <?php 
                $hide_section = $this->form_includes[1]['hidden']; 
                include( "includes/".$this->form_includes[1]['template'].'.php' );  ?>
            <!-- DELIVERY FIELDS STARTS -->   
             
            <!-- MAP AREA STARTS-->
            <?php 
                $hide_section = $this->form_includes[2]['hidden']; 
                include( "includes/".$this->form_includes[2]['template'].'.php' );
            ?>
            <!-- MAP AREA ENDS -->

        </div>  <!-- Delivery Address section End here -->
    </div>



<?php //quote_fields Done
    $hide_section = $this->form_includes[3]['hidden']; 
    include( "includes/".$this->form_includes[3]['template'].'.php' );
?>
<?php //customer_fields Done
    $hide_section = $this->form_includes[4]['hidden']; 
    include( "includes/".$this->form_includes[4]['template'].'.php' );
?>
<?php 
    include( "includes/form-messages.php");
?>

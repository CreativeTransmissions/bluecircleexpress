<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TransitQuote_Pro_ActivatorTest extends TestCase
{
	protected function setUp()
    {
        parent::setUp();
    }
   

    public function test_activate() {
        require_once '/srv/www/tailwind/public_html/wp-content/plugins/transitquote-pro/includes/class-tq-pro-activator.php';        
        $success = TransitQuote_Pro_Activator::activate();
        $this->assertTrue($success);
    }

 	public function test_check_db() {
        $public = new TransitQuote_Pro_Public('TransitQuote Pro', 'tq-pro','BC.4.3.1.3');

       	$has_weight_field = $public->cdb->col_exists('jobs','weight');
       	$has_ref_field = $public->cdb->col_exists('jobs','customer_reference');
        $has_job_ref_field = $public->cdb->col_exists('jobs','job_ref');
        $has_collection_date_field = $public->cdb->col_exists('journeys_locations','collection_date');
        $has_time_type_field = $public->cdb->col_exists('journeys_locations','time_type');
        $has_visit_type_field = $public->cdb->col_exists('journeys_locations','visit_type');

        $this->assertTrue($has_weight_field);
        $this->assertTrue($has_ref_field);
        $this->assertTrue($has_job_ref_field);

        $this->assertTrue($has_collection_date_field);
        $this->assertTrue($has_time_type_field);
        $this->assertTrue($has_visit_type_field);
        
        $public = null;

    }     
}
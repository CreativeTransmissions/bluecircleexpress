<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_QuoteRepositoryTest extends TestCase
{
	protected function setUp(){
	   
		parent::setUp();

		$this->test_quote_with_area_surcharge = json_decode('{"total":"219.95","total_before_rounding":207.9515,"distance":"88.49","distance_cost_before_rounding":207.9515,"distance_cost":"207.95","outward_distance":"88.49","return_distance":0,"outward_cost":207.9515,"return_cost":0,"basic_cost":219.95,"stop_cost":0,"breakdown":[{"distance":0,"distance_cost":0,"type":"set amount","rate":"0.00","cost":"0.00"},{"distance":88.49,"distance_cost":207.9515,"type":"per distance unit","rate":"2.35","cost":207.9515},{"distance":0,"distance_cost":207.9515,"type":"per distance unit","rate":"2.35","return_percentage":"100","cost":0}],"rate_hour":"0.00","time_cost":0,"rate_tax":"0","tax_cost":"0.00","job_rate":"standard","weight_cost":0,"congestion_charge":"12.00","area_surcharges_cost":12,"tax_name":"","tax_rate":"0","subtotal":"219.95","total_cost":219.95}',true);

        $this->test_surcharge_area_data = json_decode('[{"surcharge_id":"1","amount":"12.00"}]', true);

        $this->cdb = TransitQuote_Pro4::get_custom_db();
        $repo_config = array('cdb' => $this->cdb, 'debugging' =>true);
        $this->quote_repo = new TQ_QuoteRepository($repo_config);        
    
    }

    protected function tearDown(){
         $this->cdb  = null;
         $this->quote_repo = null;
    }
    
    public function test_save_quote(){

        $quote = $this->quote_repo->save($this->test_quote_with_area_surcharge);
        $this->assertTrue(is_array($quote));
        $this->assertTrue(is_numeric($quote['id']));

        $quote_surcharge_ids = $this->quote_repo->save_quote_surcharges($this->test_surcharge_area_data);
        $this->assertTrue(is_array($quote_surcharge_ids));
        $this->assertTrue(is_numeric($quote_surcharge_ids[0]));
    }
}    

?>
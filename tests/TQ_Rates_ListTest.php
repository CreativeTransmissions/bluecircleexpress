<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class TQ_Rates_ListTest extends TestCase
{
	protected function setUp()
    {
        parent::setUp();

      
    }
   

    public function test_render_view() {

 		$this->rates_list = new TransitQuote_Pro4\TQ_Rates_List(array('cdb'=> TransitQuote_Pro4::get_custom_db(),
            'debug' => true,
            'tax_rate' => 20,
            'range_start' => 0,
            'range_end' => 200,
            'step' => 20,
            'view_path'=>'/srv/www/wordpress-one/public_html/wp-content/plugins/transitquote-pro/public/partials/tq-pro-rates-list.php'
        ));  

		$rates_view = $this->rates_list->render_view();

		$this->assertEquals(is_string($rates_view), true);

    }
}
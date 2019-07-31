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
        require_once '/srv/www/wordpress-one/public_html/wp-content/plugins/transitquote-pro/includes/class-tq-pro-activator.php';        
        $success = TransitQuote_Pro_Activator::activate();
        $this->assertTrue($success);
    }
}
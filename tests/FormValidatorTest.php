<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class FormValidatorTest extends TestCase
{
	protected function setUp()
    {
        parent::setUp();
        $_POST = array();
        $_GET = array();

        $this->test_field_defs = array('first_name'=>
                    array('name'=>'first_name',
                            'max_length'=>45,
                            'required'=>true,
                            'label'=>'First Name'
                            ),
                    'last_name'=>
                    array(  'name'=>'last_name',
                            'max_length'=>45,
                            'required'=>true,
                            'label'=>'Last Name'
                            ),
                     'email'=>
                    array('name'=>'email',
                            'max_length'=>128,
                            'required'=>true,
                            'label'=>'Email'
                            ),
                     'phone'=>
                    array('name'=>'phone',
                            'max_length'=>45,
                            'required'=>true,
                            'label'=>'Phone'
                            ),
                     'address_0'=>
                    array('name'=>'address_0',
                            'max_length'=>1000,
                            'required'=>true,
                            'label'=>'Moving From Address'
                            ),
                     'flat_number_0'=>
                    array('name'=>'flat_number_0',
                            'max_length'=>20,
                            'label'=>'Moving From Flat Number'
                            ),
                     'street_number_0'=>
                    array('name'=>'street_number_0',
                            'max_length'=>20,
                            'label'=>'Moving From Street Number'
                            ),
                     'route_0'=>
                    array('name'=>'route_0',
                            'max_length'=>128,
                            'label'=>'Moving From Address'
                            ),
                     'administrative_area_level_2_0'=>
                    array('name'=>'administrative_area_level_2_0',
                            'max_length'=>128,
                            'label'=>'Moving From Address'
                            ),
                     'administrative_area_level_1_0'=>
                    array('name'=>'administrative_area_level_1_0',
                            'max_length'=>128,
                            'label'=>'Moving From Address'
                            ),
                     'country_0'=>
                    array('name'=>'country_0',
                            'max_length'=>128,
                            'label'=>'Moving From Country'
                            ),
                     'postal_code_0'=>
                    array('name'=>'postal_code_0',
                            'max_length'=>16,
                            'label'=>'Moving From Postal Code'
                            ),
                     'lat_0'=>
                    array('name'=>'lat_0',
                            'max_length'=>14,
                            'label'=>'Moving From Location'
                            ),
                     'lng_0'=>
                    array('name'=>'lng_0',
                            'max_length'=>14,
                            'label'=>'Moving From Location'
                            ),
                    'address_1_address'=>
                    array('name'=>'address_1_address',
                            'max_length'=>1000,
                            'required'=>true,
                            'label'=>'Moving To Address'
                            ),
                     'flat_number_1'=>
                    array('name'=>'flat_number_1',
                            'flat_number'=>20,
                            'label'=>'Moving To Flat Number'
                            ),
                     'street_number_1'=>
                    array('name'=>'street_number_1',
                            'max_length'=>20,
                            'label'=>'Moving To Street Number'
                            ),
                     'route_1'=>
                    array('name'=>'route_1',
                            'max_length'=>128,
                            'label'=>'Moving To Address'
                            ),
                     'administrative_area_level_2_1'=>
                    array('name'=>'administrative_area_level_2_1',
                            'max_length'=>128,
                            'label'=>'Moving To Address'
                            ),
                     'administrative_area_level_1_1'=>
                    array('name'=>'administrative_area_level_1_1',
                            'max_length'=>128,
                            'label'=>'Moving To Address'
                            ),
                     'country_1'=>
                    array('name'=>'country_1',
                            'max_length'=>128,
                            'label'=>'Moving To Country'
                            ),
                     'postal_code_1'=>
                    array('name'=>'postal_code_1',
                            'max_length'=>16,
                            'label'=>'Moving To Postal Code'
                            ),
                     'lat_1'=>
                    array('name'=>'lat_1',
                            'max_length'=>14,
                            'label'=>'Moving To Location'
                            ),
                     'lng_1'=>
                    array('name'=>'lng_1',
                            'max_length'=>14,
                            'label'=>'Moving To Location'
                            )
                );
        
    $this->test_good_values = array('first_name'=>'Andrew',
                                    'last_name'=>'van Duivenbode',
                                    'email'=>'andrew@creataivetransmissions.com',
                                    'phone'=>1234234234234,
                                    'address_0_address'=>'123 Victoria Street, London, UK',
                                    'address_0_flat_number'=>'1a',
                                    'address_0_street_number'=>123,
                                    'address_0_route'=>'Victoria Street',
                                    'address_0_postal_town'=>'London',
                                    'address_0_administrative_area_level_1'=>'England',
                                    'address_0_administrative_area_level_2'=>'Greater London',
                                    'address_0_country'=>'United Kingdom',
                                    'address_0_postal_code'=>'SW1E 5NT',
                                    'address_0_lat'=>'51.4969335',
                                    'address_0_lng'=>'-0.13801509999996142',
                                    'address_1_address'=>'123 Victoria Street, London, UK',
                                    'address_1_flat_number'=>'1a',
                                    'address_1_street_number'=>123,
                                    'address_1_route'=>'Victoria Street',
                                    'address_1_postal_town'=>'London',
                                    'address_1_administrative_area_level_1'=>'England',
                                    'address_1_administrative_area_level_2'=>'Greater London',
                                    'address_1_country'=>'United Kingdom',
                                    'address_1_postal_code'=>'SW1E 5NT',
                                    'address_1_lat'=>51.4969335,
                                    'address_1_lng'=>-0.13801509999996142   
                            );

    $this->test_bad_values = array('first_name'=>'Andrew LonglonglongLonglonglongLonglLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglong name',
                                    'last_name'=>'vanLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglong Duivenbode',
                                    'email'=>'',
                                    'phone'=>'12342LonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglongLonglonglong34234234',
                                    'address_0_address'=>'123 Victoria Street, London, UK',
                                    'address_0_flat_number'=>'1a',
                                    'address_0_street_number'=>123,
                                    'address_0_route'=>'Victoria Street',
                                    'address_0_postal_town'=>'London',
                                    'address_0_administrative_area_level_1'=>'England',
                                    'address_0_administrative_area_level_2'=>'Greater London',
                                    'address_0_country'=>'United Kingdom',
                                    'address_0_postal_code'=>'SW1E 5NT'
                            );

                    
    }
  
	public function testHasEmptyFieldsPropertyy() {
        $validator = new TransitQuote_Pro4\TQ_FormValidator();

    	$this->assertClassHasAttribute ('empty_fields', 'TransitQuote_Pro4\TQ_FormValidator');
    }

	public function testHasMissingFieldsProperty() {
        $validator = new TransitQuote_Pro4\TQ_FormValidator();

    	$this->assertClassHasAttribute ('missing_fields', 'TransitQuote_Pro4\TQ_FormValidator');
    }

	public function testHasInvalidFieldsProperty() {
        $validator = new TransitQuote_Pro4\TQ_FormValidator();

    	$this->assertClassHasAttribute ('invalid_fields', 'TransitQuote_Pro4\TQ_FormValidator');
    }

	public function testReceivesPostData() {
		$_POST = array('job_id'=>10);
        $validator = new TransitQuote_Pro4\TQ_FormValidator();

    	$this->assertCount (1,$validator->post_data);
    }

	public function testReceivesGetData() {
		$_GET = array('job_id'=>10);
        $validator = new TransitQuote_Pro4\TQ_FormValidator();

    	$this->assertCount (1,$validator->get_data);
    }

	public function testAssignsRequiredFieldsIsArray() {
		
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs));
        $this->assertInternalType('array',$validator->get_required_fields(), 'testAssignsRequiredFieldsIsArray');
    }

	public function testHasGetField() {
		$_GET = $this->test_good_values;
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs));
    	$this->assertTrue($validator->has_get_field('address_0_address'));
    }

	public function testHasGetFieldError() {
        $_GET = $this->test_bad_values;
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs));
    	$this->assertFalse($validator->has_get_field('job_id'));
    }

     public function testHasPostField() {
		$_POST = array('job_id'=>10);
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs));
    	$this->assertTrue($validator->has_post_field('job_id'));
    } 

    public function testHasPostFieldError() {
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs));
    	$this->assertFalse($validator->has_post_field('job_id'), 'has post field returns false when field missing');
    }

	public function testPostFieldHasValue() {
    	$_POST = array('job_id'=>'10');
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs));
    	$this->assertTrue($validator->post_field_has_value('job_id'), 'post_field_has_value returns true when field is not empty');
    }


	public function testPostFieldHasValueError() {
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs));
    	$this->assertFalse($validator->post_field_has_value('job_id'), 'post_field_has_value returns false when field is empty');
    }

    public function testHasRequiredGetFields() {
    	$_GET = $this->test_good_values;
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs));
    	$this->assertTrue($validator->has_required_get_fields(), 'testHasRequiredGetFields: has_required_get_fields returns true when all fields present');
    }

    public function testHasRequiredGetFieldsError() {
    	$_GET = $this->test_bad_values;
        $required_fields = array('first_name', 'last_name', 'email', 'address_0_address','address_0_lat','address_0_lng','address_1_address','address_1_lat','address_1_lng');
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs,
                                                                'required_fields'=> $required_fields));
    	$this->assertFalse($validator->has_required_get_fields(), 'has_required_get_fields returns false when at least one field missing');
    }

    public function testHasRequiredPostFields() {
    	$_POST = $this->test_good_values;
        $required_fields = array('first_name', 'last_name', 'email', 'address_0_address','address_0_lat','address_0_lng','address_1_address','address_1_lat','address_1_lng');

        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs,
                                                                'required_fields'=> $required_fields));        
    	$this->assertTrue($validator->has_required_post_fields(), 'has_required_post_fields returns true when all fields present');
    }

    public function testErrorHasRequiredPostFields() {
    	$_POST = $this->test_bad_values;
        $required_fields = array('first_name', 'last_name', 'email', 'address_0_address','address_0_lat','address_0_lng','address_1_address','address_1_lat','address_1_lng');
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs,
                                                                'required_fields'=> $required_fields)); 
    	$this->assertFalse($validator->has_required_post_fields(), 'testHasRequiredPostFieldsError: has_required_post_fields returns false when at least one field missing');
    }

    public function testPostFieldLengthIsValid() {
        $_POST = $this->test_good_values;
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs));
        $this->assertTrue($validator->post_field_length_is_valid('first_name'), 'has_required_post_fields returns true when all fields present');
    }

    public function testErrorPostFieldLengthIsValid() {
        $_POST = $this->test_bad_values;
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs));
        $this->assertFalse($validator->post_field_length_is_valid('first_name'), 'has_required_post_fields returns true when all fields present');
    }


    public function testMissingPostFieldErrorMessages() {
        $_POST = $this->test_bad_values;
        $required_fields = array('first_name', 'last_name', 'email', 'address_0_address','address_0_lat','address_0_lng','address_1_address','address_1_lat','address_1_lng');
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs,
                                                                'required_fields'=> $required_fields));        
        $this->assertFalse($validator->has_required_post_fields(), 'testGetMissingFieldErrorMessages: has_required_get_fields returns false when at least one field missing');
        $example_error_array = array('name'=>'address_0_lat',
                                'error'=>'Missing');

        $error_messages  = $validator->get_missing_field_error_messages();
        $this->assertContains($example_error_array,$error_messages, 'get_missing_field_error_messages contains error message for missing field');
       

    }

    public function testGetInvalidFieldErrorMessages() {
        $_GET = $this->test_bad_values;
        $required_fields = array('first_name', 'last_name', 'email', 'address_0_address','address_0_lat','address_0_lng','address_1_address','address_1_lat','address_1_lng');
        $validator = new TransitQuote_Pro4\TQ_FormValidator(array('fields'=>$this->test_field_defs,
                                                                'required_fields'=> $required_fields)); 
        $this->assertFalse($validator->has_required_get_fields(), 'testGetInvalidFieldErrorMessages: has_required_get_fields returns false when at least one field invalid');
        $example_error_array = array('name'=>'address_0_lat',
                                    'error'=>'Missing');
        $error_messages = $validator->get_missing_field_error_messages();
        print_r($error_messages);
        $this->assertContains($example_error_array, $error_messages, 'testGetInvalidFieldErrorMessages:  get_invalid_field_error_messages contains error message for invalid field');


    }      
}
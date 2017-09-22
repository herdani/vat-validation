<?php

use SoapClient;

class vatValidation
{
	const WSDL = "http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl";
	private $_client = null;

	private $_options  = array(
						'debug' => false,
						);	
	
	private $_valid = false;
	private $_data = array();
	
	public function __construct($options = array()) {
		
		foreach($options as $option => $value) {
			$this->_options[$option] = $value;
		}
		
		if(!class_exists('SoapClient')) {
			throw new Exception('The Soap library has to be installed and enabled');
		}
				
		try {
			$this->_client = new SoapClient(self::WSDL, array('trace' => true) );
		} catch(Exception $e) {
			$this->trace('Vat Translation Error', $e->getMessage());
		}
	}

	public function check($countryCode, $vatNumber) {

		$rs = $this->_client->checkVat( array('countryCode' => $countryCode, 'vatNumber' => $vatNumber) );

		if($this->isDebug()) {
			$this->trace('Web Service result', $this->_client->__getLastResponse());	
		}

		if($rs->valid) {
			$this->_valid = true;
			$name_arr = explode(" ", $rs->name, 2);
			if (count($name_arr) > 1) {
				list($denomination,$name) = $name_arr;
			} else {
				$denomination = $name_arr[0];
				$name = "";
			}
			$this->_data = array(
									'denomination' => 	$denomination, 
									'name' => 			$this->cleanUpString($name), 
									'address' => 		$this->cleanUpString($rs->address),
								);
			return true;
		} else {
			$this->_valid = false;
			$this->_data = array();
		    return false;
		}
	}

	public function isValid() {
		return $this->_valid;
	}
	
	public function getDenomination() {
		return $this->_data['denomination'];
	}
	
	public function getName() {
		return $this->_data['name'];
	}
	
	public function getAddress() {
		return $this->_data['address'];
	}
	
	public function isDebug() {
		return ($this->_options['debug'] === true);
	}
	private function trace($title,$body) {
		echo '<h2>TRACE: '.$title.'</h2><pre>'. htmlentities($body).'</pre>';
	}
	private function cleanUpString($string) {
        for($i=0;$i<100;$i++)
        {               
            $newString = str_replace("  "," ",$string);
            if($newString === $string) {
            	break;
            } else {
            	$string = $newString;
			}
        }
                        
        $newString = "";
        $words = explode(" ",$string);
        foreach($words as $k=>$w)
        {                       
           	$newString .= ucfirst(strtolower($w))." "; 
        }                
        return $newString;
	}
}

?>

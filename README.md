# Vat Validation #

## About ##
Vat-Validation is a PHP class allowing you to

- Validate a VAT number
- Retrieve information like the name or the address of the company

The data is extracted from a European Commission webservice

__It actually only works for European countries__

## Usage ##

	require_once('vatValidation.class.php');
	$vatValidation = new vatValidation( array('debug' => false));
	$vatValidation->check($countryCode, $vatNumber));

Your instance can now access the following methods:

	$vatValidation->isValid()
	$vatValidation->getName()
	$vatValidation->getDenomination()
	$vatValidation->getAddress() 

You'll find an example in the example.php file

## Requirements ##

PHP with Soap enabled

## Disclaimer ##

Take a look at http://ec.europa.eu/taxation_customs/vies/viesdisc.do to know when/how you're allowed to use this service and his information
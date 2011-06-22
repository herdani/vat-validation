<?php
require_once('vatValidation.class.php');
$vatValidation = new vatValidation( array('debug' => false));


if($vatValidation->check('BE', '0828639227')) {
	echo '<h1>valid one!</h1>';
	echo 'denomination: ' . $vatValidation->getDenomination(). '<br/>';
	echo 'name: ' . $vatValidation->getName(). '<br/>';
	echo 'address: ' . $vatValidation->getAddress(). '<br/>';
} else {
	echo '<h1>Invalid VAT</h1>';
}

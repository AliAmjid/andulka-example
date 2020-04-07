<?php


namespace App\Model\Exceptions;


use Throwable;

class InvalidCustomerTypeException extends \InvalidArgumentException {
	public function __construct($expectedType, $code = 0, Throwable $previous = null) {
		parent::__construct("Expected customer of type: $expectedType.", $code, $previous);
	}
}
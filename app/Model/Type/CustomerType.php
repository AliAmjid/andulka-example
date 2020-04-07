<?php

namespace App\Model\Type;

class CustomerType {
	const SUPPLIER = 'SUPPLIER';
	const SUBSCRIBER = 'SUBSCRIBER';

	public static $translate = [
		self::SUPPLIER => 'Dodavatel',
		self::SUBSCRIBER => 'Odběratel'
	];

}
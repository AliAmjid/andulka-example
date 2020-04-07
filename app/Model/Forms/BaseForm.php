<?php


namespace App\Model\Forms;


use Nette\Application\UI\Form;

abstract class BaseForm extends Form {
	public function create(): BaseForm {
		$this->define();
		return $this;
	}

	abstract function define();

	abstract function save();
}
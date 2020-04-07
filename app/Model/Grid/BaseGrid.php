<?php


namespace App\Model\Grid;


use Doctrine\ORM\QueryBuilder;
use Nette\ComponentModel\IContainer;
use Ublaboo\DataGrid\DataGrid;

abstract class BaseGrid {
	private $name;

	public function __construct(string $name) {
		$this->name = $name;
	}

	public function create(IContainer $presenter): DataGrid {
		$grid = new DataGrid($presenter, $this->name);
		$grid->perPage = 100;
		$grid->setDataSource($this->defineDataSource());
		$this->define($grid);
		return $grid;
	}

	abstract function defineDataSource(): QueryBuilder;

	abstract function define(DataGrid $grid);
}
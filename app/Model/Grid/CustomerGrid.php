<?php


namespace App\Model\Grid;


use App\Model\Entity\Customer;
use App\Model\Type\CustomerType;
use Doctrine\ORM\QueryBuilder;
use Nette\ComponentModel\IContainer;
use Nettrine\ORM\EntityManagerDecorator;
use Ublaboo\DataGrid\DataGrid;

class CustomerGrid extends BaseGrid {
	/** @var EntityManagerDecorator */
	private $em;

	/**
	 * CustomerGrid constructor.
	 * @param EntityManagerDecorator $em
	 */
	public function __construct(EntityManagerDecorator $em) {
		$this->em = $em;
		parent::__construct('customerGrid');
	}


	public function defineDataSource(): QueryBuilder {
		return $this->em->createQueryBuilder()
			->select('customer')
			->from(Customer::class, 'customer');

	}

	public function define(DataGrid $grid) {
		$grid->addColumnText('name', 'Jméno')
			->setFilterText();

		$grid->addColumnText('city', 'Město')
			->setFilterText();

		$grid->addColumnText('street', 'Ulice')
			->setFilterText();

		$typeColumn = $grid->addColumnText('type', 'Typ zákazníka');
		$typeColumn->setRenderer(function (Customer $customer) {
			return CustomerType::$translate[$customer->getType()];
		});

		$typeColumn->setFilterSelect(CustomerType::$translate)
			->setPrompt('Vše');

		$grid->addAction('show', 'Zobrazit', 'showCustomer');
	}
}
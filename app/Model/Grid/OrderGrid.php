<?php


namespace App\Model\Grid;


use App\Model\Entity\Customer;
use App\Model\Entity\Order;
use Doctrine\ORM\QueryBuilder;
use Nettrine\ORM\EntityManagerDecorator;
use Ublaboo\DataGrid\DataGrid;

class OrderGrid extends BaseGrid {

	/** @var EntityManagerDecorator */
	private $em;

	/**
	 * OrderGrid constructor.
	 * @param EntityManagerDecorator $em
	 */
	public function __construct(EntityManagerDecorator $em) {
		$this->em = $em;
		parent::__construct('orderGrid');
	}


	public function defineDataSource(): QueryBuilder {
		return $this->em->createQueryBuilder()
			->select('o')
			->from(Order::class, 'o')
			->leftJoin('o.supplier', 'supplier')
			->leftJoin('o.subscriber', 'subscriber');
	}

	public function define(DataGrid $grid) {
		$grid->addColumnText('id', 'Číslo')
			->setFilterText();

		$grid->addColumnText('supplier', 'Dodavatel', 'supplier.name')
			->setFilterText();

		$grid->addColumnText('subscriber', 'Odběratel', 'subscriber.name')
			->setFilterText();

		$grid->addAction('show', 'Zobrazit', 'showOrder');
	}

}
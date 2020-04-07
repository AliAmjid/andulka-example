<?php

namespace App\Model\Service;

use App\Model\Entity\Customer;
use Defr\Ares;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityRepository;
use Nettrine\ORM\EntityManagerDecorator;

class CustomerService {
	/** @var Ares $ares */
	private $ares;
	private $em;
	/** @var EntityRepository */
	private $customerRepository;

	public function __construct(
		Ares $ares,
		EntityManagerDecorator $em) {
		$this->ares = $ares;
		$this->em = $em;
		$this->customerRepository = $em->getRepository(Customer::class);
	}

	public function register($ico, string $type): Customer {
		//load data from ares
		$record = $this->ares->findByIdentificationNumber($ico);

		//Map AresRecord on customer entity & save it to database
		$customer = new Customer();
		$customer->setName($record->getCompanyName());
		$customer->setStreet($record->getStreetWithNumbers());
		$customer->setCity($record->getTown());
		$customer->setZip($record->getZip());
		$customer->setType($type);
		$customer->setIco($ico);
		$this->em->persist($customer);
		$this->em->flush();

		return $this->em->find(Customer::class, $customer->getId());
	}

	public function registerOrGetCustomer(string $ico, string $type): Customer {
		$supplier = $this->customerRepository->findOneBy(['ico' => (string)$ico]);
		if ($supplier) {
			return $supplier;
		} else {
			return $this->register($ico, $type);
		}
	}
}
<?php


namespace App\Model\Entity;


use App\Model\Exceptions\InvalidCustomerTypeException;
use App\Model\Type\CustomerType;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity()
 * @ORM\Table(name="`order`")
 */
class Order {

	use Tid;

	/** @var int
	 * @ORM\Column()
	 */
	private $price;

	/**
	 * @var Customer
	 * @ORM\ManyToOne(targetEntity="Customer")
	 */
	private $subscriber;

	/**
	 * @var Customer
	 * @ORM\ManyToOne(targetEntity="Customer")
	 */
	private $supplier;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;


	public function __construct() {
		$this->createdAt = new \DateTime();
	}

	/**
	 * @return mixed
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @param mixed $price
	 */
	public function setPrice($price): void {
		$this->price = $price;
	}

	/**
	 * @return Customer
	 */
	public function getSubscriber(): Customer {
		return $this->subscriber;
	}

	/**
	 * @return Customer
	 */
	public function getSupplier(): Customer {
		return $this->supplier;
	}

	/**
	 * @param Customer $subscriber
	 */
	public function setSubscriber(Customer $subscriber): void {
		if ($subscriber->getType() !== CustomerType::SUBSCRIBER) {
			throw new InvalidCustomerTypeException(CustomerType::SUBSCRIBER);
		}
		$this->subscriber = $subscriber;
	}

	public function setSupplier(Customer $customer) {
		if ($customer->getType() !== CustomerType::SUPPLIER) {
			throw new InvalidCustomerTypeException(CustomerType::SUPPLIER);
		}
		$this->supplier = $customer;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime {
		return $this->createdAt;
	}

	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt(\DateTime $createdAt): void {
		$this->createdAt = $createdAt;
	}


}
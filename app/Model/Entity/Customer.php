<?php

namespace App\Model\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity()
 */
class Customer {

	use Tid;

	/**
	 * @var int
	 * @ORM\Column(type="string",unique=true)
	 */
	private $ico;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $street;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $city;
	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $zip;

	/** @var string
	 * @ORM\Column(type="string")
	 */
	private $type;

	/**
	 * @var PersistentCollection
	 * @ORM\OneToMany(targetEntity="Order",mappedBy="supplier")
	 */
	private $supplies;

	/**
	 * @var PersistentCollection
	 * @ORM\OneToMany(targetEntity="Order",mappedBy="subscriber")
	 */
	private $orders;

	/**
	 * @return int
	 */
	public function getIco(): int {
		return $this->ico;
	}

	/**
	 * @param int $ico
	 */
	public function setIco(int $ico) {
		$this->ico = $ico;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getAddress(): string {
		return "{$this->street} {$this->city} {$this->zip}";
	}


	/**
	 * @return string
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType(string $type): void {
		$this->type = $type;
	}

	/**
	 * @return PersistentCollection
	 */
	public function getSupplies(): PersistentCollection {
		return $this->supplies;
	}

	/**
	 * @param PersistentCollection $supplies
	 */
	public function setSupplies(PersistentCollection $supplies): void {
		$this->supplies = $supplies;
	}

	/**
	 * @return PersistentCollection
	 */
	public function getOrders(): PersistentCollection {
		return $this->orders;
	}

	/**
	 * @param PersistentCollection $orders
	 */
	public function setOrders(PersistentCollection $orders): void {
		$this->orders = $orders;
	}

	/**
	 * @return string
	 */
	public function getStreet(): string {
		return $this->street;
	}

	/**
	 * @param string $street
	 */
	public function setStreet(string $street): void {
		$this->street = $street;
	}

	/**
	 * @return string
	 */
	public function getCity(): string {
		return $this->city;
	}

	/**
	 * @param string $city
	 */
	public function setCity(string $city): void {
		$this->city = $city;
	}

	/**
	 * @return string
	 */
	public function getZip(): string {
		return $this->zip;
	}

	/**
	 * @param string $zip
	 */
	public function setZip(string $zip): void {
		$this->zip = $zip;
	}

}
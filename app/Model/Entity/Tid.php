<?php


namespace App\Model\Entity;


use Doctrine\ORM\Mapping as ORM;

trait Tid {


	/**
	 * @var int|null
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", options={"unsigned": true})
	 */
	private $id;

	/**
	 * @return int
	 * @Field(outputType="ID")
	 */
	public function getId(): int {
		return $this->id ?? 0;
	}

	/**
	 * @param string $id
	 *
	 */
	public function setId(string $id): void {
		$this->id = $id;
	}

	public function __toString() {
		return $this->id;
	}

}
<?php


namespace App\Model\Service;


use App\Model\Entity\Customer;
use App\Model\Entity\Order;
use Contributte\Invoice\Data\Account;
use Contributte\Invoice\Data\Company;
use Contributte\Invoice\Data\PaymentInformation;
use Contributte\Invoice\Invoice;
use Contributte\Invoice\Templates\DefaultTemplate;
use Contributte\Invoice\Translator;
use Nette\Http\IResponse;
use Nettrine\ORM\EntityManagerDecorator;

class OrderService {

	/** @var EntityManagerDecorator $em */
	private $em;

	/**
	 * OrderService constructor.
	 * @param EntityManagerDecorator $entityManager
	 */
	public function __construct(EntityManagerDecorator $entityManager) {
		$this->em = $entityManager;
	}

	public function createOrder(Customer $supplier, Customer $subscriber, int $price): Order {
		$order = new Order();
		$order->setSupplier($supplier);
		$order->setSubscriber($subscriber);
		$order->setPrice($price);
		$this->em->persist($order);
		$this->em->flush();
		$this->em->clear(Order::class);

		return $this->em->find(Order::class, $order->getId());
	}


	public function generateInvoice(Order $order): \Nette\Application\IResponse {
		$company = new Company(
			$order->getSupplier()->getName(),
			$order->getSupplier()->getCity(),
			$order->getSupplier()->getStreet(),
			$order->getSupplier()->getZip(),
			'CZ',
			$order->getSupplier()->getIco()
		);

		$customer = new \Contributte\Invoice\Data\Customer(
			$order->getSubscriber()->getName(),
			$order->getSubscriber()->getCity(),
			$order->getSubscriber()->getStreet(),
			$order->getSubscriber()->getZip(),
			'CZ', $order->getSubscriber()->getIco()
		);

		$account = new Account('1111', 'CZ4808000000002353462015', 'GIGACZPX');
		$payment = new PaymentInformation('Kč', $order->getId(), '1234', 0.21);
		$invoiceOrder = new \Contributte\Invoice\Data\Order($order->getId(), new \DateTime('+ 14 days'), $account, $payment);

		$invoiceOrder->addItem('Úklidové služby', $order->getPrice());
		$invoice = new Invoice($company, new DefaultTemplate(new Translator(Translator::CZECH)));

		return $invoice->createResponse($customer, $invoiceOrder);
	}
}
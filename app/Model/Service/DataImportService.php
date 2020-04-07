<?php


namespace App\Model\Service;


use App\Model\Entity\Customer;
use App\Model\Entity\Order;
use App\Model\Type\CustomerType;
use Asan\PHPExcel\Excel;
use Asan\PHPExcel\Reader\Xlsx;
use Defr\Ares\AresException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityRepository;
use Nette\Http\FileUpload;
use Nettrine\ORM\EntityManagerDecorator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use function GuzzleHttp\Psr7\str;

class DataImportService {

	/** @var EntityManagerDecorator */
	private $em;

	/** @var CustomerService */
	private $customerService;

	/** @var EntityRepository */
	private $customerRepository;

	/** @var OrderService */
	private $orderService;

	/**
	 * DataImportService constructor.
	 * @param EntityManagerDecorator $em
	 * @param CustomerService $customerService
	 * @param OrderService $orderService
	 */
	public function __construct(
		EntityManagerDecorator $em,
		CustomerService $customerService,
		OrderService $orderService) {
		$this->em = $em;
		$this->customerService = $customerService;
		$this->customerRepository = $em->getRepository(Customer::class);
		$this->orderService = $orderService;
	}


	/**
	 * @return string[] of errors
	 * @throws \Asan\PHPExcel\Exception\ReaderException
	 */
	public function importData(FileUpload $file): array {
		$errors = [];

		$reader = Excel::load($file->getTemporaryFile(), function (Xlsx $reader) {
			$reader->setColumnLimit(3);
			$reader->ignoreEmptyRow(true);
		}, null, 'xlsx');

		//Iterating the rows from xlsx
		for ($i = 0; $i < $reader->count(); $i++) {
			if ($i == 0) {
				$reader->next();
				continue; //Skip 1st row
			}

			$data = $reader->current();
			try {
				$this->createOrderFromRowData((string)$data[1], (string)$data[0], (int)$data[2]);
			} catch (AresException $e) {
				$errors[] = "Chyba při vytváření objednávky pro ičo:{$data[0]} a {$data[1]} (řádek {$i} v souboru) - chyba: " . $e->getMessage();
			}
			$reader->next();
		}
		$this->em->flush();
		return $errors;
	}

	private function createOrderFromRowData($icoSupplier, $icoSubscriber, int $orderPrice) {
		$supplier = $this->customerService->registerOrGetCustomer($icoSupplier, CustomerType::SUPPLIER);
		$subscriber = $this->customerService->registerOrGetCustomer($icoSubscriber, CustomerType::SUBSCRIBER);
		$this->orderService->createOrder($supplier, $subscriber, $orderPrice);
	}
}
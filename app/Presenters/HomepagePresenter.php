<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\Entity\Customer;
use App\Model\Entity\Order;
use App\Model\Forms\DataImportForm;
use App\Model\Grid\CustomerGrid;
use App\Model\Grid\OrderGrid;
use App\Model\Service\OrderService;
use Nette;
use Nettrine\ORM\EntityManagerDecorator;


final class HomepagePresenter extends Nette\Application\UI\Presenter {

	/** @var DataImportForm @inject */
	public $dataImportForm;

	/** @var CustomerGrid @inject */
	public $customerGrid;

	/** @var EntityManagerDecorator @inject */
	public $em;

	/** @var OrderService @inject */
	public $orderService;

	/** @var OrderGrid @inject */
	public $orderGrid;

	/** Actions */

	public function actionShowCustomer($id) {
		$customer = $this->em->find(Customer::class, $id);
		if (!$customer) {
			$this->flashMessage('Zákazník neexstuje', 'danger');
			$this->redirect('Homepage:');
		}
		$this->template->customer = $customer;
	}

	public function actionShowOrder($id) {
		$order = $this->em->find(Order::class, $id);
		if (!$order) {
			$this->flashMessage('Objedávka neexstuje', 'danger');
			$this->redirect('Homepage:');
		}
		$this->template->order = $order;
	}

	public function actionGenerateOrderInvoice($id) {
		$order = $this->em->find(Order::class, $id);
		if (!$order) {
			$this->flashMessage('Objedávka neexstuje', 'danger');
			$this->redirect('Homepage:');
		}
		$this->sendResponse($this->orderService->generateInvoice($order));
	}


	/** Components */

	public function createComponentDataImportForm() {
		$form = $this->dataImportForm->create();
		$form->onSubmit[] = [$this, 'dataImportFormOnSubmit'];
		return $form;
	}

	public function dataImportFormOnSubmit(DataImportForm $form) {
		try {
			$form->save();
		} catch (\Throwable $e) {
			throw $e;
			$this->flashMessage($e->getMessage(), 'danger');
		}

		foreach ($form->errors as $error) {
			$this->flashMessage($error, 'danger');
		}
	}

	public function createComponentCustomerGrid() {
		return $this->customerGrid->create($this);
	}

	public function createComponentOrderGrid() {
		return $this->orderGrid->create($this);
	}
}

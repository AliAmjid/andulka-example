<?php


namespace App\Model\Forms;


use App\Model\Service\DataImportService;
use App\Model\Utils\EnvironmentUtils;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;

class DataImportForm extends BaseForm {

	/** @var DataImportService $dataImportService */
	private $dataImportService;

	/**
	 * DataImportForm constructor.
	 * @param DataImportService $dataImportService
	 */
	public function __construct(DataImportService $dataImportService) {
		$this->dataImportService = $dataImportService;
	}


	public function define() {
		$this->addUpload('file', 'Soubor (Max: ' . EnvironmentUtils::maxUploadFormatted() . ')')
			->setHtmlAttribute('accept', '.xlsx');

		$this->addSubmit('submit');
	}

	public function save() {
		/** @var FileUpload $file */
		$file = $this->getValues()->file;
		if (!$file->isOk()) {
			throw new \Exception('Soubor byl při nahrávání poškozen.');
		}
		$errors = $this->dataImportService->importData($file);
		foreach ($errors as $error) {
			$this->addError($error);
		}
	}
}
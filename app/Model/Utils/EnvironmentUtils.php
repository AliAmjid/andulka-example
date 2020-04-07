<?php


namespace App\Model\Utils;


class EnvironmentUtils {
	public static function maxUpload(): int {
		static $maxSize = -1;
		if ($maxSize < 0) {
			$postMaxSize = MemoryUtils::formatSizeFromIni(ini_get('post_max_size'));
			if ($postMaxSize > 0) {
				$maxSize = $postMaxSize;
			}

			$maxUpload = MemoryUtils::formatSizeFromIni(ini_get('upload_max_filesize'));
			if ($maxUpload > 0 && $maxUpload < $maxSize) {
				$maxSize = $maxUpload;
			}
		}
		return $maxSize;
	}

	public static function maxUploadFormatted(): string {
		return MemoryUtils::formatBytes(self::maxUpload());
	}
}
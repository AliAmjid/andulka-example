<?php


namespace App\Model\Utils;


class MemoryUtils {
	public static function formatSizeFromIni($size) {
		$unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
		$size = preg_replace('/[^0-9\.]/', '', $size);
		if ($unit) {
			return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
		} else {
			return round($size);
		}
	}

	public static function formatBytes($bytes) {
		$base = log($bytes) / log(1024);
		$suffix = array("", "k", "M", "G", "T")[floor($base)];
		return pow(1024, $base - floor($base)) . $suffix;
	}
}
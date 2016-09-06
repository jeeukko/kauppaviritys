<?php

function urli($txt) {
	$replace = [
		"å" => "a",
		"Å" => "a",
		"ä" => "a",
		"Ä" => "a",
		"ö" => "o",
		"Ö" => "o",
		" " => ""
	];
	return str_replace(array_keys($replace), $replace, $txt);
}

function parse_categorys($items) {
	$data = array();

	foreach ($items as $item) {
		if (! isset($data[$item["category"]]) && ! empty($item["category"])) {
			$data[$item["category"]] = array();
		}
		if (! in_array($item["subcategory"], $data[$item["category"]]) && ! empty($item["subcategory"])) {
			$data[$item["category"]][] = $item["subcategory"];
		}
	}

	return $data;
}

?>

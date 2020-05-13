<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/local/lib/backend/PHPExcel/Classes/PHPExcel.php";
require "classes/Table.php";
require "classes/TableProducts.php";
require "classes/TableMap.php";

function isValidFileName($name){
	$ext = pathinfo($name, PATHINFO_EXTENSION);
	$valid = ["xlsx", "xls"];
	
	return in_array($ext, $valid) ? true : false;
}

$pathSource = $_SERVER["DOCUMENT_ROOT"] . "/upload/tableImport";

if(!empty($_FILES["file"]["name"])){
	if(isValidFileName($_FILES["file"]["name"])){
		$file = $_FILES["file"]["tmp_name"];
		$table = new TableProducts($file, $pathSource);
		$tableMapObj = $table->get();
		$tableMap = $tableMapObj->get();
		echo json_encode($tableMap);
		exit;
	} else
		echo json_encode(["error" => "Ошибка загрузки файла, пожалуйста, выберите формат: xlsx, xls"]);
} else 
	echo json_encode(["error" => "Файл отсутствует"]);

?>
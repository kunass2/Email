<?php

require 'FineUpload.php';

$uploadDir = '../uploads/';
$allowed   = explode(',', 'pdf');
$sizeLimit = 5000 * 1024;

$fineUpload = new FineUpload($allowed, $sizeLimit);
$response   = $fineUpload->handleUpload($uploadDir);

if (@$response['success']) {
	$uploadName = $fineUpload->getUploadName();

	list($width, $height) = getimagesize($uploadDir . $uploadName);

	$response['fileName'] = $uploadName;

}

echo json_encode($response);

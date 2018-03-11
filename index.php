<?php

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$questionType = $json->queryResult->parameters->questionType;
	$speech = "sorry";

	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	$response->questionType = $questionType[0];
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>

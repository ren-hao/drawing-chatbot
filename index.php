<?php

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$responseSet = file_get_contents('response/response.json');
	$json = json_decode($requestBody);
	$responseSetJson = json_decode($responseSet);
	//$questionType = $json->result->parameters->questionType;

    $imageCount = count($responseSetJson->imageUrl);
	$textCount = count($responseSetJson->text);
    $image = $responseSetJson->imageUrl[rand(0, $imageCount - 1)];
	$text = $responseSetJson->text[rand(0, $textCount - 1)];

	$messages = array(
        array(
			"type" => 0,
			"platform" => "facebook",
			"speech" => $text
    	),
		array(
			"type" => 3,
			"platform" => "facebook",
			"imageUrl" => $image
		)
    );


	$response = new \stdClass();
	$response->source = "webhook";
	$response->messages = $messages;
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>

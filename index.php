<?php

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$responseSet = file_get_contents('response/response.json');
	$json = json_decode($requestBody);
	$responseSetJson = json_decode($responseSet);
	$questionType = $json->result->parameters->questionType;
	$speech = "sorry";

    $url = 'https://script.google.com/macros/s/AKfycbxwZtpnWeyD0ar-rvQCp5OMk_Dq7F0ST-5p41EIvGt_OFflh6Q1/exec?i=' . $questionType[0];
    $content = file_get_contents($url);

    $responseCount = count($responseSetJson->imageUrl);
    $image = $responseSetJson->imageUrl[rand(0, $responseCount - 1)];

    $messages = array(
        array(
			"type" => 0,
			"platform" => "facebook",
			"speech" => "provide " .$questionType[0] . ". server meow meow"
    	),
		array(
			"type" => 3,
			"platform" => "facebook",
			"imageUrl" => $image
		)
    );


	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	$response->messages = $messages;
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>

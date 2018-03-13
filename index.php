<?php

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$questionType = $json->result->parameters->questionType;
	$speech = "sorry";

    $messages = array(
            array(
                "type" => 3,
                "platform" => "facebook",
                "imageUrl" => "https://i.imgur.com/AD3MbBi.jpg"
            ),
            array(
                "type" => 0,
                "platform" => "facebook",
                "speech" => "server response"
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

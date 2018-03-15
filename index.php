<?php

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$responseSet = file_get_contents('response/response.json');
	$json = json_decode($requestBody);
	$responseSetJson = json_decode($responseSet);
	//$questionType = $json->result->parameters->questionType;
	$anyText = $json->result->resolvedQuery;	

	$ctext = urlencode($anyText);

    $url = 'https://script.google.com/macros/s/AKfycbxwZtpnWeyD0ar-rvQCp5OMk_Dq7F0ST-5p41EIvGt_OFflh6Q1/exec?i=' . $ctext;

	
    $ch = curl_init();
    $timeout = 0;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $contents = curl_exec($ch);
    curl_close($ch);
    $contents = htmlentities($contents,ENT_QUOTES,"UTF-8");
    
	
    $tp = $contents;	
    $k = strpos($contents,"userHtml");
    $contents = substr($contents, $k+17);
    $k = strpos($contents,"x22");
    $contents = substr($contents, 0,$k-1);
    $decodecontents = urldecode($contents);
	
    $responseCount = count($responseSetJson->imageUrl);
    $image = $responseSetJson->imageUrl[rand(0, $responseCount - 1)];

    $messages = array(
        array(
			"type" => 0,
			"platform" => "facebook",
			"speech" => $decodecontents
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

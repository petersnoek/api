<?php
/**
 * Created by PhpStorm.
 * User: petersnoek
 * Date: 16/10/2018
 * Time: 17:42
 */

function json_response($message = null, $code = 200)
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
    );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    echo json_encode(array(
        'status' => $code < 300, // success or not?
        'message' => $message
    ));
}

$example_response = [
    'status'=>true,
    'results'=>[
        "nl-NL"=>["resultaat 1", "resultaat 2"],
        "en-UK"=>["result 1", "result 2"]
    ]
];

if(isset($_GET['word']) && !empty($_GET['word']) ) {
    json_response($example_response, 200);
} else{
    json_response("Error, please use ?word=xxxxx in URL", 400);
}

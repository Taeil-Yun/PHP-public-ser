<?php
//use \Firebase\JWT\JWT;
//
//$key = "example_key";
//$token = array(
//    "iss" => "http://example.org",
//    "aud" => "http://example.com",
//    "iat" => 1356999524,
//    "nbf" => 1357000000
//);
//
///**
// * IMPORTANT:
// * You must specify supported algorithms for your application. See
// * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
// * for a list of spec-compliant algorithms.
// */
//$jwt = JWT::encode($token, $key);
//$decoded = JWT::decode($jwt, $key, array('HS256'));
//
//print_r($decoded);
//
///*
// NOTE: This will now be an object instead of an associative array. To get
// an associative array, you will need to cast it as such:
//*/
//
//$decoded_array = (array) $decoded;
//
///**
// * You can add a leeway to account for when there is a clock skew times between
// * the signing and verifying servers. It is recommended that this leeway should
// * not be bigger than a few minutes.
// *
// * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
// */
//JWT::$leeway = 60; // $leeway in seconds
//$decoded = JWT::decode($jwt, $key, array('HS256'));
$header = json_encode(['typ'=>'JWT', 'alg'=>'HS256']);
$a_e = base64_encode($header);
$times = time();
$payload = json_encode(['iss'=>'http://52.79.146.126', 'aud'=>'http://example.com', 'iat'=>$times, 'nbf'=>$times]);

$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'qkqhrnfma1', true);
$base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

//setcookie('test', $jwt, 0);
echo json_decode($jwt);
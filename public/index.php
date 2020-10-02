<?php
require("../bootstrap.php");
use Src\Controller\VehicleController;

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      // may also be using PUT, PATCH, HEAD etc
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

  exit(0);
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /vehicle
// everything else results in a 404 Not Found
if ($uri[1] !== 'vehicle') {
  header("HTTP/1.1 404 Not Found");
  exit();
}

// the user id is, of course, optional and must be a number:
$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestParam = isset($_SERVER["QUERY_STRING"]) ? $_SERVER["QUERY_STRING"] : null;
// pass the request method and user ID to the VehicleController and process the HTTP request:
$controller = new VehicleController($dbConnection, $requestMethod, $userId, $requestParam);
$controller->processRequest();
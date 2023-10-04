<?php

declare(strict_types=1);

spl_autoload_register(function ($class){
  require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8;");

$parts = explode("/",$_SERVER["REQUEST_URI"]);

if(!str_starts_with($parts[1],'services')){
  http_response_code(404);
  exit;
}

$country = isset($_GET['country']) ? $_GET['country'] : null;

$database = new Database("db", "instruct", "root", "password1");

$gateway = new ServicesGateway($database);

$controller = new ServicesController($gateway);

$controller->processRequest($_SERVER["REQUEST_METHOD"], $country);
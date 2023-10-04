<?php

declare(strict_types=1);

spl_autoload_register(function ($class){
  require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8;");

$parts = explode("/",$_SERVER["REQUEST_URI"]);

if($parts[2] != "services"){
  http_response_code(404);
  exit;
}

$id = $parts[3] ?? null;

$database = new Database("localhost", "instruct", "root", "password1");

$gateway = new ServicesGateway($database);
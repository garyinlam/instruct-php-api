<?php

declare(strict_types=1);

spl_autoload_register(function ($class){
  require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8;");

$parts = explode("/",$_SERVER["REQUEST_URI"]);

$country = isset($_GET['country']) ? $_GET['country'] : null;

$database = new Database("localhost", "instruct", "root", "password1");

$gateway = new ServicesGateway($database);

$controller = new ServicesController($gateway);

$controller->processRequest($_SERVER["REQUEST_METHOD"], $country);
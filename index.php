<?php

declare(strict_types=1);

spl_autoload_register(function ($class){
  require __DIR__ . "/src/$class.php";
});

header("Content-type: application/json; charset=UTF-8;");

$parts = explode("/",$_SERVER["REQUEST_URI"]);


$database = new Database("localhost", "instruct", "root", "password1");
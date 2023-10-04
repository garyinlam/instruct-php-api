<?php

// class to handle errors
class ErrorHandler
{
  // handles thrown exceptions, to match set_exception_handler
  public static function handleException(Throwable $exception): void
  {
    http_response_code(500);

    echo json_encode([
      "code" => $exception->getCode(),
      "message" => $exception->getMessage(),
      "file" => $exception->getFile(),
      "line" => $exception->getLine(),

    ]);
  }

  
  // handles non exception errors, to match set_error_handler
  public static function handleError(
    int $errno,
    string $errstr,
    string $errfile,
    int $errline
  ): bool
  {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
  }
}
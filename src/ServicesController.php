<?php

class ServicesController
{
  public function __construct(private ServicesGateway $gateway)
  {}

  public function processRequest(string $method, ?string $country, ?string $ref): void
  {
    if($ref){
      $this->processResourceRequest($method, $ref);
    } else {
      $this->processCollectionRequest($method, $country);
    }
  }

  private function processResourceRequest(string $method, ?string $ref): void
  {

  }

  private function processCollectionRequest(string $method, ?string $country): void
  {
    switch($method){
      case "GET":
        if($country){
          echo json_encode($this->gateway->getAllByCountry($country));
        } else {
          echo json_encode($this->gateway->getAll());
        }
        break;
    }
  }
}
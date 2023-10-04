<?php

class ServicesController
{
  public function __construct(private ServicesGateway $gateway)
  {}

  public function processRequest(string $method, ?string $country): void
  {
    $this->processCollectionRequest($method, $country);
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
      case "POST":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $errors = $this->getValidationErrors($data);

        if(!empty($errors)){
          http_response_code(422);
          echo json_encode(["errors" => $errors]);
          break;
        }

        $service = $this->gateway->get($data["ref"]);

        if(!$service){
          $ref = $this->gateway->create($data);

          http_response_code(201);
          echo json_encode([
            "message" => "Product created",
            "ref" => $ref
          ]);
        } else {

        }

        
        break;
      default:
        http_response_code(405);
        header("Allow: GET");
    }
    
  }

  private function getValidationErrors(array $data): array
  {
    $errors = [];

    if(count($data) !== 4){
      $errors[] = "missing data";
    }

    return $errors;
  }
}
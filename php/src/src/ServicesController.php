<?php

// controller class for services table
class ServicesController
{
  public function __construct(private ServicesGateway $gateway)
  {}

  // process any given request, set to be expandable for singular requests
  public function processRequest(string $method, ?string $country): void
  {
    $this->processCollectionRequest($method, $country);
  }

  // process requests without identifier
  private function processCollectionRequest(string $method, ?string $country): void
  {
    switch($method){
      // process get requests, may have query params for country code
      case "GET":
        if($country){
          echo json_encode($this->gateway->getAllByCountry($country));
        } else {
          echo json_encode($this->gateway->getAll());
        }
        break;
      // process post requests
      // if record with matching reference exist update
      // else create new
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
          $rows = $this->gateway->update($service, $data);
          $ref = $service['ref'];
          echo json_encode([
            "message" => "Product $ref updated",
            "rows" => $rows
          ]);
        }

        
        break;
      default:
        http_response_code(405);
        header("Allow: GET");
    }
    
  }

  // validate that all data is present
  private function getValidationErrors(array $data): array
  {
    $errors = [];

    if(count($data) !== 4){
      $errors[] = "missing data";
    }

    return $errors;
  }
}
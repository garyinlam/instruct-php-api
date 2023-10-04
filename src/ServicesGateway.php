<?php

class ServicesGateway
{
  private PDO $conn;

  public function __construct(Database $database)
  {
    $this->conn = $database->getConnection();
  }

  public function getAll(): array
  {
    $sql = "SELECT *
            FROM services";
    
    $stmt = $this->conn->query($sql);

    $data = [];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $data[] = $row;
    }

    return $data;
  }

  public function getAllByCountry(string $country): array
  {
    $sql = "SELECT *
            FROM services
            WHERE LOWER(country) = LOWER(:country)";
    
    $stmt = $this->conn->prepare($sql);

    $stmt->bindValue(":country", $country, PDO::PARAM_STR);

    $stmt->execute();

    $data = [];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $data[] = $row;
    }

    return $data;
  }

  public function get(string $ref): array | false
  {
    $sql = "SELECT *
            FROM services
            WHERE ref = :ref";
    
    $stmt = $this->conn->prepare($sql);

    $stmt->bindValue(":ref", $ref, PDO::PARAM_STR);

    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data;
  }


  public function create(array $data): string
  {
    $sql = "INSERT INTO services (ref, centre, service, country)
            VALUES (:ref, :centre, :service, :country)";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
    $stmt->bindValue(":centre", $data["centre"], PDO::PARAM_STR);
    $stmt->bindValue(":service", $data["service"], PDO::PARAM_STR);
    $stmt->bindValue(":country", $data["country"], PDO::PARAM_STR);


    $stmt->execute();
    
    return $this->conn->lastInsertId();

  }
}
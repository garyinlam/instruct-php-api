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
}
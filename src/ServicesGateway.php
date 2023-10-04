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
}
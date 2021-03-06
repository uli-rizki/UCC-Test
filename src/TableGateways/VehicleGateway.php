<?php
namespace Src\TableGateways;

class VehicleGateway {
  
  private $db = null;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function findAll(Array $arg)
  {
    $filter = "";

    if (isset($arg['sort_by'])) {
      $sort = $arg['sort_by'];
      $filter = "ORDER BY $sort DESC";
    }
    if (isset($arg['sort_by']) && $arg['sort_by']=="engine_displacement") $filter = "ORDER BY engine_displacement_cc DESC";

    $statement = "
      SELECT
        *
      FROM
        vehicles
      
      $filter
    ";

    try {
      $statement = $this->db->query($statement);
      $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
      return $result;
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
  }

  public function find($id)
    {
        $statement = "
            SELECT 
                *
            FROM
              vehicles
            WHERE vehicle_id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

  public function insert(Array $input)
    {
      $statement = "
        INSERT INTO vehicles 
          (vehicle_no, vehicle_name, category, engine_displacement_cc, engine_displacement_liter, engine_displacement_inc, engine_power, price, currency, location)
        VALUES
          (:vehicle_no, :vehicle_name, :category, :engine_displacement_cc, :engine_displacement_liter, :engine_displacement_inc, :engine_power, :price, :currency, :location);
      ";

      try {
        $statement = $this->db->prepare($statement);
        $statement->execute(array(
            'vehicle_no' => $input['vehicle_no'],
            'vehicle_name'  => $input['vehicle_name'],
            'category' => $input['category'],
            'engine_displacement_cc' => $input['engine_displacement_cc'],
            'engine_displacement_liter' => $input['engine_displacement_liter'],
            'engine_displacement_inc' => $input['engine_displacement_inc'],
            'engine_power'  => $input['engine_power'],
            'price'  => $input['price'],
            'currency'  => $input['currency'],
            'location'  => $input['location'],
        ));
        return $statement->rowCount();
        } catch (\PDOException $e) {
          exit($e->getMessage());
        }    
  }

  public function update($id, Array $input)
  {
    $statement = "
        UPDATE vehicles
        SET 
          vehicle_no = :vehicle_no,  
          vehicle_name = :vehicle_name,
          category  = :category,
          engine_displacement_cc = :engine_displacement_cc,
          engine_displacement_liter = :engine_displacement_liter,
          engine_power = :engine_power,
          price = :price,
          currency = :currency,
          location = :location
        WHERE vehicle_id = :vehicle_id;
    ";

    try {
      $statement = $this->db->prepare($statement);
      $statement->execute(array(
          'vehicle_id' => (int) $id,
          'vehicle_no' => $input['vehicle_no'],
          'vehicle_name'  => $input['vehicle_name'],
          'category' => $input['category'],
          'engine_displacement_cc' => $input['engine_displacement_cc'],
          'engine_displacement_liter' => $input['engine_displacement_liter'],
          'engine_displacement_inc' => $input['engine_displacement_inc'],
          'engine_power' => $input['engine_power'],
          'price' => $input['price'],
          'currency' => $input['currency'],
          'location' => $input['location'],
        ));
        return $statement->rowCount();
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }    
  }

  public function delete($id)
  {
    $statement = "
        DELETE FROM vehicles
        WHERE vehicle_id = :vehicle_id;
    ";

    try {
      $statement = $this->db->prepare($statement);
      $statement->execute(array('vehicle_id' => $id));
      return $statement->rowCount();
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }    
  }
}
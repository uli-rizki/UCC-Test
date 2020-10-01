<?php
namespace Src\Controller;

use Src\TableGateways\VehicleGateway;

class VehicleController {

    private $db;
    private $requestMethod;
    private $userId;
    private $requestParam;

    private $VehicleGateway;

    public function __construct($db, $requestMethod, $userId, $requestParam)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        $this->requestParam = $requestParam;

        $this->VehicleGateway = new VehicleGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
              if ($this->userId) {
                $response = $this->getVehicle($this->userId);
              } else {
                $response = $this->getAllVehicles();
              };
              break;
            case 'POST':
                $response = $this->createVehicleFromRequest();
                break;
            case 'POST':
                $response = $this->createUserFromRequest();
                break;
            case 'PUT':
                $response = $this->updateVehicleFromRequest($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteVehicle($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllVehicles()
    {
        $arg = array();
        if (isset($this->requestParam)) {
            // echo $this->requestParam; exit;
            $arg = $this->queryParams($this->requestParam);
        }

        $result = $this->VehicleGateway->findAll($arg);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getVehicle($id)
    {
        $result = $this->VehicleGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createVehicleFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateVehicle($input)) {
            return $this->unprocessableEntityResponse();
        }

        if ($input['format_units'] == "L") {
            $input['engine_displacement_cc'] = $input['engine_displacement']*1000;
            $input['engine_displacement_liter'] = $input['engine_displacement'];
        }

        if ($input['format_units'] == "cc") {
            $input['engine_displacement_cc'] = $input['engine_displacement'];
            $input['engine_displacement_liter'] = $input['engine_displacement']/1000;
        }

        $this->VehicleGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updateVehicleFromRequest($id)
    {
        $result = $this->VehicleGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateVehicle($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->VehicleGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteVehicle($id)
    {
        $result = $this->VehicleGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->VehicleGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }


    private function validateVehicle($input)
    {
        if (! isset($input['vehicle_no'])) {
            return false;
        }
        if (! isset($input['vehicle_name'])) {
            return false;
        }
        if (! isset($input['category'])) {
          return false;
        }
        // if (! isset($input['engine_displacement_cc'])) {
        //   return false;
        // }
        // if (! isset($input['engine_displacement_liter'])) {
        //   return false;
        // }
        if (! isset($input['engine_power'])) {
          return false;
        }
        if (! isset($input['price'])) {
          return false;
        }
        if (! isset($input['location'])) {
          return false;
        }
        return true;
    }

    private function queryParams($param)
    {
        $result = array();
        $pairs = explode("&", $param);
        foreach($pairs as $pair) {
            $keyVal = explode('=', $pair);
            //array_push($result, array($keyVal[0] => $keyVal[1]));
            $result[$keyVal[0]] = $keyVal[1];
        }

        return $result;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
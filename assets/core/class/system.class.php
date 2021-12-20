<?php
class System {
  // Properties
  private $database;

  // Constructor to connect to database automatically
  public function __construct() {
    $this->database = new Connection();
    $this->database = $this->database->connect();
  }

  // CRUD for database transactions
  // CREATE record
  public function addAmbulance($name, $location, $desc) {
    $statement = $this->database->prepare("INSERT INTO ambulance (name, location, description) VALUES (?, ?, ?)");
    $statement->bindParam(1, $name);
    $statement->bindParam(2, $location);
    $statement->bindParam(3, $desc);

    // Execute the query
    $result = $statement->execute();

    return $result ? true : false;
  }

    public function addDispatcher($userId, $password, $usergroup, $profileId)
    {
        $statement = $this->database->prepare("INSERT INTO user (user_id, password, usergroup, profileid) VALUES (?, ?, ?, ?)");
        $statement->bindParam(1, $userId);
        $statement->bindParam(2, $password);
        $statement->bindParam(3, $usergroup);
        $statement->bindParam(4, $profileId);

        // Execute the query
        $result = $statement->execute();

        return $result ? true : false;
    }

    public function addEmergency($dId, $ambId, $cName, $cPhone, $cRel, $eType, $injured, $ambReq, $address, $notes)
    {
        $statement = $this->database->prepare("INSERT INTO emergency (dispatcher_id, ambulance_id, caller_name, caller_phone, relationship, emg_type, injured, amb_required, address, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->bindParam(1, $dId);
        $statement->bindParam(2, $ambId);
        $statement->bindParam(3, $cName);
        $statement->bindParam(4, $cPhone);
        $statement->bindParam(5, $cRel);
        $statement->bindParam(6, $eType);
        $statement->bindParam(7, $injured);
        $statement->bindParam(8, $ambReq);
        $statement->bindParam(9, $address);
        $statement->bindParam(10, $notes);

        // Execute the query
        $result = $statement->execute();

        return $result ? true : false;
    }

  public function getAmbulance() {
    $statement = $this->database->prepare("SELECT * FROM ambulance");
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $results ? $results : false;
  }

    public function getAmbInfo($amb_id) {
        $statement = $this->database->prepare("SELECT * FROM ambulance WHERE id = :id AND status = 1");
        $statement->execute(['id' => $amb_id]);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results ? $results : false;
    }

    public function getAmb($id)
    {
        $statement = $this->database->prepare("SELECT * FROM ambulance WHERE id = :id");
        $statement->execute(['id' => $id]);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results ? $results : false;
    }


    public function getAmbulanceWhereAvailable()
    {
        $statement = $this->database->prepare("SELECT * FROM ambulance WHERE status = 1");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results ? $results : false;
    }


    public function getEmergency($emg_id)
    {
        $statement = $this->database->prepare("SELECT * FROM emergency WHERE id = :emg_id");
        $statement->execute(['emg_id' => $emg_id]);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results ? $results : false;
    }

    public function getEmergencies($dispatchID)
    {
        $statement = $this->database->prepare("SELECT * FROM emergency WHERE dispatcher_id = :dispatchID");
        $statement->execute(['dispatchID' => $dispatchID]);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results ? $results : false;
    }

    public function getDispatchers() {
        $statement = $this->database->prepare("SELECT * FROM user WHERE usergroup != 123");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results ? $results : false;
    }

    public function updateEmergencyStatus($emergency_status, $emg_id)
    {
        $query = "UPDATE emergency SET status = :status WHERE id = :id";
        $statement = $this->database->prepare($query);
        $result = $statement->execute(array("id"=>$emg_id, "status"=>$emergency_status));

        return $result ? true : false;
    }

    public function updateAmbInEmergency($amb_id, $emg_id)
    {
        $query = "UPDATE emergency SET ambulance_id = :amb_id WHERE id = :id";
        $statement = $this->database->prepare($query);
        $result = $statement->execute(array("id"=>$emg_id, "amb_id"=>$amb_id));

        return $result ? true : false;
    }


// Return a single service from the db
  public function getService($id) {
    $statement = $this->database->prepare("SELECT * FROM services WHERE id = :id");
    $statement->execute(array('id'=>$id));
    $result = $statement->fetch();

    return $result ? $result : false;
  }

// Return the first three services
  public function getServicesLimit3() {
    $statement = $this->database->prepare("SELECT * FROM services WHERE active = 1 LIMIT 3");
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $results ? $results : false;
  }

// Update Services
  public function updateService($id) {
    $query = "UPDATE services SET 
              title = ?, 
              description = ?,
              photo = ?, 
              active = ? WHERE id = ?";
    $statement = $this->database->prepare($query);
    // Bind values to the placeholders
    $statement->bindParam(1, $this->title);
    $statement->bindParam(2, $this->description);
    $statement->bindParam(3, $this->photo);
    $statement->bindParam(4, $this->active);
    $statement->bindParam(5, $this->id);

    $result = $statement->execute();

    return $result ? true : false;
  }

// Return the number of rows
  public function countAll() {
		$statement = $this->database->prepare("SELECT COUNT(*) AS count FROM services");
		$statement->execute();
		$result = $statement->fetch();

		return $result ? $result['count'] : false;
	}

    // Delete service from the database
    public function deleteAmbulance($id) {
        $statement = $this->database->prepare("DELETE FROM ambulance WHERE id =:id");
        $result = $statement->execute(array("id"=>$id));

        return $result ? true : false;
    }

// Delete service from the database
  public function delete($id) {
    $statement = $this->database->prepare("DELETE FROM services WHERE id =:id");
    $result = $statement->execute(array("id"=>$id));

    return $result ? true : false;
  }



}

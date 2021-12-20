<?php
class Profile {
	private $database;
	public $id, $firstname, $middlename, $surname, $gender, $phone, $address, $stateid, $lgaid;

	public function __construct() {
		$this->database = new Connection();
		$this->database = $this->database->connect();
	}

	// Create record in database table
	public function createProfile($name) {
		$statement = $this->database->prepare("INSERT INTO profile (name) VALUES (?)");
		// Bind all values to the placeholders
		$statement->bindParam(1, $name);

		// Execute the query
		$result = $statement->execute();

		// Retrieve profileid and return value
		$this->id = $this->database->lastInsertId();

		return $result ? true : false;
	}

	// Read row(s) from the database table
	public function getProfiles() {
		$statement = $this->database->prepare("SELECT * FROM profile");
		$statement->execute();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $results ? $results : false;
	}

	public function getName($profileid) {
		$statement = $this->database->prepare("SELECT name FROM profile WHERE id = :profileid");
		$statement->execute(array("profileid"=>$profileid));
		$result = $statement->fetch();

		return $result ? $result : '';
	}

	// Update row in table

	// Delete record from table
	public function delete($id) {
		$query = "DELETE FROM profile WHERE id = :id";
		$statement = $this->database->prepare($query);
		$result = $statement->execute(array("id"=>$id));

		return $result ? true : false;
	}

}

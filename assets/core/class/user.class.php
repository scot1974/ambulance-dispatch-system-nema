<?php
class User {
	private $database;
	public $id, $user_id, $password, $usergroup, $created, $profileid;

	public function __construct() {
		$this->database = new Connection();
		$this->database = $this->database->connect();
	}

	// Create record in database table
	public function createUser() {
		$statement = $this->database->prepare("INSERT INTO user (user, password, usergroup, profileid) VALUES (?, ?, ?, ?)");
		// Bind all values to the placeholders
		$statement->bindParam(1, $this->user_id);
		$statement->bindParam(2, $this->password);
		$statement->bindParam(3, $this->usergroup);
		$statement->bindParam(4, $this->profileid);

		// Execute the query
		$result = $statement->execute();

		return $result ? true : false;
	}

	// Read row(s) from the database table
	public function getUsers() {
		$statement = $this->database->prepare("SELECT * FROM user");
		$statement->execute();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $results ? $results : false;
	}

	public function userProfile() {
		$query = "SELECT us.*, pr.* FROM user us JOIN profile pr ON(us.profileid = pr.id)";

		$statement = $this->database->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $result ? $result : false;
	}

	public function countAll() {
		$statement = $this->database->prepare("SELECT COUNT(*) AS count FROM user");
		$statement->execute();
		$result = $statement->fetch();

		return $result ? $result['count'] : false;
	}

	public function login($user_id, $password) {
		$statement = $this->database->prepare("SELECT * FROM user WHERE user_id = :user_id AND password = :password");
		$statement->execute(array("user_id"=>$user_id, "password"=>$password));

		$result = $statement->fetch();

		// Create SESSION variables for logged in user
		if ($result) {
			$_SESSION['us3rid'] = $result['id'];
			$_SESSION['us3rgr0up'] = $result['usergroup'];
			$_SESSION['profile'] = $result['profileid'];
			$_SESSION['1s@dmin'] = ($result['usergroup'] == 123) ? true : false;
		}

		return $result ? true : false;
	}

	public function logout() {
		if (isset($_SESSION['us3rid'])){
			unset($_SESSION['us3rid']);
			session_destroy();

			return true;
		}
		return false;
	}

	// Update row in table

	// Delete record from table
	public function delete($id) {
		$query = "DELETE FROM user WHERE id = :id";
		$statement = $this->database->prepare($query);
		$result = $statement->execute(array("id"=>$id));

		return $result ? true : false;
	}
}

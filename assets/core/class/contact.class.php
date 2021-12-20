<?php
class Contact {
  // Properties
  private $database;
  public $id, $name, $email, $message, $is_read, $created;

  // Constructor to connect to database automatically
  public function __construct() {
    $this->database = new Connection();
    $this->database = $this->database->connect();
  }

  // CRUD for database transactions
  // CREATE record
  public function addContact() {
    $statement = $this->database->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $statement->bindParam(1, $this->name);
    $statement->bindParam(2, $this->email);
    $statement->bindParam(3, $this->message);

    // Execute the query
    $result = $statement->execute();

    return $result ? true : false;
  }

  public function getContacts() {
    $statement = $this->database->prepare("SELECT * FROM contact");
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $results ? $results : false;
  }

  public function getContact($id) {
    $statement = $this->database->prepare("SELECT * FROM contact WHERE id = :id");
    $statement->execute(array('id'=>$id));
    $result = $statement->fetch();

    return $result ? $result : false;
  }

  public function countAll() {
		$statement = $this->database->prepare("SELECT COUNT(*) AS count FROM contact");
		$statement->execute();
		$result = $statement->fetch();

		return $result ? $result['count'] : false;
	}

  public function delete($id) {
    $statement = $this->database->prepare("DELETE FROM contact WHERE id =:id");
    $result = $statement->execute(array("id"=>$id));

    return $result ? true : false;
  }
}

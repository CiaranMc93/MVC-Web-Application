<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/TasksDAO.php";
require_once "Validation.php";

class TaskModel
{
	private $tasksDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs

	public function __construct()
	{
		$this->dbmanager = new pdoDbManager();
		$this->tasksDAO = new TasksDAO($this->dbmanager);
		$this->dbmanager->openConnection();
		$this->validationSuite = new Validation();
	}

	//get all students
	public function getTasks()
	{
		return ($this->tasksDAO->get());
	}

	public function __destruct()
	{
		$this->tasksDAO = null;
		$this->dbmanager->closeConnection();
	}
}
?>
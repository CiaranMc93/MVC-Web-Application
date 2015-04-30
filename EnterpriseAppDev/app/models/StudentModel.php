<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/StudentDAO.php";
require_once "Validation.php";

class StudentModel 
{
	private $studentsDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	
	public function __construct() 
	{
		$this->dbmanager = new pdoDbManager();
		$this->studentsDAO = new StudentDAO($this->dbmanager);
		$this->dbmanager->openConnection();
		$this->validationSuite = new Validation();
	}
	
	//get all students
	public function getStudents() 
	{
		return ($this->studentsDAO->get());
	}
	
	//get all students
	public function getStudent($nationality)
	{
		return ($this->studentsDAO->get($nationality));
	}

	public function __destruct()
	{
		$this->studentsDAO = null;
		$this->dbmanager->closeConnection();
	}
}
?>
<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/QuestionnaireDAO.php";
require_once "Validation.php";

class QuestionnaireModel 
{
	private $questionnairesDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	
	public function __construct() 
	{
		$this->dbmanager = new pdoDbManager();
		$this->questionnairesDAO = new QuestionnaireDAO($this->dbmanager);
		$this->dbmanager->openConnection();
		$this->validationSuite = new Validation();
	}
	
	//get all students
	public function getQuestionnaires() 
	{
		return ($this->questionnairesDAO->get());
	}
	
	//get all students by nationality
	public function getQuestionnaire($task)
	{
		
		return ($this->questionnairesDAO->get($task));
	}
	
	
	public function __destruct()
	{
		$this->questionnairesDAO = null;
		$this->dbmanager->closeConnection();
	}
}
?>
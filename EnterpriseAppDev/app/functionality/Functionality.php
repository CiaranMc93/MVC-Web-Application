<?php

class Functionality
{
	
	function Functionality()
	{

	}
	
	public function getAverage($array)
	{
		
	
		return $average;
	}
	
	public function standardDev($array)
	{
		$numStudents = 0;
		$mean = 0;
		$M2 = 0;
		
		//loop through each student
		foreach($array as $x)
		{
			//count students
			$numStudents++;
			//get current students age
			$currAge = intval($x["age"]);
			$delta = $currAge - $mean;
			//calculate the mean
			$mean = $mean + $delta/$numStudents;
			//calculate m2
			$M2 = $M2 + $delta*($currAge - $mean);
		}
		
		//get the variance
		$variance = $M2/($numStudents - 1);
		//get standard deviation
		$standDev = sqrt($variance);
	}
}
?>
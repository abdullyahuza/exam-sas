<?php
	//Abdull Yahuza.
	//A flexible algol for assigning seat number to students taking a course.
	
	//the main alogols
	include './functional.php';
	include './db.php';

	//db connection
	// $conn = new mysqli('localhost', 'root', '', 'test');	

	//selected venues
	$venues = array('venueA','venueB','venueC');
	
	//a single venue
	$venue = 'venueA';

	//selected course
	$courseCode = 'COSC001';
	
	//ALL STUDENTS TAKING THE COURSE
	$allStudents = allStudentsInCourseArray($conn, 'COSC001');

	// ALLOCATION...
	/*if(count($allStudents) > 0){
		foreach($venues as $venue){
			allocateStudents($conn, $allStudents, $venue, $courseCode, $venues);
		}

	}else{
		echo "No student to allocate";
		return 0;
	}*/

	//check allocation
	for($i=0; $i<count($allStudents); $i++){

		if(checkAllocationInAllVenues($conn, $allStudents[$i], $venues)){
			echo $allStudents[$i]." - Allocated<br/>";
		}else{
			echo $allStudents[$i]." - <font style='color:red;'>Not Allocated</font><br/>";;
		}

	}

	//populate venues
	/*foreach($venues as $venue){
		//populate venues
		for($i=1; $i<=1000; $i++){
			if($i<10){
				$regNo='U15CS500'.$i;	
			}else{
				$regNo='U15CS50'.$i;
			}
			$sql = "INSERT INTO $venue (seatNo)
			VALUES ('$i')";
			if ($conn->query($sql) === TRUE) {
			  echo $i." New record created successfully";
			} else {
			  echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}*/

	//populate course_reg
	/*for($i=1; $i<=2000; $i++){
		$regNo='U15CS0'.$i;	
		
		$sql = "INSERT INTO course_reg (regNo, name, courseCode)
		VALUES ('$regNo', 'Abdull Yahuza $i', 'COSC001')";
		if ($conn->query($sql) === TRUE) {
		  echo $i." New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}*/

	
 ?>
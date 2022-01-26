<?php 

//GET ALL THE SEATS THAT ARE AVAILABLE IN A VENUE AND STORE THEM IN ARRAY
function availableSeatsInVenueArray($dbconn, $venue){
	$seats_in_venue = array(); //array to keep all seatNo in the venue.
	$sql = "SELECT seatNo FROM $venue WHERE regNo IS NULL AND courseCode IS NULL";
	$result = $dbconn->query($sql);
	
	while($row = mysqli_fetch_array($result)){
	    array_push($seats_in_venue, $row['seatNo']);  //populate the array; $seats_in_venue
	}
	return $seats_in_venue;
}

//GET ALL THE SEATS IN A VENUE
function allSeatsInVenueArray($dbconn, $venue){
	$seats_in_venue = array(); //array to keep all seatNo in the venue.
	$sql = "SELECT seatNo FROM $venue";
	$result = $dbconn->query($sql);
	
	while($row = mysqli_fetch_array($result)){
	    array_push($seats_in_venue, $row['seatNo']);  //populate the array; $seats_in_venue
	}
	return $seats_in_venue;
}

//GET ALL STUDENTS TAKING A COURSE AND RETURN THEIR REG NO. IN AN ARRAY
function allStudentsInCourseArray($dbconn, $courseCode){
	$users_in_course = array(); //array to keep all students in the course.
	$sql = "SELECT regNo FROM course_reg WHERE courseCode='$courseCode'";
	$result = $dbconn->query($sql);
	
	while($row = mysqli_fetch_array($result)){
	    array_push($users_in_course, $row['regNo']);  //populate the array; $users_in_db
	}
	if(count($users_in_course) > 1) return $users_in_course;
	return array(); //RETRUN AN EMPTY ARRAY
}



//CHECK ALLOCATION STATUS OF A PARTICULAR STUDENT IN A PARTICULAR VENUE
function checkAllocation($dbconn, $student, $venue){
	$sql = "SELECT COUNT(*) AS total FROM $venue WHERE regNo='$student'";
	$result = $dbconn->query($sql);
	$count=mysqli_fetch_assoc($result);
	$status = intval($count['total']);
	
	return $status > 0 ? true : false;	
}

//CHECK ALLOCATION STATUS OF A PARTICULAR STUDENT ACROSS ALL VENUES
function checkAllocationInAllVenues($dbconn, $student, $allVenues){
	// $allVenues = allVenuesArray();
	$status = false;

	foreach($allVenues as $venue){
		if(checkAllocation($dbconn, $student, $venue)){
			$status= true;
			return $status;	//STOP CHECKING
		}	
	}
	return $status;
}

//GET ALL THE AVAILBLE SEATS IN A VENUE
function availableSeatsInVenue($dbconn, $table){
    $sql = "SELECT COUNT(*) AS total FROM $table WHERE regNo is NULL";
    $result = $dbconn->query($sql);
    $count=mysqli_fetch_assoc($result);
    
    return intval($count['total']);
}

//ALLOCATE SEAT TO ONE STUDENT
function allocateStudent($dbconn, $student, $venue, $courseCode){
	if($student === '') return 0;
	$freeSeats = availableSeatsInVenueArray($venue);	//array
	$seatNo = null;
	if(count($freeSeats) > 1){
		$seatNo = $freeSeats[rand(0,count($freeSeats)-1)]; //random seat base on availble seats
	}else{
		$seatNo = 1;
	}
	$sql = "UPDATE $venue 
			SET regNo='$student', courseCode='$courseCode'
			WHERE seatNo='$seatNo'";
	
	if ($dbconn->query($sql) === TRUE) {
	  return TRUE;
	} else {
	  return FALSE;
	}
}	

//ALLOCATE SEAT TO MANY STUDENTS
function allocateStudents($dbconn, $allStudents, $venue, $courseCode, $venuescheck){
	if(count($allStudents) < 1) return 0;	//stop allocation when students array is empty

	for($i=0;$i<count($allStudents);$i++){
		echo "Allocating ". $allStudents[$i]; 
		
		while(checkAllocationInAllVenues($dbconn, $allStudents[$i], $venuescheck) !== TRUE){ //if student is not allocated
			allocateStudent($dbconn, $allStudents[$i], $venue, $courseCode);

		}
	}
}	

?>
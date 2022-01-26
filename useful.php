
//populate course_reg
$regNo = '';
for($i=1; $i<50; $i++){
	if($i<10){
		$regNo='U15CS500'.$i;	
	}else{
		$regNo='U15CS50'.$i;
	}
	$sql = "INSERT INTO course_reg (regNo, courseCode)
	VALUES ('$regNo', 'COSC001')";
	if ($conn->query($sql) === TRUE) {
	  echo $i." New record created successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

//populate venues
for($i=1; $i<=25; $i++){
	if($i<10){
		$regNo='U15CS500'.$i;	
	}else{
		$regNo='U15CS50'.$i;
	}
	$sql = "INSERT INTO venueC (seatNo)
	VALUES ('$i')";
	if ($conn->query($sql) === TRUE) {
	  echo $i." New record created successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
}


// make two fields unique at a time
// ALTER TABLE `tb_name` ADD UNIQUE `unique_index`(`colum1`, `column2`, `columnN`);

<!DOCTYPE html>
<html>
<head>
	<?php include 'header.php';?>
</head>
<body>

<?php
include 'connection.php';
echo '<a href="index.php"><button type="button">HOME</button></a>';

$stmt = $connection->prepare("SELECT name, birthday, address, number FROM Patient WHERE name LIKE '%' :search_name '%'");

$stmt->bindParam(':search_name', $_POST['patient_name']);
$stmt->execute();

if ($stmt->rowCount() >= '1') {
	//Insert table with Patient names
	echo '<div class="col-md-4 table-responsive">';
	echo '<table class="table table-hover">';
	echo '<tr> <th>Patient name</th> <th>Number</th> <th>Birthday</th> <th>Address</th></tr>';

	foreach($stmt as $row){
          echo("<tr><td>");
          echo("<a href=\"view_devices.php?number=");
          echo($row['number']);
          echo("\">");
          echo($row["name"]);
          echo("<a/>");
          echo("</td><td>");
          echo($row['number']);
          echo("</td><td>");
          echo($row['birthday']);
          echo("</td><td>");
          echo($row['address']);
          echo("</td></tr>");  
        }
    echo '</table>';
    echo '</div>';
}
else{
  echo '<p>No results found</p>';
  echo '<a href="insert_new_patient.php"> <button class="btn">Insert new patient</button> </a>';
}

$connection = NULL;

?>

</body>
</html>
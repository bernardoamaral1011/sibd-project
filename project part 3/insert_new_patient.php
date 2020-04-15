<?php
include 'connection.php';
echo '<a href="index.php"><button type="button">HOME</button></a>';

$stmt = $connection->prepare("INSERT INTO Patient VALUES(:number, :name, :birthday, :address)");

$stmt->bindParam(':number', $_POST['number']);
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindParam(':birthday', $_POST['birthday']);
$stmt->bindParam(':address', $_POST['address']);
if ($stmt->execute()) {
	echo '<p><h3>Patient successfully inserted!</h3></p>';
}

//close connection
$connection = NULL;

?>

<!DOCTYPE html>
<html>
<head>
	<?php include 'header.php';?>
</head>
<body>

	<form action="insert_new_patient.php" method="post">
		Patient's number: <input type="text" name="number"><br/>
		Name: <input type="text" name="name"><br/>
		Birthday: <input type="date" name="birthday"><br/>
		Address: <input type="text" name="address"><br/>
		<input type="submit" name="submit" value="insert">
	</form>

</body>
</html>
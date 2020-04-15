<?php
include 'connection.php';
echo '<a href="index.php"><button type="button">HOME</button></a>';

$url = 'http://web.tecnico.ulisboa.pt/~ist181356/projects/SIBD/series/' . $_POST['sid'];

$sql0 = "start transaction";
$e0 = $connection->query($sql0);
if ( false===$e0 ) {
   	die('Autocommit(FALSE) failed');
}

$sql1 = "INSERT INTO Study VALUES(:rn, :description, :datez, :doctor_id, :sn, :manuf)";
$stmt1 = $connection->prepare($sql1);

$stmt1->bindParam(':rn', $_POST['rn']);
$stmt1->bindParam(':description', $_POST['description']);
$stmt1->bindParam(':datez', $_POST['date']);
$stmt1->bindParam(':doctor_id', $_POST['doctor']);
$stmt1->bindParam(':sn', $_POST['snum']);
$stmt1->bindParam(':manuf', $_POST['manuf']);
$e1 = $stmt1->execute();
if ( false===$e1 ) {
   	die('Study not created, execute() failed: '.$stmt1->error);
}

$sql2 = "INSERT INTO Series VALUES(:sid, :name, :url, :rn, :description)";
$stmt2 = $connection->prepare($sql2);
//$e3 = $stmt->bind_param('sssis', $_POST['sid'], $_POST['name'], $_POST['date'], $_POST['rn'], $_POST['description']);
$stmt2->bindParam(':sid', $_POST['sid']);
$stmt2->bindParam(':name', $_POST['name']);
$stmt2->bindParam(':url', $url);
$stmt2->bindParam(':rn', $_POST['rn']);
$stmt2->bindParam(':description', $_POST['description']);

$e2 = $stmt2->execute();
if ( false===$e2 ) {
   	die('Series not created, execute() failed: '.$stmt2->error);
}

$sql3 = "commit";
$e3 = $connection->query($sql3);
if ( false===$e3 ) {
   	die('Commit failed, execute() failed: '.$stmt2->error);
}
echo '<p><strong> Study created! </strong></p> ';

//close connection
$connection = NULL;

?>
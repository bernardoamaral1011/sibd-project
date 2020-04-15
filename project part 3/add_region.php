<?php
include 'connection.php';
echo '<a href="index.php"><button type="button">HOME</button></a>';

$stmt1 = $connection->prepare("SELECT series_id, elem_index FROM Element WHERE series_id = :seriesID");
$stmt1->bindParam(':seriesID', $_POST['series_id']);
$stmt1->execute();

$stmt2 = $connection->prepare("SELECT region_overlaps_element(:series_id,:elem_index,:x1,:y1,:x2,:y2) AS functionz");

foreach ($stmt1 as $row) {
	$stmt2->bindParam(':series_id', $_POST['series_id']);
	$stmt2->bindParam(':elem_index', $row['elem_index']);
	$stmt2->bindParam(':x1', $_POST['x1']);
	$stmt2->bindParam(':y1', $_POST['y1']);
	$stmt2->bindParam(':x2', $_POST['x2']);
	$stmt2->bindParam(':y2', $_POST['y2']);

	$result1 = $stmt2->execute();
	if ( false===$result1 ) {
    	die('Error SQL function call, execute() failed: '.$stmt->error);
	}
	foreach ($stmt2 as $row2) {
		if($row2['functionz'] == 1){
			echo '<p>The inserted region overlaps a previous region</p>';
			$overlaps = 1;
			break;
		}
	}
}

if ($overlaps == 0) {
	$stmt3 = $connection->prepare("INSERT INTO Region VALUES(:elem_index1, :series_id1, :x11, :y11, :x21, :y21)");
	$stmt3->bindParam(':series_id1', $_POST['series_id']);
	$stmt3->bindParam(':elem_index1', $_POST['elem_index']);
	$stmt3->bindParam(':x11', $_POST['x1']);
	$stmt3->bindParam(':y11', $_POST['y1']);
	$stmt3->bindParam(':x21', $_POST['x2']);
	$stmt3->bindParam(':y21', $_POST['y2']);
	$result6 = $stmt3->execute();
	if ( false===$result6 ) {
    	die('execute() failed: '.$stmt->error);
	}
	echo '<p>New clinical evidence found!</p>';
}else{
	echo '<p>Did not insert, region overlaps!</p>';
}
//close connection
$connection = NULL;
?>
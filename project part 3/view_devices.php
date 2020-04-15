<!DOCTYPE html>
<html>
<head>
	<?php include 'header.php';?>
</head>
<body>

<?php
include 'connection.php';
echo '<a href="index.php"><button type="button">HOME</button></a>';

$stmt = $connection->prepare("SELECT snum, manuf, start, endt FROM Wears WHERE patient = :search_id ORDER BY endt DESC");
$stmt->bindParam(':search_id', $_REQUEST['number']);
$stmt->execute();

echo '<div class="col-md-6">';
echo '<table class="table table-hover">';
echo '<tr><th>snum</th> <th>manuf</th> <th>start</th> <th>end</th></tr>';

foreach($stmt as $row)
{
	if ($row['endt'] > date("Y-m-d H:i:s")) {
		echo '<tr bgcolor="#D3F484">';
		echo '<td>' . $row['snum'] . '</td>' ;
		echo '<td>' . $row['manuf'] . '</td>' ;
		echo '<td>' . $row['start'] . '</td>' ;
		echo '<td>' . $row['endt'] . '</td>' ;
		echo("<td><a href=\"change_device.php?snum=");
		echo($row['snum']);
		echo("&manuf=");
		echo($row['manuf']);
		echo("&start=");
		echo($row['start']);
		echo("&endt=");
		echo($row['endt']);
		echo("&patient=");
		echo($_REQUEST['number']);
		echo("\">");
		echo '<button type="button">Change device</button>';
		echo("<a/></td>");
		echo '</tr>';
	}
	else{
		echo '<tr>';
		echo '<td>' . $row['snum'] . '</td>' ;
		echo '<td>' . $row['manuf'] . '</td>' ;
		echo '<td>' . $row['start'] . '</td>' ;
		echo '<td>' . $row['endt'] . '</td>' ;
		echo '</tr>';
	}
}

echo '</table>';
echo '</div>';

//close connection
$connection = NULL;
?>
</body>
</html>
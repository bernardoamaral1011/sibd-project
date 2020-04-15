<!DOCTYPE html>
<html>
<head>
	<?php include 'header.php';?>
</head>
<body>
<?php
include 'connection.php';
echo '<div class="container row">';
echo '<div class="col-md-3">';
echo '<p><a href="index.php"><button type="button">HOME</button></a></p>';
echo '<p><strong>$_REQUEST array:</strong></p>';
echo "<p>snum: ";
echo $_REQUEST['snum'];
echo "</p><p>manuf: ";
echo $_REQUEST['manuf'];
echo "</p><p>start: ";
echo $_REQUEST['start'];
echo "</p><p>endt: ";
echo $_REQUEST['endt'];
echo "</p><p>patient: ";
echo $_REQUEST['patient'];
echo "</p>";
//for devices that were worn 
$stmt = $connection->prepare("SELECT snum, manuf, start, endt, patient FROM Wears as a WHERE snum <> :sn and manuf=:m and endt<NOW()
and endt >= all(select endt from Wears where snum = a.snum and endt<NOW());");
$stmt->bindParam(':m', $_REQUEST['manuf']);
$stmt->bindParam(':sn', $_REQUEST['snum']);
$stmt->execute();

//for devices never worn 
$stmt1 = $connection->prepare("SELECT distinct serialnum, manufacturer from Device, Wears where manufacturer = :m and serialnum NOT IN(select snum from Wears);");
$stmt1->bindParam(':m', $_REQUEST['manuf']);
$stmt1->execute();

echo '</div>';
echo '<div class="col-md-8">';
echo '<table class="table table-hover">';
echo '<tr><th>snum</th> <th>manuf</th> <th>start</th> <th>end</th></tr>';

foreach($stmt as $row)
{
	if ($row['endt'] < date("Y-m-d H:i:s")){
		echo '<tr>';
		echo '<td>' . $row['snum'] . '</td>' ;
		echo '<td>' . $row['manuf'] . '</td>' ;
		echo '<td>' . $row['start'] . '</td>' ;
		echo '<td>' . $row['endt'] . '</td>' ;
		echo("<td><a href=\"device_changed.php?snum=");
		echo($row['snum']);
		echo("&snumOld=");
		echo($_REQUEST['snum']);
		echo("&startOld=");
		echo($_REQUEST['start']);
		echo("&manuf=");
		echo($row['manuf']);
		echo("&start=");
		echo($row['start']);
		echo("&endt=");
		echo($row['endt']);
		echo("&patient=");
		echo($_REQUEST['patient']);
		echo("\">");
		echo '<button type="button">Select</button>';
		echo("<a/></td>");
		echo '</tr>';
	}
}
foreach($stmt1 as $row)
{
	echo '<tr>';
	echo '<td>' . $row['serialnum'] . '</td>' ;
	echo '<td>' . $row['manufacturer'] . '</td>' ;
	echo '<td> Never worn </td>' ;
	echo '<td> Never worn </td>' ;
	echo("<td><a href=\"device_changed.php?snum=");
	echo($row['serialnum']);
	echo("&snumOld=");
	echo($_REQUEST['snum']);
	echo("&startOld=");
	echo($_REQUEST['start']);
	echo("&manuf=");
	echo($row['manufacturer']);
	echo("&start=");
	echo(date("Y-m-d H:i:s", strtotime("100 years ago")));
	echo("&endt=");
	echo(date("Y-m-d H:i:s", strtotime("99 years ago")));
	echo("&patient=");
	echo($_REQUEST['patient']);
	echo("\">");
	echo '<button type="button">Select</button>';
	echo("<a/></td>");
	echo '</tr>';
}
echo '</table>';
echo '</div>';
echo '</div>';
//close connection
$connection = NULL;
?>
</body>
</html>